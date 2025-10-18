<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // sample products (dummy). Later replace with DB model
    private function sampleProducts()
    {
        return collect([
            ['id'=>1,'name'=>'Classic Leather','brand'=>'Timeless','price'=>1250000,'stock'=>10,'image'=>'https://images.unsplash.com/photo-1518552987719-86fbcd8e9fd3?auto=format&fit=crop&w=800&q=80','type'=>'Classic'],
            ['id'=>2,'name'=>'Sport Runner','brand'=>'ActiveX','price'=>850000,'stock'=>25,'image'=>'https://images.unsplash.com/photo-1519741490576-20d3f3549b1d?auto=format&fit=crop&w=800&q=80','type'=>'Sport'],
            ['id'=>3,'name'=>'Minimal Silver','brand'=>'Elegance','price'=>950000,'stock'=>15,'image'=>'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=800&q=80','type'=>'Classic'],
            ['id'=>4,'name'=>'Digital Pro','brand'=>'Techix','price'=>650000,'stock'=>20,'image'=>'https://images.unsplash.com/photo-1517816743773-6e0fd518b4a6?auto=format&fit=crop&w=800&q=80','type'=>'Digital'],
            ['id'=>5,'name'=>'Gold Heritage','brand'=>'Regal','price'=>2250000,'stock'=>5,'image'=>'https://images.unsplash.com/photo-1519397154422-2b6c08d0f0d5?auto=format&fit=crop&w=800&q=80','type'=>'Luxury'],
            ['id'=>6,'name'=>'Urban Black','brand'=>'Metro','price'=>780000,'stock'=>18,'image'=>'https://images.unsplash.com/photo-1490367532201-b9bc1dc483f6?auto=format&fit=crop&w=800&q=80','type'=>'Sport'],
        ]);
    }

    public function home()
    {
        $featured = $this->sampleProducts()->take(4);
        return view('user.pages.home', compact('featured'));
    }

    public function list(Request $request)
    {
        $products = $this->sampleProducts();

        // simple filters (brand, type, max_price)
        if ($request->filled('brand')) {
            $products = $products->where('brand', $request->brand);
        }
        if ($request->filled('type')) {
            $products = $products->where('type', $request->type);
        }
        if ($request->filled('max_price')) {
            $products = $products->filter(fn($p) => $p['price'] <= (int)$request->max_price);
        }

        return view('user.pages.product-list', ['products' => $products->values()]);
    }

    public function show($id)
    {
        $product = $this->sampleProducts()->firstWhere('id', (int)$id);
        if (!$product) abort(404);
        // related = same brand or type
        $related = $this->sampleProducts()->filter(fn($p) => $p['id'] !== $product['id'])->take(4);
        return view('user.pages.product-detail', compact('product', 'related'));
    }
}
