@extends('user.layout.app')

@section('title', 'Cart | Watch Store')

@section('content')
<div class="container py-4">
    <h3 class="text-dark mb-4 text-center mt-4 fw-bold">Keranjang Belanja</h3>
    <hr class="mx-auto" style="width: 80px; height: 3px; background-color: #C5A572; opacity: 1;">

    @if(!isset($cartData) || count($cartData) === 0)
    <div class="container text-center my-5 fade-up">
        <h4 class="fw-bold mb-2">Belanja Lagi?</h4>
        <p class="text-muted mb-3">Temukan jam tangan premium lainnya untuk melengkapi gaya kamu.</p>

        <a href="{{ route('product.list') }}" class="btn btn-outline-dark px-4 py-2 rounded-pill">
            Lihat Semua Produk
        </a>
    </div>
    @else
        <div class="table-responsive">
            <table class="table align-middle">
                <thead class="table-light">
                    <tr>
                        <th></th>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartData as $item)
                        <tr>
                            <td style="width:100px">
                                <img src="{{ $item['image'] }}"
                                     alt="{{ $item['name'] }}"
                                     class="img-fluid rounded shadow-sm"
                                     style="height:60px; object-fit:cover;">
                            </td>
                            <td class="fw-semibold">{{ $item['name'] }}</td>
                            <td>Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                            <td style="width:120px">
                                <form action="{{ route('user.cart.update') }}" method="POST" class="d-flex">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $item['id'] }}">
                                    <input type="number" name="qty" value="{{ $item['qty'] }}" min="1"
                                           class="form-control form-control-sm me-2 text-center">
                                    <button class="btn btn-sm btn-outline-secondary">OK</button>
                                </form>
                            </td>
                            <td class="fw-semibold">
                                Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}
                            </td>
                            <td>
                                <form action="{{ route('user.cart.remove') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $item['id'] }}">
                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    <tr class="table-secondary">
                        <td colspan="4" class="text-end fw-bold">Total</td>
                        <td class="fw-bold text-dark">Rp {{ number_format($total, 0, ',', '.') }}</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end mt-4">
            <a href="{{ route('user.checkout') }}" class="btn btn-lg btn-dark px-4">Checkout</a>
        </div>
    @endif
</div>

{{-- PREMIUM DIVIDER --}}
<div class="container my-5">
    <div class="luxury-divider mx-auto"></div>
</div>

{{-- REKOMENDASI PRODUK --}}
<div class="container text-center mobile-center my-5">
    <h3>Rekomendasi Untuk Kamu</h3>
    <p>Produk terbaik pilihan kami, mungkin cocok untuk kamu</p>


    <div class="row g-4">
        @foreach($recommendedProducts->take(6) as $product)
            <div class="col-6 col-md-4 col-lg-2">
                <div class="card border-0 shadow-sm h-100">

                    <div class="ratio ratio-1x1 bg-light">
                        <img src="{{ asset('image/' . $product->image_url) }}"
                             class="object-fit-cover w-100 h-100 rounded-top">
                    </div>

                    <div class="card-body p-2">
                        <h6 class="mb-1 text-dark text-truncate">{{ $product->name }}</h6>
                        <p class="fw-bold mb-0">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('product.list') }}" class="btn btn-dark px-4 py-2">
            Lihat Semua Jam
        </a>
    </div>
</div>
@endsection
