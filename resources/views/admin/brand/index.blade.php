@extends('admin.layout.app')

@section('title', 'Brands')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Brands</h3>
                    <p class="text-subtitle text-muted">A list of all brands.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Brands</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createBrandModal">
                                Add Brand
                            </button>
                        </div>
                        <div class="col-md-6">
                            <form action="{{ route('admin.brand.index') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search by name or description" name="search" value="{{ request('search') }}">
                                    <button class="btn btn-outline-primary" type="submit">Search</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row" id="brands-container">
                        @foreach ($brands as $brand)
                            <div class="col-md-4" id="brand-card-{{ $brand->id }}">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $brand->name }}</h5>
                                        <p class="card-text">{{ $brand->description }}</p>
                                        <button type="button" class="btn btn-sm btn-primary edit-brand" data-id="{{ $brand->id }}" data-bs-toggle="modal" data-bs-target="#editBrandModal">Edit</button>
                                        <button type="button" class="btn btn-sm btn-danger delete-brand" data-id="{{ $brand->id }}">Delete</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-center">
                        {{ $brands->links() }}
                    </div>
                </div>
            </div>
        </section>
    </div>

    @include('admin.brand.modals.create')
    @include('admin.brand.modals.edit')
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        // Create Brand
        $('#createBrandForm').on('submit', function (e) {
            e.preventDefault();
            let formData = $(this).serialize();
            $.ajax({
                url: '{{ route('admin.brand.store') }}',
                type: 'POST',
                data: formData,
                success: function (response) {
                    $('#createBrandModal').modal('hide');
                    let newCard = '<div class="col-md-4" id="brand-card-' + response.brand.id + '"><div class="card"><div class="card-body"><h5 class="card-title">' + response.brand.name + '</h5><p class="card-text">' + response.brand.description + '</p><button type="button" class="btn btn-sm btn-primary edit-brand" data-id="' + response.brand.id + '" data-bs-toggle="modal" data-bs-target="#editBrandModal">Edit</button> <button type="button" class="btn btn-sm btn-danger delete-brand" data-id="' + response.brand.id + '">Delete</button></div></div></div>';
                    $('#brands-container').append(newCard);
                    Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                },
                error: function (response) {
                    // Handle error
                }
            });
        });

        // Edit Brand
        $(document).on('click', '.edit-brand', function () {
            let brandId = $(this).data('id');
            $.get('{{ url('admin/brand') }}/' + brandId + '/edit', function (data) {
                $('#edit_brand_id').val(data.id);
                $('#edit_name').val(data.name);
                $('#edit_description').val(data.description);
            });
        });

        $('#editBrandForm').on('submit', function (e) {
            e.preventDefault();
            let brandId = $('#edit_brand_id').val();
            let formData = $(this).serialize();
            $.ajax({
                url: '{{ url('admin/brand') }}/' + brandId,
                type: 'POST',
                data: formData,
                success: function (response) {
                    $('#editBrandModal').modal('hide');
                    let card = $('#brand-card-' + response.brand.id);
                    card.find('.card-title').text(response.brand.name);
                    card.find('.card-text').text(response.brand.description);
                    Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                },
                error: function (response) {
                    // Handle error
                }
            });
        });

        // Delete Brand
        $(document).on('click', '.delete-brand', function () {
            let brandId = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ url('admin/brand') }}/' + brandId,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'DELETE'
                        },
                        success: function (response) {
                            $('#brand-card-' + brandId).remove();
                            Swal.fire(
                                'Deleted!',
                                response.message,
                                'success'
                            )
                        },
                        error: function (response) {
                            // Handle error
                        }
                    });
                }
            })
        });
    });
</script>
@endpush
