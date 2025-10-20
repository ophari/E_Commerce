@extends('user.layout.app')

@section('title', 'Order History | Watch Store')

@section('content')
<div class="order-history py-5">
    <div class="container">
        <h2 class="text-center fw-bold mb-4" style="color: #1A3C63;">Order History</h2>

        {{-- Jika belum ada pesanan --}}
        @if(empty($orders))
            <div class="text-center py-5 bg-light rounded-4 shadow-sm">
                <p class="text-muted mb-3 fs-5">You haven’t placed any orders yet.</p>
                <a href="{{ route('user.product.list') }}" 
                   class="btn btn-lg px-4 py-2 rounded-pill" 
                   style="background-color: #C5A572; color: #1A1A1A; font-weight: 600;">
                   Shop Now
                </a>
            </div>
        @else
            {{-- Jika ada pesanan --}}
            <div class="table-responsive shadow rounded-4">
                <table class="table table-hover align-middle text-center mb-0">
                    <thead style="background-color: #1A3C63; color: #fff;">
                        <tr>
                            <th scope="col">Order ID</th>
                            <th scope="col">Date</th>
                            <th scope="col">Total</th>
                            <th scope="col">Status</th>
                            <th scope="col">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td class="fw-semibold">#{{ $order['id'] }}</td>
                            <td>{{ \Carbon\Carbon::parse($order['created_at'])->format('d M Y') }}</td>
                            <td class="fw-semibold">Rp {{ number_format($order['total'], 0, ',', '.') }}</td>
                            <td>
                                <span class="badge px-3 py-2 
                                    @if($order['status'] == 'pending') bg-warning text-dark
                                    @elseif($order['status'] == 'completed') bg-success
                                    @elseif($order['status'] == 'cancelled') bg-danger
                                    @else bg-secondary
                                    @endif">
                                    {{ ucfirst($order['status']) }}
                                </span>
                            </td>
                            <td>
                                <a href="#" 
                                   class="btn btn-sm btn-outline-dark rounded-pill px-3 py-1 fw-semibold">
                                   View
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
