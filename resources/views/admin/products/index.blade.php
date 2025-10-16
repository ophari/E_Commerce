@extends('admin.layout.app')

@section('content')
<div class="container-fluid">

    <!-- Page Title and Create Button -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Products</h1>
        <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#createProductModal">
            <i class="ti ti-plus me-2"></i>Create New Product
        </button>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Filter and Search Section -->
    <div class="card shadow-sm mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter & Search</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.products.index') }}" method="GET">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="filter_search" class="form-label">Search</label>
                        <input type="text" name="search" id="filter_search" class="form-control"
                               placeholder="Search by name, model..." value="{{ $currentSearch }}">
                    </div>
                    <div class="col-md-3">
                        <label for="filter_brand_id" class="form-label">Brand</label>
                        <select name="brand_id" id="filter_brand_id" class="form-select">
                            <option value="">All Brands</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}" {{ $currentBrandId == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="filter_type" class="form-label">Type</label>
                        <select name="type" id="filter_type" class="form-select">
                            <option value="">All Types</option>
                            <option value="analog" {{ $currentType == 'analog' ? 'selected' : '' }}>Analog</option>
                            <option value="digital" {{ $currentType == 'digital' ? 'selected' : '' }}>Digital</option>
                            <option value="smartwatch" {{ $currentType == 'smartwatch' ? 'selected' : '' }}>Smartwatch</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex">
                        <button type="submit" class="btn btn-primary me-2">Apply</button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Clear</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Active Filters Display -->
    @if ($currentSearch || $currentBrandId || $currentType)
    <div class="alert  d-flex align-items-center justify-content-between mb-4">
        <div>
            <small class="text-muted me-2">Active Filters:</small>
            @if ($currentSearch) <span class="badge bg-primary me-1">Search: '{{ $currentSearch }}'</span> @endif
            @if ($currentBrandId) <span class="badge bg-info me-1">Brand: {{ $brands->firstWhere('id', $currentBrandId)->name ?? 'N/A' }}</span> @endif
            @if ($currentType) <span class="badge bg-warning me-1">Type: {{ ucfirst($currentType) }}</span> @endif
        </div>
        <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-danger">Clear All</a>
    </div>
    @endif

    <!-- Products Table -->
    <form action="{{ route('admin.products.bulkDestroy') }}" method="POST" id="bulk-delete-form">
        @csrf
        @method('DELETE')
        <div class="card shadow-sm">
            <div class="card-body">
                <div id="bulk-actions" class="mb-3" style="display: none;">
                    <button type="submit" class="btn btn-danger">Delete Selected</button>
                </div>
                <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th><input type="checkbox" id="select-all"></th>
                            <th>#</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Brand</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <td><input type="checkbox" name="selected_products[]" class="product-checkbox" value="{{ $product->id }}" data-product-name="{{ $product->name }}"></td>
                                <td>{{ $loop->iteration }}</td>
                                <td><img src="/image/{{ $product->image_url }}" width="60" class="rounded"></td>
                                <td>
                                    <div class="fw-bold">{{ $product->name }}</div>
                                    <small class="text-muted">{{ $product->model }}</small>
                                </td>
                                <td>{{ $product->brand->name }}</td>
                                <td><span class="badge bg-secondary">{{ ucfirst($product->type) }}</span></td>
                                <td>{{ 'Rp. ' . number_format($product->price, 0, ',', '.') }}</td>
                                <td>{{ $product->stock }}</td>
                                <td class="text-center">
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline">
                                        <a class="btn btn-icon btn-sm btn-outline-info" href="{{ route('admin.products.show', $product->id) }}" title="Show"><i class="ti ti-eye"></i></a>
                                        <a class="btn btn-icon btn-sm btn-outline-primary" href="{{ route('admin.products.edit', $product->id) }}" title="Edit"><i class="ti ti-pencil"></i></a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-icon btn-sm btn-outline-danger delete-btn" title="Delete"><i class="ti ti-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <p class="mb-0">No products found.</p>
                                    <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-info mt-2">Clear Filters</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>
        </div>
        <div class="card-footer">
            {!! $products->links() !!}
        </div>
    </div>
</div>

{{-- Create Modal --}}
@include('admin.products.partials.create')

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        const selectAll = $('#select-all');
        const checkboxes = $('.product-checkbox');
        const bulkActions = $('#bulk-actions');
        const bulkDeleteForm = $('#bulk-delete-form');

        selectAll.on('change', function() {
            checkboxes.prop('checked', $(this).prop('checked'));
            toggleBulkActions();
        });

        checkboxes.on('change', function() {
            if (!$(this).prop('checked')) {
                selectAll.prop('checked', false);
            }
            toggleBulkActions();
        });

        function toggleBulkActions() {
            if (checkboxes.filter(':checked').length > 0) {
                bulkActions.show();
            } else {
                bulkActions.hide();
            }
        }

        bulkDeleteForm.on('submit', function(e) {
            e.preventDefault();
            const selectedCheckboxes = checkboxes.filter(':checked');
            const selectedCount = selectedCheckboxes.length;

            if (selectedCount > 0) {
                let productNames = [];
                selectedCheckboxes.each(function() {
                    productNames.push($(this).data('product-name'));
                });

                Swal.fire({
                    title: `Are you sure you want to delete ${selectedCount} products?`,
                    html: `You are about to delete the following products:<br/><ul class="list-unstyled text-start">${productNames.map(name => `<li>- ${name}</li>`).join('')}</ul>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete them!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            }
        });
    });
</script>
@include('admin.products.partials.delete')
@endpush
