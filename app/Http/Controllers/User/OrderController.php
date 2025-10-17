<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function checkout()
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('user.home')->with('error','Keranjang kosong.');
        }
        $total = collect($cart)->map(fn($i) => $i['price'] * $i['qty'])->sum();
        return view('user.pages.checkout', compact('cart','total'));
    }

    public function confirm(Request $request)
    {
        $cart = session('cart', []);
        if (empty($cart)) return back()->with('error','Keranjang kosong.');

        // Simpan order di session sebagai dummy storage
        $orders = session('orders', []);
        $orderId = time();
        $orders[$orderId] = [
            'id' => $orderId,
            'items' => $cart,
            'total' => collect($cart)->map(fn($i) => $i['price'] * $i['qty'])->sum(),
            'status' => 'pending',
            'customer' => $request->post('name', 'Guest'),
            'created_at' => now()->toDateTimeString(),
        ];
        session(['orders' => $orders]);
        session()->forget('cart');

        return redirect()->route('user.orders')->with('success','Order berhasil dibuat (dummy).');
    }

    public function index()
    {
        $orders = session('orders', []);
        return view('user.pages.order-history', compact('orders'));
    }
}
