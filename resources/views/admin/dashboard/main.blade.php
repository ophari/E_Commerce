@extends('admin.layout.app')
@section('content')
<div class="page-heading">
    <h3>Dashboard</h3>
</div>
<div class="page-content">
    <section class="row">
        <div class="col-12 col-lg-9">
            <div class="row">
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon purple mb-2">
                                        <i class="ti ti-shopping-cart"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">New Orders</h6>
                                    <h6 class="font-extrabold mb-0">150</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon blue mb-2">
                                        <i class="ti ti-users"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">New Customers</h6>
                                    <h6 class="font-extrabold mb-0">44</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon green mb-2">
                                        <i class="ti ti-package"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Total Products</h6>
                                    <h6 class="font-extrabold mb-0">5,200</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon red mb-2">
                                        <i class="ti ti-cash"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Total Revenue</h6>
                                    <h6 class="font-extrabold mb-0">$93,139</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Sales Report</h4>
                        </div>
                        <div class="card-body">
                            <div id="chart-profile-visit"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Latest Orders</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-lg">
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Customer</th>
                                            <th>Status</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="col-3">
                                                <p class="mb-0">OR9842</p>
                                            </td>
                                            <td class="col-auto">
                                                <p class="mb-0">John Doe</p>
                                            </td>
                                            <td>
                                                <span class="badge bg-success">Shipped</span>
                                            </td>
                                            <td>
                                                <p class="mb-0">$180.00</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-3">
                                                <p class="mb-0">OR1848</p>
                                            </td>
                                            <td class="col-auto">
                                                <p class="mb-0">Jane Doe</p>
                                            </td>
                                            <td>
                                                <span class="badge bg-warning">Pending</span>
                                            </td>
                                            <td>
                                                <p class="mb-0">$70.00</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-3">
                                                <p class="mb-0">OR7429</p>
                                            </td>
                                            <td class="col-auto">
                                                <p class="mb-0">Peter Jones</p>
                                            </td>
                                            <td>
                                                <span class="badge bg-danger">Delivered</span>
                                            </td>
                                            <td>
                                                <p class="mb-0">$35.00</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-3">
                                                <p class="mb-0">OR7429</p>
                                            </td>
                                            <td class="col-auto">
                                                <p class="mb-0">John Smith</p>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">Processing</span>
                                            </td>
                                            <td>
                                                <p class="mb-0">$399.00</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-3">
            <div class="card">
                <div class="card-header">
                    <h4>Recently Added Products</h4>
                </div>
                <div class="card-content pb-4">
                    <div class="recent-message d-flex px-4 py-3">
                        <div class="avatar avatar-lg">
                            <img src="{{ asset('assets/compiled/jpg/4.jpg') }}">
                        </div>
                        <div class="name ms-4">
                            <h5 class="mb-1">Rolex Submariner</h5>
                            <h6 class="text-muted mb-0">$15,000</h6>
                        </div>
                    </div>
                    <div class="recent-message d-flex px-4 py-3">
                        <div class="avatar avatar-lg">
                            <img src="{{ asset('assets/compiled/jpg/5.jpg') }}">
                        </div>
                        <div class="name ms-4">
                            <h5 class="mb-1">Omega Speedmaster</h5>
                            <h6 class="text-muted mb-0">$7,000</h6>
                        </div>
                    </div>
                    <div class="recent-message d-flex px-4 py-3">
                        <div class="avatar avatar-lg">
                            <img src="{{ asset('assets/compiled/jpg/1.jpg') }}">
                        </div>
                        <div class="name ms-4">
                            <h5 class="mb-1">Apple Watch Series 9</h5>
                            <h6 class="text-muted mb-0">$399</h6>
                        </div>
                    </div>
                    <div class="px-4">
                        <button class='btn btn-block btn-xl btn-outline-primary font-bold mt-3'>View All Products</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

