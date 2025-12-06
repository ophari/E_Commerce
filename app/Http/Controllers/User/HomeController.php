<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Review;

class HomeController extends Controller
{
    public function index()
    {
        // Semua brand
        $brands = Brand::all();

        // Best sellers → berdasarkan rating tertinggi
        $bestSellers = Product::with('brand')
            ->withAvg('reviews', 'rating')
            ->orderByDesc('reviews_avg_rating')
            ->take(9)
            ->get()
            ->map(function ($product) {
                $product->avg_rating = number_format($product->reviews_avg_rating ?? 0, 1);
                return $product;
            });

        // Produk terbaru
        $ourProducts = Product::latest()->take(8)->get();

        // Review pengguna (ambil 6 terbaru)
        $reviews = Review::with('user')
            ->latest()
            ->take(6)
            ->get();

        return view('user.pages.home', [
            'brands' => $brands,
            'bestSellers' => $bestSellers,
            'ourProducts' => $ourProducts,
            'reviews' => $reviews
        ]);
    }
}
