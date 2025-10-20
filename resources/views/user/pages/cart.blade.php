@extends('user.layout.app')

@section('title','Cart')

@section('content')
<h3>Keranjang</h3>
@if(empty($cart))
  <div class="alert alert-info">Keranjang kosong. <a href="{{ route('user.products') }}">Lihat produk</a></div>
@else
  <div class="table-responsive">
    <table class="table align-middle">
      <thead>
        <tr><th></th><th>Produk</th><th>Harga</th><th>Qty</th><th>Subtotal</th><th></th></tr>
      </thead>
      <tbody>
        @foreach($cart as $item)
        <tr>
          <td style="width:100px"><img src="{{ $item['image'] }}" alt="" class="img-fluid" style="height:60px;object-fit:cover"></td>
          <td>{{ $item['name'] }}</td>
          <td>Rp{{ number_format($item['price'],0,',','.') }}</td>
          <td style="width:120px">
            <form action="{{ route('user.cart.update') }}" method="POST" class="d-flex">
              @csrf
              <input type="hidden" name="id" value="{{ $item['id'] }}">
              <input type="number" name="qty" value="{{ $item['qty'] }}" min="1" class="form-control form-control-sm me-2">
              <button class="btn btn-sm btn-outline-secondary">OK</button>
            </form>
          </td>
          <td>Rp{{ number_format($item['price'] * $item['qty'],0,',','.') }}</td>
          <td>
            <form action="{{ route('user.cart.remove') }}" method="POST">
              @csrf
              <input type="hidden" name="id" value="{{ $item['id'] }}">
              <button class="btn btn-danger btn-sm">Hapus</button>
            </form>
          </td>
        </tr>
        @endforeach
        <tr>
          <td colspan="4" class="text-end fw-bold">Total</td>
          <td class="fw-bold">Rp{{ number_format($total,0,',','.') }}</td>
          <td></td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="d-flex justify-content-end">
    <a href="{{ route('user.checkout') }}" class="btn btn-dark">Checkout</a>
  </div>
@endif
@endsection
