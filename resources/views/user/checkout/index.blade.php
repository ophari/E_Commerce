@extends('user.layout.app')

@section('title','Checkout')

@section('content')
<div class="container py-5">
    <h3 class="mb-4 fw-bold text-dark">Checkout</h3>
    <div class="row g-4">

        {{-- Form Checkout --}}
        <div class="col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title mb-3 fw-bold">Informasi Pengiriman</h5>
                    <form action="{{ route('user.order.confirm') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama</label>
                            <input type="text" name="name" class="form-control form-control-lg" placeholder="Masukkan nama lengkap" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Alamat</label>
                            <textarea name="address" class="form-control form-control-lg" rows="4" placeholder="Masukkan alamat lengkap" required></textarea>
                        </div>
                        <input type="hidden" name="payment" value="bank">
                        <button class="btn btn-success btn-lg w-100 fw-bold">Konfirmasi Pesanan</button>
                        
                        <button type="button" class="btn btn-outline-secondary btn-lg w-100 mt-2 fw-bold" onclick="window.location.href='{{ route('user.cart') }}'">
                            Batalkan Pesanan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Ringkasan Pesanan --}}
        <div class="col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title mb-3 fw-bold">Ringkasan Pesanan</h5>
                    @foreach($cart as $item)
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ $item['image'] }}" alt="" class="me-3 rounded" style="width:60px; height:60px; object-fit:cover;">
                            <div class="flex-grow-1">
                                <div class="fw-semibold">{{ $item['name'] }}</div>
                                <small class="text-muted">Qty: {{ $item['qty'] }}</small>
                            </div>
                            <div class="fw-bold">Rp{{ number_format($item['price'] * $item['qty'],0,',','.') }}</div>
                        </div>
                        <hr>
                    @endforeach
                    <div class="d-flex justify-content-between mt-3 fw-bold fs-5">
                        <span>Total</span>
                        <span>Rp{{ number_format($total,0,',','.') }}</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- Optional Custom CSS --}}
<style>
    body {
        background-color: #f8f9fa;
    }
    .card {
        border-radius: 12px;
    }
    .btn-success {
        background-color: #C5A572;
        border: none;
        transition: 0.3s;
    }
    .btn-success:hover {
        background-color: #ac8f61;
    }
    .form-control:focus {
        box-shadow: 0 0 0 0.2rem rgba(167, 144, 40, 0.25);
    }
</style>
@endsection
