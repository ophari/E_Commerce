<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function checkout(Request $request, $productId = null)
    {
        $userId = Auth::id();
        $cartModel = \App\Models\Cart::where('user_id', $userId)->first();

        if (!$cartModel) {
            return redirect()->route('user.cart')->with('error','Keranjang kosong.');
        }

        $cartItems = $cartModel->cartItems()->with('product')->get();

        // If POST request or productId in URL, add to cart temporarily for checkout
        if ($request->isMethod('post') || $productId) {
            $id = $productId ?: $request->post('id');
            $product = \App\Models\Product::find($id);
            if ($product) {
                // Check if product already in cart
                $existingItem = $cartItems->where('product_id', $id)->first();
                if (!$existingItem) {
                    \App\Models\CartItem::create([
                        'cart_id' => $cartModel->id,
                        'product_id' => $id,
                        'quantity' => 1,
                    ]);
                    $cartItems = $cartModel->cartItems()->with('product')->get();
                }
            }
        }

        if ($cartItems->isEmpty()) {
            return redirect()->route('user.cart')->with('error','Keranjang kosong.');
        }

        $cart = $cartItems->map(function($item) {
            return [
                'id' => $item->product->id,
                'name' => $item->product->name,
                'price' => $item->product->price,
                'qty' => $item->quantity,
                'image' => asset('image/' . $item->product->image_url),
            ];
        })->toArray();

        $total = collect($cart)->map(fn($i) => $i['price'] * $i['qty'])->sum();
        return view('user.checkout.index', compact('cart','total'));
    }

    public function confirm(Request $request)
    {
        $userId = Auth::id();
        $cartModel = \App\Models\Cart::where('user_id', $userId)->first();

        if (!$cartModel) {
            return back()->with('error','Keranjang kosong.');
        }

        $cartItems = $cartModel->cartItems()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error','Keranjang kosong.');
        }

        // Check stock availability
        foreach ($cartItems as $cartItem) {
            if ($cartItem->quantity > $cartItem->product->stock) {
                return back()->with('error', "Stok {$cartItem->product->name} tidak mencukupi.");
            }
        }

        // Calculate total
        $total = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        // Simpan order di database
        $order = Order::create([
            'user_id' => $userId,
            'total_price' => $total,
            'status' => 'pending',
            'shipping_address' => $request->post('address', ''),
        ]);

        // Simpan order items and update stock
        foreach ($cartItems as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->product->price,
            ]);

            // Reduce stock
            $cartItem->product->decrement('stock', $cartItem->quantity);
        }

        // Clear cart
        $cartModel->cartItems()->delete();

        return redirect()->route('user.orders')->with('success','Order berhasil dibuat.');
    }

    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login untuk melihat riwayat pesanan Anda.');
        }

        $userId = Auth::id();

        $orders = Order::with(['orderItems.product'])
            ->where('user_id', $userId)
            ->latest()
            ->get()
            ->map(function($order) use ($userId) {

                // review untuk product utama (asumsi order 1 product)
                $productId = $order->orderItems->first()->product_id ?? null;

                $review = Review::where('user_id', $userId)
                    ->where('product_id', $productId)
                    ->first();

                return [
                    'id'    => $order->id,
                    'items' => $order->orderItems->map(function($item) {
                        return [
                            'product_id' => $item->product_id,
                            'name'       => $item->product->name,
                            'price'      => $item->price,
                            'qty'        => $item->quantity,
                            'image_url'  => $item->product->image_url,
                        ];
                    })->toArray(),

                    'total'      => $order->total_price,
                    'status'     => $order->status,
                    'created_at' => $order->created_at->toDateTimeString(),

                    // kirim semua data review ke view
                    'review' => $review ? [
                        'rating'  => $review->rating,
                        'comment' => $review->comment,
                    ] : null
                ];
            })
            ->toArray();

        return view('user.order.index', compact('orders'));
    }


    public function show($id)
    {
        $order = Order::with('orderItems.product')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        $orderData = [
            'id' => $order->id,
            'created_at' => $order->created_at->toDateTimeString(),
            'status' => $order->status,
            'total' => $order->total_price,
            'items' => $order->orderItems->map(function ($item) {
                return [
                    'product_id' => $item->product_id,
                    'name' => $item->product->name,
                    'price' => $item->price,
                    'qty' => $item->quantity,
                    'image_url'  => $item->product->image_url,
                ];
            }),
        ];

        return response()->json($orderData);
    }
}
