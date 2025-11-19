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
                        <form method="GET" action="{{ route('admin.customers.index') }}" class="w-50">
                            <div class="input-group w-100">
                                <input type="text" 
                                    name="search" 
                                    class="form-control" 
                                    placeholder="Search for customers..." 
                                    value="{{ request('search') }}">
                                <button class="btn btn-primary" type="submit">Search</button>
                            </div>
                        </form>
                        <div class="d-flex gap-2">
                            <div class="btn-group">
                                <button type="button" class="btn btn-light-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Filter
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('admin.customers.index', ['filter' => '30']) }}">Last 30 days</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.customers.index', ['filter' => '90']) }}">Last 90 days</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.customers.index') }}">All time</a></li>
                                </ul>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-light-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Bulk Actions
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item bulk-delete" href="#">Delete Selected</a></li>
                                    <li><a class="dropdown-item bulk-export" href="#">Export Selected</a></li>
                                </ul>
                            </div>
                            <button href="{{ route('admin.customers.export.csv') }}" type="button" class="btn btn-primary">Export CSV</button>
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
                            @foreach ($customers as $customer)
                                <tr>
                                    <td>
                                        <input type="checkbox" 
                                            value="{{ $customer->id }}" 
                                            class="form-check-input select-customer">
                                    </td>

                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->email }}</td>
                                    <td>{{ $customer->phone ?? '-' }}</td>

                                    <td>{{ $customer->orders_count }}</td>

                                    <td>
                                        <a href="{{ route('admin.customers.show', $customer->id) }}" 
                                        class="btn btn-sm btn-primary">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<script>
document.getElementById('select-all').addEventListener('click', function () {
    let check = this.checked;
    document.querySelectorAll('.select-customer').forEach(c => c.checked = check);
});

function getSelectedIds() {
    return [...document.querySelectorAll('.select-customer:checked')].map(e => e.value);
}

// Bulk Delete
document.querySelector('.bulk-delete').addEventListener('click', function () {
    let ids = getSelectedIds();
    if (ids.length === 0) return alert('No customer selected.');

    document.getElementById('bulk-ids').value = ids;
    let form = document.getElementById('bulk-form');
    form.action = "{{ route('admin.customers.bulk.delete') }}";
    form.submit();
});

// Bulk Export
document.querySelector('.bulk-export').addEventListener('click', function () {
    let ids = getSelectedIds();
    if (ids.length === 0) return alert('No customer selected.');

    document.getElementById('bulk-ids').value = ids;
    let form = document.getElementById('bulk-form');
    form.action = "{{ route('admin.customers.bulk.export') }}";
    form.submit();
});
</script>
@endsection