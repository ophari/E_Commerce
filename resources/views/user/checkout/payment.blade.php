@extends('user.layout.app')

@section('title', 'Payment')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">

                    <h4 class="mb-3">Selesaikan Pembayaran</h4>

                    {{-- TOTAL DIAMBIL DARI SESSION --}}
                    <h2 class="fw-bold mb-4" style="color: #C5A572;">
                        Rp{{ number_format($order->total_price, 0, ',', '.') }}
                    </h2>

                    <button
                        id="pay-button"
                        type="button"
                        class="btn btn-dark btn-lg w-100">
                        Bayar Sekarang
                    </button>

                    {{-- BATAL HANYA DI CHECKOUT --}}
                    <a href="{{ route('user.cart') }}"
                       class="btn btn-link text-muted mt-3">
                        Batalkan & kembali ke keranjang
                    </a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ config('services.midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" 
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script type="text/javascript">
  document.getElementById('pay-button').onclick = function(){
    snap.pay('{{ $snapToken }}', {
      onSuccess: function(result){
        window.location.href = "{{ route('user.orders') }}";
        alert('Pembayaran Berhasil!');
      },
      onPending: function(result){
        window.location.href = "{{ route('user.orders') }}";
        alert('Menunggu Pembayaran!');
      },
      onError: function(result){
        alert("Pembayaran Gagal!");
      },
      onClose: function(){
        console.log('customer closed the popup without finishing the payment');
      }
    });
  };
</script>
@endpush
