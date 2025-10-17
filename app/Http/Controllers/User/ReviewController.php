<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, $productId)
    {
        // dummy store reviews in session
        $reviews = session('reviews', []);
        $reviews[] = [
            'product_id' => $productId,
            'user' => $request->post('user', 'Guest'),
            'rating' => (int)$request->post('rating', 5),
            'comment' => $request->post('comment', ''),
            'created_at' => now()->toDateTimeString(),
        ];
        session(['reviews' => $reviews]);
        return back()->with('success','Terima kasih atas ulasannya!');
    }
}
