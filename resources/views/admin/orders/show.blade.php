@extends('admin.layout.app')

@section('content')
<div class="page-heading">
    <h3>Order Detail</h3>
    <p class="text-muted">Detail order #{{ $order->id }}</p>
</div>

<section class="section">
    <div class="card">
        <div class="card-header">
            <h4>Order Summary</h4>
        </div>
        <div class="card-body">

        <p><strong>Payment Status:</strong> 
            @if($order->status === 'paid')
                <span class="badge bg-success">Paid</span>
            @elseif($order->status === 'unpaid')
                <span class="badge bg-danger">Unpaid</span>
            @elseif($order->status === 'pending')
                <span class="badge bg-warning">Pending</span>
            @elseif($order->status === 'processing')
                <span class="badge bg-primary">Processing</span>
            @elseif($order->status === 'shipped')
                <span class="badge bg-info text-dark">Shipped</span>
            @elseif($order->status === 'delivered')
                <span class="badge bg-success">Delivered</span>
            @elseif($order->status === 'cancelled')
                <span class="badge bg-secondary">Cancelled</span>
            @endif
        </p>

            {{-- ========================= --}}
            {{-- INFO DARI MIDTRANS TARO DI SINI --}}
            {{-- ========================= --}}

            @if($order->payment_id)
                <p><strong>Payment ID:</strong> {{ $order->payment_id }}</p>
            @endif

            @if($order->payment_type)
                <p><strong>Payment Type:</strong> {{ $order->payment_type }}</p>
            @endif

            @if($order->transaction_time)
                <p><strong>Paid At:</strong> {{ $order->transaction_time }}</p>
            @endif

            <hr>

            <h5>Items:</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderItems as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
        <hr>

        <div class="row px-3 pb-3">
            {{-- BAGIAN UPDATE STATUS --}}
            <div class="col-md-6">
                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <label class="form-label"><strong>Update Status</strong></label>
                    <select name="status" class="form-select" required>
                        <option value="pending" {{ $order->status=='pending'?'selected':'' }}>Pending</option>
                        <option value="paid" {{ $order->status=='paid'?'selected':'' }}>Paid</option>
                        <option value="processing" {{ $order->status=='processing'?'selected':'' }}>Processing</option>
                        <option value="shipped" {{ $order->status=='shipped'?'selected':'' }}>Shipped</option>
                        <option value="delivered" {{ $order->status=='delivered'?'selected':'' }}>Delivered</option>
                        <option value="cancelled" {{ $order->status=='cancelled'?'selected':'' }}>Cancelled</option>
                    </select>

                    <button class="btn btn-primary mt-2">Update</button>
                </form>
            </div>

            {{-- BAGIAN TOTAL PEMBAYARAN --}}
            <div class="col-md-6">
                <div class="p-3">
                    
                    <h5 class="mb-2">Total Pembayaran</h5>

                    @if (in_array($order->status, ['pending', 'unpaid']))
                        <span class="badge bg-secondary">Belum Dibayar</span>
                    @else
                        {{-- BREAKDOWN UNTUK STATUS PAID --}}
                        <div class="mt-2" style="border-radius: 8px;">
                            <p class="mb-1 d-flex justify-content-between">
                                <span>Subtotal</span>
                                <span>Rp {{ number_format($order->subtotal ?? $order->total_price, 0, ',', '.') }}</span>
                            </p>

                            @if($order->shipping_cost)
                                <p class="mb-1 d-flex justify-content-between">
                                    <span>Shipping</span>
                                    <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                                </p>
                            @endif

                            <hr>

                            <p class="mt-1 d-flex justify-content-between" style="font-size: 1.2rem; font-weight: 700;">
                                <span>Total Paid</span>
                                <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</section>
@endsection
