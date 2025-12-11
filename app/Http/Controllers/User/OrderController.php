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

    /**
     * Confirm checkout → simpan order → redirect ke Midtrans
     */
    public function confirm(Request $request)
    {
        $userId = Auth::id();
        $cartModel = Cart::where('user_id', $userId)->first();

        if (!$cartModel) {
            return back()->with('error', 'Keranjang kosong.');
        }

        $cartItems = $cartModel->cartItems()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Keranjang kosong.');
        }

        // Pastikan stok cukup
        foreach ($cartItems as $item) {
            if ($item->quantity > $item->product->stock) {
                return back()->with('error', "Stok {$item->product->name} tidak mencukupi.");
            }
        }

        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        /**
         * Buat order baru jika masih belum ada order unpaid
         */
        $order = Order::firstOrCreate(
            [
                'user_id' => $userId,
                'status'  => 'unpaid',
            ],
            [
                'total_price'      => $total,
                'shipping_address' => $request->post('address', ''),
                'invoice_number'   => 'INV-' . time() . '-' . $userId,
            ]
        );

        /**
         * Jika order baru dibuat → simpan order items & kurangi stok
         */
        if ($order->wasRecentlyCreated) {
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'price'      => $item->product->price,
                ]);

                // Kurangi stok
                $item->product->decrement('stock', $item->quantity);
            }

            // Hapus item dari cart
            $cartModel->cartItems()->delete();
        }

        // Hanya unpaid/pending boleh lanjut pembayaran
        if (!in_array($order->status, ['unpaid', 'pending'])) {
            return redirect()->route('user.orders')
                ->with('error', 'Order sudah dibayar atau sedang diproses.');
        }

        /**
         * MIDTRANS CONFIG
         */
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
                'first_name'   => Auth::user()->name,
                'email'        => Auth::user()->email,
            ],
        ];

        try {
            // Generate Snap Token
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            // Update status menjadi pending
            if ($order->status === 'unpaid') {
                $order->update(['status' => 'pending']);
            }

            return view('user.checkout.payment', compact('snapToken', 'order'));

        } catch (\Exception $e) {
            return redirect()->route('user.orders')
                ->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
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
}
