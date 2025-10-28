@extends('user.layout.app')

@section('title', 'Cart | Watch Store')

@section('content')
<div class="container py-4">
    <h3 class="text-dark mb-4">Keranjang Belanja</h3>

    @if(!isset($cartData) || count($cartData) === 0)
        <div class="alert alert-info">
            Keranjang kosong. 
            <a href="{{ route('user.product.list') }}" class="fw-semibold text-dark">Lihat produk</a>
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
@endsection
