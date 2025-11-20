<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    private function getOrCreateCart()
    {
        $userId = Auth::id();
        $cart = Cart::where('user_id', $userId)->first();

        if (!$cart) {
            $cart = Cart::create(['user_id' => $userId]);
        }

        return $cart;
    }

    public function index()
    {
        $cart = $this->getOrCreateCart();
        $cartItems = $cart->cartItems()->with('product')->get();

        $cartData = $cartItems->map(function($item) {
            return [
                'id' => $item->product->id,
                'name' => $item->product->name,
                'price' => $item->product->price,
                'qty' => $item->quantity,
                'image' => asset('image/' . $item->product->image_url),
            ];
        })->toArray();

        $total = collect($cartData)->map(fn($i) => $i['price'] * $i['qty'])->sum();

        // ⭐ Tambahkan produk rekomendasi
        $recommendedProducts = Product::inRandomOrder()->take(6)->get();

        return view('user.cart.index', compact(
            'cartData',
            'total',
            'recommendedProducts'
        ));
    }


    // add by POST id, name, price
    public function add(Request $request)
    {
        $productId = $request->post('id');
        $product = Product::find($productId);

        if (!$product) {
            return back()->with('error', 'Produk tidak ditemukan.');
        }

        if ($product->stock <= 0) {
            return back()->with('error', 'Stok produk habis.');
        }

        $cart = $this->getOrCreateCart();
        $cartItem = $cart->cartItems()->where('product_id', $productId)->first();

        if ($cartItem) {
            $newQty = $cartItem->quantity + 1;
            if ($newQty > $product->stock) {
                return back()->with('error', 'Stok tidak mencukupi.');
            }
            $cartItem->update(['quantity' => $newQty]);
        } else {
            if (1 > $product->stock) {
                return back()->with('error', 'Stok tidak mencukupi.');
            }
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $productId,
                'quantity' => 1,
            ]);
        }

        return back()->with('success','Produk ditambahkan ke keranjang.');
    }

    public function remove(Request $request)
    {
        $productId = $request->post('id');
        $cart = $this->getOrCreateCart();
        $cart->cartItems()->where('product_id', $productId)->delete();

        return back()->with('success','Produk dihapus dari keranjang.');
    }

    public function update(Request $request)
    {
        $productId = $request->post('id');
        $qty = max(1, (int)$request->post('qty'));

        $product = Product::find($productId);
        if (!$product) {
            return back()->with('error', 'Produk tidak ditemukan.');
        }

        if ($qty > $product->stock) {
            return back()->with('error', 'Stok tidak mencukupi.');
        }

        $cart = $this->getOrCreateCart();
        $cartItem = $cart->cartItems()->where('product_id', $productId)->first();

        if ($cartItem) {
            $cartItem->update(['quantity' => $qty]);
        }
        
        return back()->with('success','Keranjang diperbarui.');
    }
}
