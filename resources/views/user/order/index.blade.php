@extends('user.layout.app')

@section('title', 'Riwayat Pesanan | Watch Store')

@section('content')
<div class="container py-4">
    <div class="order-history py-5">
        <div class="container">
            <h2 class="text-center text-dark fw-bold mb-4">Riwayat Pesanan</h2>

        {{-- Jika belum ada pesanan --}}
        @if(empty($orders))
            <div class="text-center py-5 bg-light rounded-4 shadow-sm">
                <p class="text-muted mb-3 fs-5">Kamu belum memesan apapun.</p>
                <a href="{{ route('product.list') }}" 
                   class="btn btn-lg px-4 py-2 rounded-pill" 
                   style="background-color: #C5A572; color: #1A1A1A; font-weight: 600;">
                   Belanja sekarang
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
                                <button
                                    class="btn btn-sm btn-outline-dark rounded-pill px-3 py-1 fw-semibold view-order-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#orderDetailModal"
                                    data-order="{{ htmlspecialchars(json_encode($order), ENT_QUOTES, 'UTF-8') }}">
                                    View
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

{{-- MODAL DETAIL PESANAN --}}
<div class="modal fade" id="orderDetailModal" tabindex="-1" aria-labelledby="orderDetailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header bg-dark text-white rounded-top-4">
        <h5 class="modal-title" id="orderDetailModalLabel">Order Detail</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4">
        <div id="orderDetailContent">
          <!-- Order details will be populated here -->
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.view-order-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const order = JSON.parse(this.dataset.order);

            const content = `
                <p><strong>Order ID:</strong> #${order.id}</p>
                <p><strong>Date:</strong> ${new Date(order.created_at).toLocaleDateString()}</p>
                <p><strong>Status:</strong> ${order.status}</p>
                <p><strong>Total:</strong> Rp ${Number(order.total).toLocaleString('id-ID')}</p>

                <hr>
                <h6 class="fw-bold">Product Details:</h6>
                <ul>
                    ${
                        order.items && order.items.length > 0
                        ? order.items.map(item => `
                            <li>${item.name} — Rp ${Number(item.price).toLocaleString('id-ID')} × ${item.qty}</li>
                        `).join('')
                        : '<li class="text-muted">No product details available</li>'
                    }
                </ul>
            `;

            document.getElementById('orderDetailContent').innerHTML = content;
        });
    });
});
</script>
@endpush
