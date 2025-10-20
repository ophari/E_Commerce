<footer class="bg-dark text-light pt-4 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-3">
                <h5 class="fw-bold text-uppercase">Watch Store</h5>
                <p class="small">
                    Toko jam tangan modern dengan koleksi dari berbagai merek ternama. 
                    Temukan gaya yang sesuai dengan kepribadianmu.
                </p>
            </div>
            <div class="col-md-4 mb-3">
                <h6 class="fw-bold text-uppercase">Quick Links</h6>
                <ul class="list-unstyled">
                    <li><a href="{{ route('user.home') }}" class="text-light text-decoration-none">Home</a></li>
                    <li><a href="{{ route('user.product.list') }}" class="text-light text-decoration-none">Produk</a></li>
                    <li><a href="{{ route('user.cart') }}" class="text-light text-decoration-none">Keranjang</a></li>
                    <li><a href="{{ route('user.profile') }}" class="text-light text-decoration-none">Profil</a></li>
                </ul>
            </div>
            <div class="col-md-4 mb-3">
                <h6 class="fw-bold text-uppercase">Hubungi Kami</h6>
                <p class="small mb-1"><i class="bi bi-geo-alt"></i> Jl. Merdeka No.45, Jakarta</p>
                <p class="small mb-1"><i class="bi bi-envelope"></i> support@watchstore.com</p>
                <p class="small"><i class="bi bi-telephone"></i> +62 812 3456 7890</p>
            </div>
        </div>
        <hr class="border-light">
        <div class="text-center pb-3 small">
            &copy; {{ date('Y') }} Watch Store. All rights reserved.
        </div>
    </div>
</footer>

<style>
footer a:hover {
    text-decoration: underline !important;
}
</style>
