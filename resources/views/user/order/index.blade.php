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
                DESKTOP VERSION (CARD LIST)
            ================================= --}}
            <div class="order-list-desktop d-none d-md-block">

                @foreach ($orders as $order)
                @php
                    $item  = $order['items'][0] ?? null;
                    // Simplify image logic for external URLs
                    $image = $item['image_url'] ?? $item['product']['image_url'] ?? asset('/image/no-image.png');
                @endphp

                <div class="order-card-desktop shadow-sm bg-white rounded-4 p-3 mb-3 d-flex">

                @if($item && !empty($item['product_id']))
                    <a href="{{ route('product.detail', $item['product_id']) }}" 
                    class="text-decoration-none text-dark d-flex me-3">
                @else
                    <div class="d-flex me-3">
                @endif

                    <img src="{{ $image }}"
                        class="rounded"
                        style="width:90px; height:90px; object-fit:cover;">

                @if($item && !empty($item['product_id']))
                    </a>
                @else
                    </div>
                @endif

                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between">
                            <h5 class="fw-bold">#{{ $order['id'] }}</h5>
                            <span class="text-muted">{{ \Carbon\Carbon::parse($order['created_at'])->format('d M Y') }}</span>
                        </div>

                        {{-- Nama produk --}}
                        @if($item && !empty($item['product_id']))
                            <a href="{{ route('product.detail', $item['product_id']) }}" 
                            class="text-decoration-none text-dark">
                                <p class="mb-1 fst-italic fw-semibold">
                                    {{ $item['name'] ?? 'Produk tidak ditemukan' }}
                                </p>
                            </a>
                        @else
                            <p class="mb-1 fst-italic fw-semibold text-muted">
                                {{ $item['name'] ?? 'Produk tidak ditemukan' }}
                            </p>
                        @endif

                        <span class="badge px-3 py-2 text-capitalize
                            @if($order['status']=='pending') bg-warning
                            @elseif($order['status']=='completed') bg-success
                            @elseif($order['status']=='delivered') bg-primary
                            @else bg-secondary
                            @endif">
                            {{ $order['status'] }}
                        </span>

                        <p class="fw-semibold mt-2">
                            Total: Rp {{ number_format($order['total'],0,',','.') }}
                        </p>
                    </div>

                    {{-- BUTTONS --}}
                    <div class="d-flex flex-column justify-content-center">

                        {{-- Lihat Detail --}}
                        <button
                            class="btn btn-outline-dark btn-sm rounded-pill mb-2 view-order-btn"
                            data-bs-toggle="modal"
                            data-bs-target="#orderDetailModal"
                            data-id="{{ $order['id'] }}">
                            Lihat Detail
                        </button>

                        {{-- Rating / Edit --}}
                        @if(strtolower($order['status']) === 'delivered')

                            @if(isset($order['review']))
                                <button
                                    class="btn btn-outline-primary btn-sm rounded-pill edit-btn"
                                    data-order="{{ $order['id'] }}"
                                    data-product="{{ $item['product_id'] ?? '' }}"
                                    data-rating="{{ $order['review']['rating'] }}"
                                    data-comment="{{ $order['review']['comment'] }}">
                                    ✏️ Edit Review
                                </button>
                            @else
                                <button
                                    class="btn btn-warning btn-sm rounded-pill rate-btn"
                                    data-order="{{ $order['id'] }}"
                                    data-product="{{ $item['product_id'] ?? '' }}">
                                    ⭐ Rate
                                </button>
                            @endif

                        @endif

                    </div>
                </div>
                @endforeach

            </div>


            {{-- ================================
                MOBILE VERSION
            ================================= --}}
            <div class="mobile-order-list d-block d-md-none mt-3">

                @foreach($orders as $order)
                @php
                    $item  = $order['items'][0] ?? null;
                    // Simplify image logic for external URLs
                    $image = $item['image_url'] ?? $item['product']['image_url'] ?? asset('/image/no-image.png');
                @endphp

                    <div class="order-card">

                        {{-- PRODUK IMAGE + NAME --}}
                        @if($item && !empty($item['product_id']))

                            {{-- Produk masih ada --}}
                            <a href="{{ route('product.detail', $item['product_id']) }}"
                            class="d-flex align-items-center mb-3 text-decoration-none text-dark">

                                <img src="{{ $image }}"
                                    class="rounded me-3"
                                    style="width:60px; height:60px; object-fit:cover;">

                                <p class="mb-0 fw-semibold">{{ $item['name'] }}</p>
                            </a>

                        @else

                            {{-- Produk sudah hilang --}}
                            <div class="d-flex align-items-center mb-3">
                                <img src="{{ asset('image/no-image.png') }}"
                                    class="rounded me-3"
                                    style="width:60px; height:60px; object-fit:cover;">

                                <p class="mb-0 text-muted">Produk sudah tidak tersedia</p>
                            </div>

                        @endif


                        {{-- ORDER ID --}}
                        <h5>#{{ $order['id'] }}</h5>

                        <div class="order-row">
                            <span class="order-label">Date</span>
                            <span class="order-value">
                                {{ \Carbon\Carbon::parse($order['created_at'])->format('d M Y') }}
                            </span>
                        </div>

                        <div class="order-row">
                            <span class="order-label">Total</span>
                            <span class="order-value">
                                Rp {{ number_format($order['total'],0,',','.') }}
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

                            @if(isset($order['review']))
                                <button
                                    class="btn btn-outline-primary w-100 rounded-pill mt-2 edit-btn"
                                    data-order="{{ $order['id'] }}"
                                    data-product="{{ $item['product_id'] ?? '' }}"
                                    data-rating="{{ $order['review']['rating'] }}"
                                    data-comment="{{ $order['review']['comment'] }}">
                                    ✏️ Edit Review
                                </button>
                            @else
                                <button
                                    class="btn btn-warning w-100 rounded-pill mt-2 rate-btn"
                                    data-order="{{ $order['id'] }}"
                                    data-product="{{ $item['product_id'] ?? '' }}">
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
    MODAL — RATE (+ Back to product)
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
