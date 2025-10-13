<!-- This file could be used for a delete confirmation modal or a dedicated delete page -->
<!-- For now, the delete functionality is handled directly in index.blade.php -->

@extends('admin.layout.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Delete Product Confirmation</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('admin.products.index') }}"> Back to Products</a>
                </div>
            </div>
        </div>

        <div class="alert alert-warning">
            <p>Are you sure you want to delete this product?</p>
            <!-- You might add product details here if this were a dedicated page -->
            <!-- <p><strong>Product Name:</strong> {{ $product->name ?? 'N/A' }}</p> -->
            <form action="{{ route('admin.products.destroy', $product->id ?? 'dummy_id') }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Confirm Delete</button>
            </form>
        </div>
    </div>
@endsection
