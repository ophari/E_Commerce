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

            <p><strong>Customer:</strong> {{ $order->user->name }}</p>
            <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
            <p><strong>Total:</strong> Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
            <p><strong>Date:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>

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
    </div>
</section>
@endsection
