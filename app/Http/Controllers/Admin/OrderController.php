<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user')->latest();

        // 🔍 Filter status (semua status baru termauk paid & unpaid) 
        if ($request->status && in_array($request->status, [
            'pending', 'unpaid', 'paid', 'processing', 'shipped', 'delivered', 'cancelled'
        ])) {
            $query->where('status', $request->status);
        }

        // 🔍 Filter date from
        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        // 🔍 Filter date to
        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // 📄 Pagination + keep filter
        $orders = $query->paginate(10)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['user', 'orderItems.product'])
            ->findOrFail($id);

        return view('admin.order.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $allowed = [
            'paid'       => ['processing'],
            'processing' => ['shipped'],
            'shipped'    => ['delivered'],
        ];

        $current = $order->status;
        $next    = $request->status;

        if (!isset($allowed[$current]) || !in_array($next, $allowed[$current])) {
            return back()->with('error', 'Perubahan status tidak valid.');
        }

        $order->update(['status' => $next]);

        return back()->with('success', 'Status pesanan diperbarui.');
    }
}


