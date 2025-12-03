<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $reviews = Review::with(['user', 'product'])
            ->when($request->search, function($q) use ($request) {
                $q->where('comment', 'like', "%{$request->search}%");
            })
            ->when($request->rating, function($q) use ($request) {
                $q->where('rating', $request->rating);
            })
            ->latest()
            ->paginate(10);

        return view('admin.reviews.index', compact('reviews'));
    }

    public function bulkDelete(Request $request)
    {
        if (!$request->ids) {
            return back()->with('error', 'No reviews selected.');
        }

        Review::whereIn('id', $request->ids)->delete();

        return back()->with('success', 'Selected reviews deleted.');
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return back()->with('success', 'Review deleted.');
    }
}
