@extends('admin.layout.app')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>All Reviews</h3>
                <p class="text-subtitle text-muted">A list of all product reviews.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">All Reviews</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">

            {{-- SEARCH & FILTER --}}
            <div class="card-header">
                <form method="GET" class="d-flex justify-content-between">

                    <div class="input-group w-50">
                        <input type="text" name="search" class="form-control" placeholder="Search comments..."
                            value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>

                    <div class="btn-group">
                        <button type="button" class="btn btn-light-primary dropdown-toggle" data-bs-toggle="dropdown">
                            Filter by Rating
                        </button>
                        <ul class="dropdown-menu">
                            @foreach ([5,4,3,2,1] as $rate)
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ request()->fullUrlWithQuery(['rating' => $rate]) }}">
                                        {{ $rate }} Stars
                                    </a>
                                </li>
                            @endforeach
                            <li><a class="dropdown-item" href="{{ url()->current() }}">Reset</a></li>
                        </ul>
                    </div>

                </form>
            </div>

            {{-- TABLE --}}
            <div class="card-body">

                <form action="{{ route('admin.reviews.bulkDelete') }}" method="POST">
                    @csrf

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="selectAll"></th>
                                <th>Product</th>
                                <th>Customer</th>
                                <th>Rating</th>
                                <th>Comment</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach ($reviews as $rev)
                            <tr>
                                <td>
                                    <input type="checkbox" name="ids[]" value="{{ $rev->id }}" class="selectItem">
                                </td>

                                <td>{{ $rev->product->name ?? 'Unknown Product' }}</td>

                                <td>{{ $rev->user->name ?? 'Unknown User' }}</td>

                                <td>
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $rev->rating)
                                            <i class="ti ti-star-filled text-warning"></i>
                                        @else
                                            <i class="ti ti-star"></i>
                                        @endif
                                    @endfor
                                </td>

                                <td>{{ $rev->comment }}</td>

                                <td>
                                    <form action="{{ route('admin.reviews.destroy', $rev->id) }}"
                                        method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>

                    <button type="submit" class="btn btn-danger mt-2">
                        Delete Selected
                    </button>

                </form>

                <div class="mt-3">
                    {{ $reviews->links() }}
                </div>

            </div>
        </div>
    </section>
</div>

{{-- SELECT ALL SCRIPT --}}
<script>
    document.getElementById('selectAll').onclick = function () {
        document.querySelectorAll('.selectItem')
            .forEach(cb => cb.checked = this.checked);
    }
</script>

@endsection
