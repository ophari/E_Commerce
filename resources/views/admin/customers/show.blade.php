@extends('admin.layout.app')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Customer Details</h3>
                <p class="text-subtitle text-muted">Details of customer John Doe.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="#">Customers</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Customer Details</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Customer Information</h4>
                    </div>
                    <div class="card-body">
                        <p><strong>Name:</strong> {{ $customer->name }}</p>
                        <p><strong>Email:</strong> {{ $customer->email }}</p>
                        <p><strong>Phone:</strong> {{ $customer->phone ?? '-' }}</p>
                        <p><strong>Address:</strong> {{ $customer->address ?? '-' }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Order History</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                                <tbody>
                                    @forelse($customer->orders as $order)
                                        <tr>
                                            <td>#{{ $order->id }}</td>

                                            <td>
                                                <span class="badge 
                                                    @if($order->status == 'pending') bg-warning
                                                    @elseif($order->status == 'processing') bg-info
                                                    @elseif($order->status == 'shipped') bg-primary
                                                    @elseif($order->status == 'delivered') bg-success
                                                    @else bg-secondary
                                                    @endif">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>

                                            <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>

                                            <td>{{ $order->created_at->format('Y-m-d') }}</td>

                                            <td class="d-flex gap-1">
                                                {{-- Tombol View (kalau masih mau pakai halaman detail) --}}
                                                <a href="{{ route('admin.orders.show', $order->id) }}" 
                                                class="btn btn-sm btn-outline-secondary">
                                                    View
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">Belum ada pesanan</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
