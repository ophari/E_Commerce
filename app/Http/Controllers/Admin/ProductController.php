<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Brand;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::query();

        // Search
        if ($search = $request->query('search')) {
            $products->where('name', 'like', "%$search%")
                     ->orWhere('model', 'like', "%$search%")
                     ->orWhere('description', 'like', "%$search%");
        }

        // Filter by Brand
        if ($brandId = $request->query('brand_id')) {
            $products->where('brand_id', $brandId);
        }

        // Filter by Type
        if ($type = $request->query('type')) {
            $products->where('type', $type);
        }

        // Sorting
        $sortBy = $request->query('sort_by', 'id');
        $sortOrder = $request->query('sort_order', 'desc');

        $products->orderBy($sortBy, $sortOrder);

        $products = $products->paginate(5)->appends($request->query());

        $brands = Brand::all();
        $currentSearch = $request->query('search');
        $currentBrandId = $request->query('brand_id');
        $currentType = $request->query('type');
        $currentSortBy = $sortBy;
        $currentSortOrder = $sortOrder;

        return view('admin.products.index', compact('products', 'brands', 'currentSearch', 'currentBrandId', 'currentType', 'currentSortBy', 'currentSortOrder'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = Brand::all();
        return view('admin.products.partials.create', compact('brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'name' => 'required',
            'model' => 'required',
            'type' => 'required|in:analog,digital,smartwatch',
            'price' => 'required|numeric',
            'description' => 'required',
            'image_url' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image_url_text' => 'nullable|url',
            'stock' => 'required|integer|min:0',
        ]);

        if ($image = $request->file('image_url')) {
            $destinationPath = 'image/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $validatedData['image_url'] = $profileImage;
        } elseif ($request->filled('image_url_text')) {
             $validatedData['image_url'] = $request->input('image_url_text');
        } else {
            return back()->withErrors(['image_url' => 'Please provide an image file or a valid URL.']);
        }

        // Remove the helper field
        unset($validatedData['image_url_text']);

        Product::create($validatedData);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('admin.products.partials.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $brands = Brand::all();
        return view('admin.products.partials.edit', compact('product', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'name' => 'required',
            'model' => 'required',
            'type' => 'required|in:analog,digital,smartwatch',
            'price' => 'required|numeric',
            'description' => 'required',
            'image_url' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image_url_text' => 'nullable|url',
            'stock' => 'required|integer|min:0',
        ]);

        if ($image = $request->file('image_url')) {
            $destinationPath = 'image/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $validatedData['image_url'] = $profileImage;
        } elseif ($request->filled('image_url_text')) {
            $validatedData['image_url'] = $request->input('image_url_text');
        } else {
            // Keep existing image if no new input
            unset($validatedData['image_url']);
        }
        
        unset($validatedData['image_url_text']);

        $product->update($validatedData);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully');
    }

    /**
     * Remove the specified resources from storage.
     */
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'selected_products' => 'required|array',
            'selected_products.*' => 'exists:products,id',
        ]);

        Product::destroy($request->input('selected_products'));

        return redirect()->route('admin.products.index')
            ->with('success', 'Selected products deleted successfully.');
    }
}