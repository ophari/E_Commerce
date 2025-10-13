<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('user.pages.product-list', compact('products'));
    }

    public function show($id)
    {
        $model = Product::findOrFail($id);
        $product = [
            'id' => $model->id,
            'name' => $model->name,
            'brand' => $model->brand,
            'type' => $model->type ?? 'Unknown',
            'price' => $model->price,
            'stock' => $model->stock ?? 0,
            'image' => $model->image_url,
        ];
        $related = Product::where('id', '!=', $id)->limit(4)->get()->map(function($p) {
            return [
                'image' => $p->image_url,
                'name' => $p->name,
            ];
        });
        return view('user.pages.product-detail', compact('product', 'related'));
    }
}
