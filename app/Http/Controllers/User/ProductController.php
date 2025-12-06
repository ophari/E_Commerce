<?php

namespace App\Http\Controllers\User;

use App\Models\Product;
use App\Models\Brand;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $query = Product::with('brand');

        if (request('brand')) {
            $query->where('brand_id', request('brand'));
        }

        $products = $query->get();
        $brands = Brand::all();
        return view('user.products.list', compact('products', 'brands'));
    }

    public function show($id)
    {
        $product = Product::with('brand')->findOrFail($id);

        $reviews = \App\Models\Review::with('user')
            ->where('product_id', $id)
            ->latest()
            ->get();

        $averageRating = \App\Models\Review::where('product_id', $id)
            ->avg('rating');

        $related = Product::where('brand_id', $product->brand_id)
                            ->where('id', '!=', $product->id)
                            ->take(4)
                            ->get();

        return view('user.products.detail', compact(
            'product',
            'related',
            'reviews',
            'averageRating'
        ));
    }

        public function search(Request $request)
        {
            $query = $request->input('q');

            $brands = Brand::all();
            $products = Product::where('name', 'like', '%' . $query . '%')->get();

            return view('user.products.list', compact('brands', 'products'))
                ->with('searchQuery', $query);
        }

}
