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
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">All Reviews</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Reviews</h4>
                <div class="mt-3">
                    <div class="d-flex justify-content-between">
                        <div class="input-group w-50">
                            <input type="text" class="form-control" placeholder="Search for reviews..." name="search">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="btn-group">
                                <button type="button" class="btn btn-light-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Filter by Rating
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">5 Stars</a></li>
                                    <li><a class="dropdown-item" href="#">4 Stars</a></li>
                                    <li><a class="dropdown-item" href="#">3 Stars</a></li>
                                    <li><a class="dropdown-item" href="#">2 Stars</a></li>
                                    <li><a class="dropdown-item" href="#">1 Star</a></li>
                                </ul>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-light-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Filter by Status
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Approved</a></li>
                                    <li><a class="dropdown-item" href="#">Pending</a></li>
                                </ul>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-light-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Bulk Actions
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Approve Selected</a></li>
                                    <li><a class="dropdown-item" href="#">Unapprove Selected</a></li>
                                    <li><a class="dropdown-item" href="#">Delete Selected</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"></th>
                            <th>Product</th>
                            <th>Customer</th>
                            <th>Rating</th>
                            <th>Comment</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"></td>
                            <td><a href="#">Rolex Submariner</a></td>
                            <td><a href="#">John Doe</a></td>
                            <td>
                                <i class="ti ti-star-filled"></i>
                                <i class="ti ti-star-filled"></i>
                                <i class="ti ti-star-filled"></i>
                                <i class="ti ti-star-filled"></i>
                                <i class="ti ti-star-filled"></i>
                            </td>
                            <td>Great watch!</td>
                            <td><span class="badge bg-success">Approved</span></td>
                            <td>
                                <a href="#"><i class="ti ti-thumb-up"></i></a>
                                <a href="#"><i class="ti ti-thumb-down"></i></a>
                                <a href="#"><i class="ti ti-trash"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"></td>
                            <td><a href="#">Omega Speedmaster</a></td>
                            <td><a href="#">Jane Doe</a></td>
                            <td>
                                <i class="ti ti-star-filled"></i>
                                <i class="ti ti-star-filled"></i>
                                <i class="ti ti-star-filled"></i>
                                <i class="ti ti-star-filled"></i>
                                <i class="ti ti-star"></i>
                            </td>
                            <td>I like it.</td>
                            <td><span class="badge bg-warning">Pending</span></td>
                            <td>
                                <a href="#"><i class="ti ti-thumb-up"></i></a>
                                <a href="#"><i class="ti ti-thumb-down"></i></a>
                                <a href="#"><i class="ti ti-trash"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
@endsection
