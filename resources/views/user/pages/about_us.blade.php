@extends('user.layout.app')

@section('title', 'About Us | Watch Store')

@section('content')

<div class="container-fluid px-0">

{{-- ================= HERO ABOUT (FIXED BACKGROUND) ================= --}}
<div class="hero-bg-fixed hero-zoom"></div>
<div class="position-absolute top-0 start-0 w-100 h-100 bg-white opacity-75"></div>

<div class="hero-wrapper d-flex align-items-center">
    <div class="container position-relative text-center text-dark" style="z-index:2;">
        <h1 class="fw-bold display-5 mb-3" style="font-family:'Playfair Display', serif;">
            About Us
        </h1>
        <p class="lead mx-auto" style="max-width: 600px;">
            Mengenal lebih dekat tim di balik <strong>WATCHSTORE</strong>
        </p>
    </div>
</div>

{{-- ================= ABOUT COMPANY ================= --}}
<section class="about-section fade-up container py-5">
    <div class="row align-items-center">

        <div class="col-md-6 mb-4 mb-md-0 text-center">
            <img src="{{ asset('image/about-img.jpg') }}"
                 class="img-fluid rounded-4 shadow-sm"
                 alt="About Watch Store">
        </div>

        <div class="col-md-6 text-center text-md-start">
            <h2 class="fw-bold text-dark mb-3">About Our Store</h2>

            <p class="text-muted">
                <strong>WATCHSTORE</strong> adalah platform penjualan jam tangan premium
                yang mengutamakan kualitas, presisi, dan kepercayaan pelanggan.
            </p>

            <p class="text-muted">
                Kami percaya jam tangan bukan sekadar penunjuk waktu, melainkan simbol
                gaya hidup, profesionalisme, dan karakter pemakainya.
            </p>
        </div>

    </div>
</section>


{{-- ================= TEAM SECTION ================= --}}
<section class="container py-5 fade-up text-center">

    <h3 class="fw-bold text-dark mb-3">Meet Our Team</h3>
    <p class="text-muted mb-5">
        Tim pengembang di balik sistem dan desain WATCHSTORE
    </p>

    <div class="row justify-content-center g-4">

        {{-- Raffy --}}
        <div class="col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                <div class="rounded-circle bg-dark text-white fw-bold 
                            d-flex align-items-center justify-content-center mx-auto mb-3"
                     style="width:90px;height:90px;font-size:28px;">
                    R
                </div>
                <h5 class="fw-semibold mb-1">Raffy Andreano Pratama</h5>
                <p class="text-muted mb-0">242502040030</p>
            </div>
        </div>

        {{-- Yusuf --}}
        <div class="col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                <div class="rounded-circle bg-dark text-white fw-bold 
                            d-flex align-items-center justify-content-center mx-auto mb-3"
                     style="width:90px;height:90px;font-size:28px;">
                    Y
                </div>
                <h5 class="fw-semibold mb-1">Muhamad Yusuf</h5>
                <p class="text-muted mb-0">242502040108</p>
            </div>
        </div>

        {{-- Ramzy --}}
        <div class="col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                <div class="rounded-circle bg-dark text-white fw-bold 
                            d-flex align-items-center justify-content-center mx-auto mb-3"
                     style="width:90px;height:90px;font-size:28px;">
                    R
                </div>
                <h5 class="fw-semibold mb-1">Ramzy Fadlil Agusanddawi</h5>
                <p class="text-muted mb-0">242502040052</p>
            </div>
        </div>

    </div>
</section>

{{-- ================= CONTACT SECTION (FIXED) ================= --}}
<section class="py-5 bg-white">
    <div class="container">

        <div class="text-center mb-5 fade-up">
            <h2 class="fw-bold text-dark">Contact Us</h2>
            <p class="text-muted">Feel free to reach out to us</p>
        </div>

        <div class="row justify-content-center">
            {{-- INFO + MAP --}}
            <div class="col-lg-8 fade-up">
                <div class="row g-4">

                    @php
                        $infos = [
                            ['bi-telephone','Phone Number','+62 812 3456 7890'],
                            ['bi-envelope','Email Address','watchstore@gmail.com'],
                            ['bi-whatsapp','WhatsApp','08xx-xxxx-xxxx'],
                            ['bi-geo-alt','Our Office','Tangerang, Indonesia'],
                        ];
                    @endphp

                    @foreach($infos as $info)
                    <div class="col-md-6">
                        <div class="p-4 rounded-4 shadow-sm h-100 bg-white text-dark">
                            <i class="bi {{ $info[0] }} fs-3"></i>
                            <h6 class="fw-bold mt-3">{{ $info[1] }}</h6>
                            <p class="text-muted mb-0">{{ $info[2] }}</p>
                        </div>
                    </div>
                    @endforeach

                    {{-- MAP --}}
                    <div class="col-12">
                        <div class="rounded-4 overflow-hidden shadow-sm">
                            <iframe
                                src="https://www.google.com/maps?q=Tangerang&output=embed"
                                width="100%"
                                height="260"
                                style="border:0;"
                                loading="lazy">
                            </iframe>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

</div>
@endsection
