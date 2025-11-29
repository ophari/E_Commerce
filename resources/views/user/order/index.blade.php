@extends('user.layout.app')

@section('title', 'Riwayat Pesanan | Watch Store')

@section('content')
<div class="container py-4">
    <div class="order-history py-5">
        <div class="container">
            <h2 class="text-center text-dark fw-bold mb-4">Riwayat Pesanan</h2>

            {{-- ================================
                JIKA BELUM ADA PESANAN
            ================================= --}}
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

            {{-- ================================
                DESKTOP VERSION (TABEL)
            ================================= --}}
            <div class="table-responsive shadow rounded-4 order-table-wrapper d-none d-md-block">
                <table class="table table-hover align-middle text-center mb-0">
                    <thead style="background-color: #1A3C63; color: #fff;">
                        <tr>
                            <th scope="col">Order ID</th>
                            <th scope="col">Date</th>
                            <th scope="col">Total</th>
                            <th scope="col">Status</th>
                            <th scope="col">Details</th>
                            <th scope="col">Rate</th>
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
                                    @if($order['status']=='pending') bg-warning text-dark
                                    @elseif($order['status']=='completed') bg-success
                                    @elseif($order['status']=='cancelled') bg-danger
                                    @else bg-secondary
                                    @endif">
                                    {{ ucfirst($order['status']) }}
                                </span>
                            </td>

                            <td>
                                <button
                                    class="btn btn-sm btn-outline-dark rounded-pill px-3 py-1 fw-semibold view-order-btn d-inline-flex align-items-center"
                                    data-bs-toggle="modal"
                                    data-bs-target="#orderDetailModal"
                                    data-id="{{ $order['id'] }}">
                                    <i class="bi bi-eye me-1"></i> View
                                </button>
                            </td>

                            <td>
                                @if(strtolower($order['status']) === 'delivered')

                                    {{-- SUDAH ADA REVIEW --}}
                                    @if(isset($order['review']) && $order['review'])
                                        <button
                                            class="btn btn-sm btn-outline-primary rounded-pill edit-btn"
                                            data-order="{{ $order['id'] }}"
                                            data-product="{{ $order['items'][0]['product_id'] }}"
                                            data-rating="{{ $order['review']['rating'] }}"
                                            data-comment="{{ $order['review']['comment'] }}"
                                        >
                                            ✏️ Edit Review
                                        </button>

                                    {{-- BELUM REVIEW --}}
                                    @else
                                        <button
                                            class="btn btn-sm btn-outline-warning rounded-pill rate-btn"
                                            data-order="{{ $order['id'] }}"
                                            data-product="{{ $order['items'][0]['product_id'] }}"
                                        >
                                            ⭐ Rate
                                        </button>
                                    @endif

                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


            {{-- ================================
                MOBILE VERSION (CARD)
            ================================= --}}
            <div class="mobile-order-list d-block d-md-none mt-3">

                @foreach($orders as $order)
                <div class="order-card">

                    <h5>#{{ $order['id'] }}</h5>

                    <div class="order-row">
                        <span class="order-label">Date</span>
                        <span class="order-value">{{ \Carbon\Carbon::parse($order['created_at'])->format('d M Y') }}</span>
                    </div>

                    <div class="order-row">
                        <span class="order-label">Total</span>
                        <span class="order-value">
                            Rp {{ number_format($order['total'], 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="order-row">
                        <span class="order-label">Status</span>
                        <span class="order-value text-capitalize">{{ $order['status'] }}</span>
                    </div>

                    {{-- BUTTON VIEW --}}
                    <button
                        class="btn btn-outline-dark w-100 rounded-pill mt-2 view-order-btn"
                        data-bs-toggle="modal"
                        data-bs-target="#orderDetailModal"
                        data-id="{{ $order['id'] }}">
                        View
                    </button>

                    {{-- BUTTON RATE / EDIT --}}
                    @if(strtolower($order['status']) === 'delivered')

                        {{-- SUDAH ADA REVIEW --}}
                        @if(isset($order['review']) && $order['review'])
                            <button
                                class="btn btn-outline-primary w-100 rounded-pill mt-2 edit-btn"
                                data-order="{{ $order['id'] }}"
                                data-product="{{ $order['items'][0]['product_id'] }}"
                                data-rating="{{ $order['review']['rating'] }}"
                                data-comment="{{ $order['review']['comment'] }}"
                            >
                                ✏️ Edit Review
                            </button>

                        {{-- BELUM REVIEW --}}
                        @else
                            <button
                                class="btn btn-warning w-100 rounded-pill mt-2 rate-btn"
                                data-order="{{ $order['id'] }}"
                                data-product="{{ $order['items'][0]['product_id'] }}"
                            >
                                ⭐ Rate
                            </button>
                        @endif

                    @endif

                </div>
                @endforeach

            </div>

            @endif {{-- END IF HAS ORDER --}}

        </div>
    </div>
</div>



{{-- ================================
    MODAL — ORDER DETAILS
================================ --}}
<div class="modal fade" id="orderDetailModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content rounded-4 border-0 shadow">

      <div class="modal-header bg-dark text-white rounded-top-4">
        <h5 class="modal-title">Order Detail</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body p-4">
        <div id="orderDetailContent"></div>
      </div>

    </div>
  </div>
</div>


{{-- ================================
    MODAL — RATE
================================ --}}
<div class="modal fade" id="ratingModal" tabindex="-1">
  <div class="modal-dialog modal-md modal-dialog-centered">
    <div class="modal-content rounded-4">

      <div class="modal-header bg-dark text-white rounded-top-4">
        <h5 class="modal-title">Rate Your Product</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body p-4">

        <form id="ratingForm">
            <input type="hidden" name="order_id" id="ratingOrderId">
            <input type="hidden" name="product_id" id="ratingProductId">

            <div class="mb-3">
                <label class="fw-semibold mb-2">Rating</label>
                <div id="starContainer">
                    <span class="star" data-value="1">★</span>
                    <span class="star" data-value="2">★</span>
                    <span class="star" data-value="3">★</span>
                    <span class="star" data-value="4">★</span>
                    <span class="star" data-value="5">★</span>
                </div>

                <input type="hidden" name="rating" id="ratingValue">
            </div>

            <label class="fw-semibold mb-2">Comment (optional)</label>
            <textarea class="form-control mb-3" name="comment" id="ratingComment" rows="3"></textarea>

            <button type="submit" class="btn w-100 text-white" style="background:#C5A572;">
                Submit Review
            </button>
        </form>

      </div>

    </div>
  </div>
</div>

@endsection


@push('scripts')
    @include('user.order.script')
@endpush
