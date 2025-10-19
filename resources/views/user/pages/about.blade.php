@extends('user.layout.app')

@section('title', 'About Us | Watch Store')

@section('content')
<section class="container py-5">
  <div class="row align-items-center">
    <div class="col-md-6 mb-4 mb-md-0">
      <img src="https://source.unsplash.com/700x500/?watch,luxury" 
           class="img-fluid rounded-4 shadow-sm" 
           alt="Luxury Watches">
    </div>
    <div class="col-md-6">
      <h2 class="fw-bold text-dark mb-3">About Our Store</h2>
      <p class="text-muted">
        Time is the most valuable thing we have — and at <strong>Watch Store</strong>, 
        we believe every second deserves to be celebrated. Our curated collection features 
        the finest timepieces from brands like Rolex, Casio, and Omega, combining precision, 
        craftsmanship, and timeless design.
      </p>
      <p class="text-muted">
        In today’s digital era, a watch isn’t just about keeping time — it’s a reflection 
        of your lifestyle, your discipline, and your identity. Whether you seek elegance, 
        durability, or smart functionality, we’re here to help you find the perfect match.
      </p>
      <a href="{{ route('user.product.detail') }}" class="btn btn-dark mt-3 px-4 py-2">Explore Collection</a>
    </div>
  </div>
</section>

<section class="bg-light py-5 text-center">
  <div class="container">
    <h3 class="fw-bold mb-3">Why Watches Still Matter</h3>
    <p class="text-muted mx-auto" style="max-width: 700px;">
      Despite smartphones and digital clocks everywhere, a wristwatch remains a 
      statement of confidence and class. It tells more than time — it tells your story.
    </p>
  </div>
</section>
@endsection
