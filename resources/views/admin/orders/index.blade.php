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
                            @forelse ($orders as $order)
                                <tr>
                                    <td>{{ $order->order_number }}</td>

                                    <!-- Nama User -->
                                    <td>{{ $order->user->name ?? 'Unknown User' }}</td>

                                    <!-- Status Badge -->
                                    <td>
                                        @php
                                            $badge = match($order->status) {
                                                'pending' => 'bg-warning',
                                                'processing' => 'bg-info',
                                                'shipped' => 'bg-success',
                                                'delivered' => 'bg-primary',
                                                'cancelled' => 'bg-danger',
                                                default => 'bg-secondary'
                                            };
                                        @endphp
                                        <span class="badge {{ $badge }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>

                                    <td>${{ number_format($order->total_price, 2) }}</td>
                                    <td>{{ $order->created_at->format('Y-m-d') }}</td>

                                    <td>
                                        <a href="{{ route('admin.orders.show', $order->id) }}" 
                                        class="btn btn-primary btn-sm">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        No orders found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                </table>
            </div>

        </div>
    </section>
</div>
@endsection
