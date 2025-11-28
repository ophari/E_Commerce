<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required',
            'product_id' => 'required',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        // Pastikan order milik user & sudah delivered
        $order = Order::where('id', $request->order_id)
            ->where('user_id', Auth::id())
            ->where('status', 'delivered')
            ->firstOrFail();

        // Cek apakah produk ada dalam order
        $hasProduct = $order->orderItems()
            ->where('product_id', $request->product_id)
            ->exists();

        if (!$hasProduct) {
            return response()->json(['error' => 'Invalid product'], 403);
        }

        // Simpan atau update jika sudah pernah review
        Review::updateOrCreate(
            [
                'user_id'   => Auth::id(),
                'product_id'=> $request->product_id,
                'order_id'  => $request->order_id
            ],
            [
                'rating'    => $request->rating,
                'comment'   => $request->comment
            ]
        );

        return response()->json(['success' => true]);
    }
}
