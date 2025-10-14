@extends('admin.layout.app')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>All Customers</h3>
                <p class="text-subtitle text-muted">A list of all customers.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">All Customers</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Customers</h4>
                <div class="mt-3">
                    <div class="d-flex justify-content-between">
                        <div class="input-group w-50">
                            <input type="text" class="form-control" placeholder="Search for customers..." name="search">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="btn-group">
                                <button type="button" class="btn btn-light-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Filter
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Last 30 days</a></li>
                                    <li><a class="dropdown-item" href="#">Last 90 days</a></li>
                                    <li><a class="dropdown-item" href="#">All time</a></li>
                                </ul>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-light-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Bulk Actions
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Delete Selected</a></li>
                                    <li><a class="dropdown-item" href="#">Export Selected</a></li>
                                </ul>
                            </div>
                            <button type="button" class="btn btn-primary">Export CSV</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"></th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Total Orders</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"></td>
                            <td>John Doe</td>
                            <td>john.doe@example.com</td>
                            <td>+1234567890</td>
                            <td>5</td>
                            <td>
                                <a href="#"><i class="ti ti-eye"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"></td>
                            <td>Jane Doe</td>
                            <td>jane.doe@example.com</td>
                            <td>+1234567891</td>
                            <td>2</td>
                            <td>
                                <a href="#"><i class="ti ti-eye"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"></td>
                            <td>Peter Jones</td>
                            <td>peter.jones@example.com</td>
                            <td>+1234567892</td>
                            <td>10</td>
                            <td>
                                <a href="#"><i class="ti ti-eye"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"></td>
                            <td>John Smith</td>
                            <td>john.smith@example.com</td>
                            <td>+1234567893</td>
                            <td>1</td>
                            <td>
                                <a href="#"><i class="ti ti-eye"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
@endsection