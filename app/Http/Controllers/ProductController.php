<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $query = Product::with('brand');

        if (request('brand')) {
            $query->where('brand_id', request('brand'));
        }

        $products = $query->get();
        return view('user.pages.product-list', compact('products'));
    }

    public function show($id)
    {
        $product = Product::with('brand')->findOrFail($id);
        $related = Product::where('id', '!=', $id)->limit(4)->get()->map(function($p) {
            return [
                'image' => $p->image_url,
                'name' => $p->name,
            ];
        });
        return view('user.pages.product-detail', compact('product', 'related'));
    }
}
