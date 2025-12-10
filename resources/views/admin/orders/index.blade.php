@extends('admin.layout.app')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>All Orders</h3>
                <p class="text-subtitle text-muted">A list of all orders in the store.</p>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Orders</h4>
            </div>

            <div class="card-body">

                <form method="GET" class="row g-3 mb-4">
                    
                    <div class="col-md-3">
                        <label>Status</label>
                        <select name="status" class="form-select">
                            <option value="">-- All Status --</option>
                            <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
                            <option value="unpaid" {{ request('status')=='unpaid'?'selected':'' }}>Unpaid</option>
                            <option value="paid" {{ request('status')=='paid'?'selected':'' }}>Paid</option>
                            <option value="processing" {{ request('status')=='processing'?'selected':'' }}>Processing</option>
                            <option value="shipped" {{ request('status')=='shipped'?'selected':'' }}>Shipped</option>
                            <option value="delivered" {{ request('status')=='delivered'?'selected':'' }}>Delivered</option>
                            <option value="cancelled" {{ request('status')=='cancelled'?'selected':'' }}>Cancelled</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label>Date From</label>
                        <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                    </div>

                    <div class="col-md-3">
                        <label>Date To</label>
                        <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                    </div>

                    <div class="col-md-3 d-flex align-items-end">
                        <button class="btn btn-primary w-100">Filter</button>
                    </div>
                </form>

                <table class="table table-striped">
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
                        @forelse ($orders as $order)
                            <tr>
                                <td>{{ $order->order_number }}</td>
                                <td>{{ $order->user->name ?? 'Unknown User' }}</td>

                                <td>
                                @php
                                    $badge = match($order->status) {
                                        'pending'   => 'bg-warning',
                                        'unpaid'    => 'bg-danger',
                                        'paid'      => 'bg-success',
                                        'processing'=> 'bg-info',
                                        'shipped'   => 'bg-primary',
                                        'delivered' => 'bg-success',
                                        'cancelled' => 'bg-secondary',
                                        default     => 'bg-dark'
                                    };
                                @endphp
                                    <span class="badge {{ $badge }}">{{ ucfirst($order->status) }}</span>
                                </td>

                                <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                <td>{{ $order->created_at->format('Y-m-d') }}</td>

                                <td>
                                    <a href="{{ route('admin.orders.show', $order->id) }}"
                                        class="btn btn-primary btn-sm">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No orders found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- PAGINATION --}}
                <div class="mt-3">
                    {{ $orders->links() }}
                </div>

            </div>

        </div>
    </section>
</div>
@endsection
