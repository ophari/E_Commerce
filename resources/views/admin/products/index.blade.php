@extends('admin.layout.app')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>All Products</h3>
                <p class="text-subtitle text-muted">A list of all products in the store.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">All Products</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Products</h4>
                <div class="mt-3">
                    <div class="d-flex justify-content-between">
                        <div class="input-group w-50">
                            <input type="text" class="form-control" placeholder="Search for products..." name="search">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
                                Add New
                            </button>
                            <div class="btn-group">
                                <button type="button" class="btn btn-light-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Filter
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Brand</a></li>
                                    <li><a class="dropdown-item" href="#">Type</a></li>
                                    <li><a class="dropdown-item" href="#">Status</a></li>
                                </ul>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-light-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Bulk Actions
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Delete Selected</a></li>
                                    <li><a class="dropdown-item" href="#">Change Status</a></li>
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
                            <th><a href="#">Name <i class="ti ti-arrows-sort"></i></a></th>
                            <th><a href="#">Brand <i class="ti ti-arrows-sort"></i></a></th>
                            <th><a href="#">Price <i class="ti ti-arrows-sort"></i></a></th>
                            <th><a href="#">Stock <i class="ti ti-arrows-sort"></i></a></th>
                            <th><a href="#">Status <i class="ti ti-arrows-sort"></i></a></th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"></td>
                            <td>Rolex Submariner</td>
                            <td>Rolex</td>
                            <td>$15,000</td>
                            <td>10</td>
                            <td>
                                <span class="badge bg-success">Active</span>
                            </td>
                            <td>
                                <a href="#"><i class="ti ti-pencil"></i></a>
                                <a href="#"><i class="ti ti-trash"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"></td>
                            <td>Omega Speedmaster</td>
                            <td>Omega</td>
                            <td>$7,000</td>
                            <td>25</td>
                            <td>
                                <span class="badge bg-success">Active</span>
                            </td>
                            <td>
                                <a href="#"><i class="ti ti-pencil"></i></a>
                                <a href="#"><i class="ti ti-trash"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"></td>
                            <td>Apple Watch Series 9</td>
                            <td>Apple</td>
                            <td>$399</td>
                            <td>150</td>
                            <td>
                                <span class="badge bg-success">Active</span>
                            </td>
                            <td>
                                <a href="#"><i class="ti ti-pencil"></i></a>
                                <a href="#"><i class="ti ti-trash"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"></td>
                            <td>Casio G-Shock</td>
                            <td>Casio</td>
                            <td>$99</td>
                            <td>250</td>
                            <td>
                                <span class="badge bg-danger">Inactive</span>
                            </td>
                            <td>
                                <a href="#"><i class="ti ti-pencil"></i></a>
                                <a href="#"><i class="ti ti-trash"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <nav aria-label="Page navigation example">
                    <ul class="pagination pagination-primary">
                        <li class="page-item"><a class="page-link" href="#">Prev</a></li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item active"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </section>
</div>

<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="#" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" id="name" class="form-control" placeholder="Product Name" name="name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="brand">Brand</label>
                                    <select id="brand" class="form-select">
                                        <option value="">Select Brand</option>
                                        <option value="1">Rolex</option>
                                        <option value="2">Omega</option>
                                        <option value="3">Apple</option>
                                        <option value="4">Casio</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="model">Model</label>
                                    <input type="text" id="model" class="form-control" placeholder="Product Model" name="model">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type">Type</label>
                                    <select id="type" class="form-select">
                                        <option value="">Select Type</option>
                                        <option value="analog">Analog</option>
                                        <option value="digital">Digital</option>
                                        <option value="smartwatch">Smartwatch</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input type="number" id="price" class="form-control" placeholder="Price" name="price">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="stock">Stock</label>
                                    <input type="number" id="stock" class="form-control" placeholder="Stock" name="stock">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea id="description" class="form-control" rows="5" placeholder="Description"></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <input class="form-control" type="file" id="image">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
@endsection