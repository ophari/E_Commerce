@extends('user.layout.app')

@section('title','Orders')

@section('content')
<h3>Riwayat Pesanan</h3>
@if(empty($orders))
  <div class="alert alert-info">Belum ada pesanan.</div>
@else
  @foreach($orders as $o)
    <div class="card mb-3">
      <div class="card-body">
        <div class="d-flex">
          <div>
            <div class="fw-bold">Order #{{ $o['id'] }}</div>
            <div class="text-muted small">Dibuat: {{ $o['created_at'] }}</div>
            <div>Status: <span class="badge bg-warning text-dark">{{ $o['status'] }}</span></div>
          </div>
          <div class="ms-auto text-end">
            <div class="fw-bold">Rp{{ number_format($o['total'],0,',','.') }}</div>
            <small>{{ $o['customer'] }}</small>
          </div>
        </div>

        <hr>
        @foreach($o['items'] as $it)
          <div class="d-flex mb-1">
            <div style="width:60px"><img src="{{ $it['image'] }}" class="img-fluid" style="height:40px;object-fit:cover"></div>
            <div class="ms-2">{{ $it['name'] }} <small class="text-muted">x{{ $it['qty'] }}</small></div>
            <div class="ms-auto">Rp{{ number_format($it['price'] * $it['qty'],0,',','.') }}</div>
          </div>
        @endforeach
      </div>
    </div>
  @endforeach
@endif
@endsection
