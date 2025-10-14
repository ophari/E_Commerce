@extends('admin.layout.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 margin-tb d-flex justify-content-between align-items-center">
            <div>
                <h2>Products</h2>
            </div>
            <div>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createProductModal">
                    Create New Product
                </button>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-3">
            <p>{{ $message }}</p>
        </div>
    @endif

    {{-- Filter Section --}}
    <div class="card mt-3">
        <div class="card-header">
            <h5 class="mb-0">Filter & Search</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.products.index') }}" method="GET" class="d-flex flex-wrap align-items-end">
                <div class="me-2 mb-2 flex-grow-1">
                    <label for="filter_search" class="sr-only">Search</label>
                    <div class="input-group">
                        <input type="text" name="search" id="filter_search" class="form-control"
                               placeholder="Search products..." value="{{ $currentSearch }}">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>

                <div class="me-2 mb-2" style="min-width: 150px;">
                    <label for="filter_brand_id">Brand</label>
                    <select name="brand_id" id="filter_brand_id" class="form-control">
                        <option value="">All Brands</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}" {{ $currentBrandId == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="me-2 mb-2" style="min-width: 150px;">
                    <label for="filter_type">Type</label>
                    <select name="type" id="filter_type" class="form-control">
                        <option value="">All Types</option>
                        <option value="analog" {{ $currentType == 'analog' ? 'selected' : '' }}>Analog</option>
                        <option value="digital" {{ $currentType == 'digital' ? 'selected' : '' }}>Digital</option>
                        <option value="smartwatch" {{ $currentType == 'smartwatch' ? 'selected' : '' }}>Smartwatch</option>
                    </select>
                </div>

                <div class="me-2 mb-2">
                    <button type="submit" class="btn btn-primary">Apply</button>
                </div>
                <div class="mb-2">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Clear</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Active Filters --}}
    @if ($currentSearch || $currentBrandId || $currentType)
        <div class="alert alert-info mt-3">
            <strong>Active Filters:</strong>
            @if ($currentSearch) Search: "{{ $currentSearch }}" @endif
            @if ($currentBrandId) Brand: {{ $brands->firstWhere('id', $currentBrandId)->name ?? 'N/A' }} @endif
            @if ($currentType) Type: {{ ucfirst($currentType) }} @endif
            <a href="{{ route('admin.products.index') }}" class="alert-link ms-2">Clear All</a>
        </div>
    @endif

    {{-- Product Table --}}
    <table class="table table-bordered table-striped mt-3 align-middle">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Image</th>
                <th>Brand</th>
                <th>Name</th>
                <th>Model</th>
                <th>Type</th>
                <th>Price</th>
                <th>Description</th>
                <th>Stock</th>
                <th width="220px">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td><img src="/image/{{ $product->image_url }}" width="80"></td>
                    <td>{{ $product->brand->name }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->model }}</td>
                    <td>{{ ucfirst($product->type) }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ Str::limit($product->description, 50) }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>
                        <form action="{{ route('admin.products.destroy',$product->id) }}" method="POST" class="d-inline">
                            <a class="btn btn-info btn-sm" href="{{ route('admin.products.show',$product->id) }}">Show</a>
                            <a class="btn btn-primary btn-sm" href="{{ route('admin.products.edit',$product->id) }}">Edit</a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm delete-btn">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {!! $products->links() !!}
</div>

{{-- Create Modal --}}
@include('admin.products.partials.create')

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>



@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.delete-btn').on('click', function(e) {
            e.preventDefault(); // Prevent the default form submission

            const form = $(this).closest('form'); // Get the parent form

            Swal.fire({
                title: 'Are you sure?',
                text: "You won\'t be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Submit the form if confirmed
                }
            });
        });
    });
</script>
@endpush
