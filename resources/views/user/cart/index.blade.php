@extends('user.layout.app')

@section('title', 'Cart | Watch Store')

@section('content')
<div class="container py-4">

    <h3 class="text-center fw-bold mt-4">Keranjang Belanja</h3>
    <hr class="mx-auto" style="width: 80px; height: 3px; background-color:#C5A572; opacity:1;">

    {{-- Jika Cart Kosong --}}
    @if(!isset($cartData) || count($cartData) === 0)
    <div class="text-center my-5">
        <h4 class="fw-bold">Keranjang Masih Kosong</h4>
        <p class="text-muted">Yuk mulai belanja jam tangan favorit kamu!</p>

        <a href="{{ route('product.list') }}" class="btn btn-outline-dark px-4 py-2 rounded-pill">
            Lihat Semua Produk
        </a>
    </div>

    @else
    {{-- CART LIST --}}
    <div class="row gy-3">
        @foreach ($cartData as $item)
        <div class="col-12">
            <div class="card border-0 shadow-sm p-3 rounded-4 d-flex flex-row gap-3 align-items-start flex-wrap">

                {{-- IMAGE --}}
                <div style="width:90px; height:90px;" class="rounded overflow-hidden">
                    <img src="{{ $item['image'] }}"
                         class="w-100 h-100 object-fit-cover">
                </div>

                {{-- INFO --}}
                <div class="flex-grow-1">
                    <h6 class="fw-semibold mb-1">{{ $item['name'] }}</h6>
                    <p class="fw-bold mb-1">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>

                    <div class="d-flex align-items-center">

                        {{-- UPDATE QTY --}}
                    <form action="{{ route('user.cart.update') }}" 
                        method="POST" 
                        class="cart-update-form d-flex align-items-center me-3">
                        @csrf
                        <input type="hidden" name="id" value="{{ $item['id'] }}">
                        <input type="hidden" name="qty" value="{{ $item['qty'] }}" class="qty-hidden">

                        <div class="d-flex align-items-center">

                            <button type="button"
                                    class="btn btn-sm btn-outline-secondary px-3 btn-minus"
                                    @if($item['qty'] <= 1) disabled @endif>
                                -
                            </button>

                            <input type="number"
                                value="{{ $item['qty'] }}"
                                disabled
                                class="form-control form-control-sm text-center mx-2 rounded-pill qty-display"
                                style="width:60px;">

                            <button type="button"
                                    class="btn btn-sm btn-outline-secondary px-3 btn-plus">
                                +
                            </button>

                        </div>
                    </form>

                        {{-- HAPUS --}}
                        <form action="{{ route('user.cart.remove') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $item['id'] }}">
                            <button class="btn btn-sm btn-outline-danger">
                                Hapus
                            </button>
                        </form>
                    </div>

                    {{-- SUBTOTAL --}}
                    <p class="fw-semibold mt-2 mb-0">
                        Subtotal: <span class="text-dark">Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}</span>
                    </p>
                </div>

            </div>
        </div>
        @endforeach
    </div>

    {{-- TOTAL & CHECKOUT --}}
    <div class="card border-0 shadow-sm rounded-4 p-3 mt-4">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0">Total</h5>
            <h5 class="fw-bold mb-0 text-dark">Rp {{ number_format($total, 0, ',', '.') }}</h5>
        </div>

        <div class="mt-3 text-end">
            <a href="{{ route('user.checkout') }}" class="btn btn-dark btn-lg px-4 w-100 w-md-auto">
                Checkout
            </a>
        </div>
    </div>
    @endif
</div>


{{-- Rekomendasi Produk --}}
<div class="container my-5 text-center">

    <h3 class="fw-bold">Rekomendasi Untuk Kamu</h3>
    <p class="text-muted">Produk terbaik pilihan kami</p>

    <div class="row g-3 mt-3">
        @foreach($recommendedProducts->take(6) as $product)
        <div class="col-6 col-md-4 col-lg-2">
            <a href="{{ route('product.detail', ['id' => $product->id]) }}">
                <div class="card border-0 shadow-sm rounded-4 h-100">

                    <div class="ratio ratio-1x1">
                        <img src="{{ $product->image_url }}"
                             class="w-100 h-100 object-fit-cover rounded-top">
                    </div>

                    <div class="card-body p-2">
                        <h6 class="text-truncate mb-1">{{ $product->name }}</h6>
                        <p class="fw-bold mb-0">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>
                    </div>

                </div>
            </a>
        </div>
        @endforeach
    </div>

    <a href="{{ route('product.list') }}" class="btn btn-dark px-4 py-2 mt-4">
        Lihat Semua Jam
    </a>

</div>
@endsection
