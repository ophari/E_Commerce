@extends('admin.layout.app')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>All Orders</h3>
                <p class="text-subtitle text-muted">A list of all orders in the store.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">All Orders</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Orders</h4>
                <div class="mt-3">
                    <div class="d-flex justify-content-between">
                        <div class="input-group w-50">
                            <input type="text" class="form-control" placeholder="Search for orders..." name="search">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="btn-group">
                                <button type="button" class="btn btn-light-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Filter
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Status</a></li>
                                    <li><a class="dropdown-item" href="#">Date Range</a></li>
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
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>OR9842</td>
                            <td>John Doe</td>
                            <td><span class="badge bg-success">Shipped</span></td>
                            <td>$180.00</td>
                            <td>2023-10-12</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#orderDetailsModal">
                                    View
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>OR1848</td>
                            <td>Jane Doe</td>
                            <td><span class="badge bg-warning">Pending</span></td>
                            <td>$70.00</td>
                            <td>2023-10-11</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#orderDetailsModal">
                                    View
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>OR7429</td>
                            <td>Peter Jones</td>
                            <td><span class="badge bg-danger">Delivered</span></td>
                            <td>$35.00</td>
                            <td>2023-10-10</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#orderDetailsModal">
                                    View
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>OR7429</td>
                            <td>John Smith</td>
                            <td><span class="badge bg-info">Processing</span></td>
                            <td>$399.00</td>
                            <td>2023-10-09</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#orderDetailsModal">
                                    View
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<!-- Order Details Modal -->
<div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-labelledby="orderDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderDetailsModalLabel">Order Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <section class="section">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Order Items</h4>
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Rolex Submariner</td>
                                                <td>$15,000</td>
                                                <td>1</td>
                                                <td>$15,000</td>
                                            </tr>
                                            <tr>
                                                <td>Omega Speedmaster</td>
                                                <td>$7,000</td>
                                                <td>1</td>
                                                <td>$7,000</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Order Summary</h4>
                                </div>
                                <div class="card-body">
                                    <p><strong>Order ID:</strong> OR9842</p>
                                    <p><strong>Customer:</strong> John Doe</p>
                                    <p><strong>Date:</strong> 2023-10-12</p>
                                    <p><strong>Status:</strong> <span class="badge bg-success">Shipped</span></p>
                                    <hr>
                                    <p><strong>Subtotal:</strong> $22,000</p>
                                    <p><strong>Shipping:</strong> $50</p>
                                    <p><strong>Total:</strong> $22,050</p>
                                </div>
                                <div class="card-footer">
                                    <div class="d-grid gap-2">
                                        <button class="btn btn-primary" type="button">Update Status</button>
                                        <button class="btn btn-secondary" type="button">Print Invoice</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection
