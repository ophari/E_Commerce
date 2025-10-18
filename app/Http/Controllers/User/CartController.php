<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // show cart
    public function index()
    {
        $cart = session('cart', []);
        $total = collect($cart)->map(fn($i) => $i['price'] * $i['qty'])->sum();
        return view('user.pages.cart', compact('cart','total'));
    }

    // add by POST id, name, price
    public function add(Request $request)
    {
        $id = $request->post('id');
        $cart = session('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['qty'] += 1;
        } else {
            $cart[$id] = [
                'id' => $id,
                'name' => $request->post('name'),
                'price' => (int)$request->post('price'),
                'qty' => 1,
                'image' => $request->post('image'),
            ];
        }
        session(['cart' => $cart]);
        return back()->with('success','Produk ditambahkan ke keranjang.');
    }

    public function remove(Request $request)
    {
        $id = $request->post('id');
        $cart = session('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session(['cart' => $cart]);
        }
        return back()->with('success','Produk dihapus dari keranjang.');
    }

    public function update(Request $request)
    {
        $id = $request->post('id');
        $qty = max(1, (int)$request->post('qty'));
        $cart = session('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['qty'] = $qty;
            session(['cart' => $cart]);
        }
        return back()->with('success','Keranjang diperbarui.');
    }
}
