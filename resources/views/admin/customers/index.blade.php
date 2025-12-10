@extends('admin.layout.app')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>All Customers</h3>
                <p class="text-subtitle text-muted">A list of all customers.</p>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">

            <div class="card-header">
                <h4 class="card-title">Customers</h4>

                <div class="mt-3 d-flex justify-content-between">

                    {{-- Search --}}
                    <form method="GET" action="{{ route('admin.customers.index') }}" class="w-50">
                        <div class="input-group w-100">
                            <input type="text" name="search" class="form-control"
                                   placeholder="Search customers..."
                                   value="{{ request('search') }}">
                            <button class="btn btn-primary">Search</button>
                        </div>
                    </form>

                    {{-- Buttons --}}
                    <div class="d-flex gap-2">

                        {{-- Filter --}}
                        <div class="btn-group">
                            <button type="button" class="btn btn-light-primary dropdown-toggle" 
                                    data-bs-toggle="dropdown">
                                Filter
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('admin.customers.index', ['filter'=>'30']) }}">Last 30 days</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.customers.index', ['filter'=>'90']) }}">Last 90 days</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.customers.index') }}">All time</a></li>
                            </ul>
                        </div>

                        {{-- Bulk --}}
                        <div class="btn-group">
                            <button type="button" class="btn btn-light-primary dropdown-toggle"
                                    data-bs-toggle="dropdown">
                                Bulk Actions
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item bulk-delete" href="#">Delete Selected</a></li>
                                <li><a class="dropdown-item bulk-export" href="#">Export Selected</a></li>
                            </ul>
                        </div>

                        {{-- Export All --}}
                        <a href="{{ route('admin.customers.export.csv') }}" class="btn btn-primary">
                            Export CSV
                        </a>
                    </div>
                </div>
            </div>

            {{-- TABLE --}}
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><input id="select-all" class="form-check-input" type="checkbox"></th>
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
                                <td><input type="checkbox" value="{{ $customer->id }}" class="form-check-input select-customer"></td>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->phone ?? '-' }}</td>
                                <td>{{ $customer->orders_count }}</td>

                                <td>
                                    <a href="{{ route('admin.customers.show', $customer->id) }}" 
                                       class="btn btn-primary btn-sm">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Hidden form for bulk --}}
                <form id="bulk-form" method="POST">
                    @csrf
                    <input type="hidden" name="ids" id="bulk-ids">
                </form>
            </div>

        </div>
    </section>
</div>

{{-- JS --}}
<script>
document.getElementById('select-all').addEventListener('click', function () {
    document.querySelectorAll('.select-customer')
            .forEach(c => c.checked = this.checked);
});

function getSelectedIds() {
    return [...document.querySelectorAll('.select-customer:checked')]
        .map(e => e.value);
}

document.querySelector('.bulk-delete').addEventListener('click', function () {
    let ids = getSelectedIds();
    if (ids.length === 0) return alert('No customers selected.');

    document.getElementById('bulk-ids').value = ids;
    let form = document.getElementById('bulk-form');
    form.action = "{{ route('admin.customers.bulk.delete') }}";
    form.submit();
});

document.querySelector('.bulk-export').addEventListener('click', function () {
    let ids = getSelectedIds();
    if (ids.length === 0) return alert('No customers selected.');

    document.getElementById('bulk-ids').value = ids;
    let form = document.getElementById('bulk-form');
    form.action = "{{ route('admin.customers.bulk.export') }}";
    form.submit();
});
</script>
@endsection
