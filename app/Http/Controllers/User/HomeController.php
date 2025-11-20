<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Brand;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::with('brand')->get()->map(function($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'brand' => $product->brand ? $product->brand->name : 'Unknown',
                'price' => $product->price,
                'image' => $product->image_url,
            ];
        });

        $brands = Brand::all();

        // Get products grouped by brand
        $productsByBrand = [];
        foreach ($brands as $brand) {
            $products = Product::where('brand_id', $brand->id)->take(4)->get()->map(function($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'image' => $product->image_url,
                ];
            });
            if ($products->count() > 0) {
                $productsByBrand[] = [
                    'brand' => $brand,
                    'products' => $products,
                ];
            }
        }

        $bestSellers = Product::with('brand')->take(8)->get();

        $ourProducts = Product::latest()->take(8)->get();

        return view('user.pages.home', [
            'brands' => $brands,
            'bestSellers' => $bestSellers,
            'ourProducts' => $ourProducts
        ]);


        return view('user.pages.home', compact('brands', 'productsByBrand', 'products', 'bestSellers'));
    }
}
