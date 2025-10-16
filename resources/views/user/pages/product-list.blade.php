@extends('user.layout.app')

@section('title', 'Products')

@section('content')
<div class="row g-4">
  @foreach($products as $p)
    <div class="col-md-4">
      <div class="card h-100 shadow-sm">
        <img src="{{ asset('storage/' . $p->image_url) }}" class="card-img-top" alt="{{ $p->name }}">
        <div class="card-body d-flex flex-column">
          <h5 class="card-title">{{ $p->name }}</h5>
          <p class="text-muted mb-1">{{ $p->brand->name }}</p>
          <div class="fw-bold">Rp{{ number_format($p->price,0,',','.') }}</div>

          <form action="{{ route('user.cart.add') }}" method="POST" class="mt-3">
            @csrf
            <input type="hidden" name="id" value="{{ $p->id }}">
            <input type="hidden" name="name" value="{{ $p->name }}">
            <input type="hidden" name="price" value="{{ $p->price }}">
            <input type="hidden" name="image" value="{{ $p->image_url }}">
            <button class="btn btn-dark btn-sm">Tambah ke Keranjang</button>
            <a href="{{ route('user.product.show', $p->id) }}" class="btn btn-outline-secondary btn-sm ms-2">Detail</a>
          </form>
        </div>
      </div>
    </div>
  @endforeach
</div>
@endsection
