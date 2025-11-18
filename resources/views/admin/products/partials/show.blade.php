@extends('admin.layout.app')

@section('content')
<div class="container-fluid">

    <!-- Page Title & Back Button -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Product Details</h1>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-primary">
            <i class="ti ti-arrow-left me-2"></i> Back to Products
        </a>
    </div>

    <div class="row">
        <!-- Product Image -->
        <div class="col-md-5">
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <img src="/storage/image/{{ $product->image_url }}" alt="{{ $product->name }}" class="img-fluid rounded" style="max-height: 400px;">
                </div>
            </div>
        </div>

        <!-- Product Details -->
        <div class="col-md-7">
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3">
                    <h4 class="m-0 font-weight-bold text-primary">{{ $product->name }}</h4>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <strong>Brand</strong>
                            <span>{{ $product->brand->name }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <strong>Model</strong>
                            <span>{{ $product->model }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <strong>Type</strong>
                            <span class="badge bg-secondary">{{ ucfirst($product->type) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <strong>Price</strong>
                            <span class="h5 mb-0 text-success">${{ number_format($product->price, 2) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <strong>Stock</strong>
                            @if($product->stock > 10)
                                <span class="badge bg-success">In Stock</span>
                            @elseif($product->stock > 0)
                                <span class="badge bg-warning">Low Stock</span>
                            @else
                                <span class="badge bg-danger">Out of Stock</span>
                            @endif
                        </li>
                    </ul>

                    <hr>

                    <h5>Description</h5>
                    <p class="text-muted">{{ $product->description }}</p>
                </div>
                <div class="card-footer text-end">
                    <a class="btn btn-primary" href="{{ route('admin.products.edit', $product->id) }}">
                        <i class="ti ti-pencil me-2"></i>Edit Product
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
