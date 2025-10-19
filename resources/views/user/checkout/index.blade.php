@extends('user.layout.app')

@section('title','Checkout')

@section('content')
<h3>Checkout</h3>
<div class="row">
  <div class="col-md-6">
    <form action="{{ route('user.order.confirm') }}" method="POST">
      @csrf
      <div class="mb-3">
        <label class="form-label">Nama</label>
        <input type="text" name="name" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Alamat</label>
        <textarea name="address" class="form-control" rows="3" required></textarea>
      </div>
      <div class="mb-3">
        <label class="form-label">Metode Pembayaran</label>
        <select name="payment" class="form-select">
          <option value="cod">COD</option>
          <option value="bank">Transfer Bank</option>
        </select>
      </div>

      <button class="btn btn-primary">Konfirmasi Pesanan</button>
    </form>
  </div>

  <div class="col-md-6">
    <h5>Ringkasan Pesanan</h5>
    @foreach($cart as $item)
      <div class="d-flex mb-2">
        <img src="{{ $item['image'] }}" alt="" style="height:60px;width:60px;object-fit:cover" class="me-2">
        <div>
          <div>{{ $item['name'] }}</div>
          <small>Qty: {{ $item['qty'] }}</small>
        </div>
        <div class="ms-auto">Rp{{ number_format($item['price'] * $item['qty'],0,',','.') }}</div>
      </div>
    @endforeach
    <hr>
    <div class="fw-bold">Total: Rp{{ number_format($total,0,',','.') }}</div>
  </div>
</div>
@endsection
