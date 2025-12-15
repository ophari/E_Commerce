<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Halaman Checkout (tampilkan list barang)
     */
    public function checkout(Request $request, $productId = null)
    {
        $userId = Auth::id();
        $cartModel = Cart::where('user_id', $userId)->first();

        if (!$cartModel) {
            return redirect()->route('user.cart')->with('error', 'Keranjang kosong.');
        }

        // Ambil semua item di keranjang
        $cartItems = $cartModel->cartItems()->with('product')->get();

        /**
         * Jika user klik "Buy Now" (beli satu item)
         * atau submit POST dari halaman lain
         */
        if ($request->isMethod('post') || $productId) {
            $id = $productId ?: $request->post('id');
            $product = Product::find($id);

            if ($product) {
                $existingItem = $cartItems->where('product_id', $id)->first();

                // Tambahkan produk baru ke cart jika belum ada
                if (!$existingItem) {
                    CartItem::create([
                        'cart_id'    => $cartModel->id,
                        'product_id' => $id,
                        'quantity'   => 1,
                    ]);

                    // Reload cart items
                    $cartItems = $cartModel->cartItems()->with('product')->get();
                }
            }
        }

        if ($cartItems->isEmpty()) {
            return redirect()->route('user.cart')->with('error', 'Keranjang kosong.');
        }

        // Map cart
        $cart = $cartItems->map(function ($item) {
            return [
                'id'    => $item->product->id,
                'name'  => $item->product->name,
                'price' => $item->product->price,
                'qty'   => $item->quantity,
                'image' => $item->product->image_url,
            ];
        })->toArray();

        $total = collect($cart)->sum(fn($i) => $i['price'] * $i['qty']);

        return view('user.checkout.index', compact('cart', 'total'));
    }

    public function confirm(Request $request)
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->firstOrFail();
        $cartItems = $cart->cartItems()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('user.cart')->with('error', 'Keranjang kosong.');
        }

        // Hitung total
        $total = $cartItems->sum(fn ($i) => $i->product->price * $i->quantity);

        // BUAT ORDER DULU
        $order = Order::create([
            'user_id'          => $user->id,
            'invoice_number'   => 'INV-' . time() . '-' . $user->id,
            'total_price'      => $total,
            'shipping_address' => $request->address,
            'status'           => 'unpaid',
        ]);

        // BUAT ORDER ITEMS
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $item->product_id,
                'quantity'   => $item->quantity,
                'price'      => $item->product->price,
            ]);
        }

        // MIDTRANS
        \Midtrans\Config::$serverKey    = config('services.midtrans.server_key');
        \Midtrans\Config::$isProduction = config('services.midtrans.is_production');
        \Midtrans\Config::$isSanitized  = true;
        \Midtrans\Config::$is3ds        = true;

        $params = [
            'transaction_details' => [
                'order_id'     => $order->invoice_number,
                'gross_amount' => (int) $order->total_price,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email'      => $user->email,
            ],
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return view('user.checkout.payment', compact('snapToken', 'order'));
    }

    /**
     * Halaman daftar riwayat order user
     */
    public function index()
    {
        $userId = Auth::id();

        $orders = Order::with('orderItems.product')
            ->where('user_id', $userId)
            ->latest()
            ->get()
            ->map(function ($order) use ($userId) {

                $productId = $order->orderItems->first()->product_id ?? null;

                $review = Review::where('user_id', $userId)
                    ->where('product_id', $productId)
                    ->first();

                return [
                    'id'             => $order->id,
                    'invoice_number' => $order->invoice_number,
                    'items'          => $order->orderItems->map(fn($item) => [
                        'product_id' => $item->product_id,
                        'name'       => $item->product->name,
                        'price'      => $item->price,
                        'qty'        => $item->quantity,
                        'image_url'  => $item->product->image_url,
                    ])->toArray(),
                    'total'      => $order->total_price,
                    'status'     => $order->status,
                    'created_at' => $order->created_at->toDateTimeString(),
                    'review'     => $review ? [
                        'rating'  => $review->rating,
                        'comment' => $review->comment,
                    ] : null,
                ];
            })
            ->toArray();

        return view('user.order.index', compact('orders'));
    }

    /**
     * Menampilkan detail order (format JSON)
     */
    public function show($id)
    {
        $order = Order::with('orderItems.product')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return response()->json([
            'id'         => $order->id,
            'created_at' => $order->created_at->toDateTimeString(),
            'status'     => $order->status,
            'total'      => $order->total_price,
            'items'      => $order->orderItems->map(fn($i) => [
                'product_id' => $i->product_id,
                'name'       => $i->product->name,
                'price'      => $i->price,
                'qty'        => $i->quantity,
                'image_url'  => $i->product->image_url,
            ]),
        ]);
    }

    /**
     * Hapus order (hanya unpaid atau cancelled)
     */
    public function delete($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if (!in_array($order->status, ['unpaid', 'cancelled'])) {
            return back()->with('error', 'Pesanan tidak bisa dihapus.');
        }

        $order->delete();

        return back()->with('success', 'Pesanan berhasil dihapus.');
    }

    /**
     * Cek status pembayaran ke Midtrans (Manual/Redirect)
     */
    public function checkStatus($id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);

        if ($order->status === 'paid') {
            return redirect()->route('user.orders')->with('success', 'Pesanan sudah dibayar.');
        }

        // Config Midtrans
        \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
        \Midtrans\Config::$isProduction = config('services.midtrans.is_production');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        try {
            $status = \Midtrans\Transaction::status($order->invoice_number);
            
            // Jika status paid/settlement
            if (in_array($status->transaction_status, ['capture', 'settlement'])) {
                
                $order->update(['status' => 'paid']);

                // Kurangi stok
                foreach ($order->orderItems as $item) {
                    Product::where('id', $item->product_id)
                        ->decrement('stock', $item->quantity);
                }

                // Hapus cart (jika masih ada sisa, optional)
                Cart::where('user_id', $order->user_id)->delete();

                return redirect()->route('user.orders')->with('success', 'Pembayaran berhasil dikonfirmasi!');
            } 
            else if ($status->transaction_status === 'pending') {
                return redirect()->route('user.orders')->with('info', 'Pembayaran masih pending, silakan selesaikan.');
            }
            else if (in_array($status->transaction_status, ['expire', 'cancel', 'deny'])) {
                $order->update(['status' => 'cancelled']);
                return redirect()->route('user.orders')->with('error', 'Pembayaran gagal atau kadaluarsa.');
            }

        } catch (\Exception $e) {
            return redirect()->route('user.orders')->with('error', 'Belum ada transaksi ditemukan atau gagal cek status.');
        }

        return redirect()->route('user.orders');
    }
}
