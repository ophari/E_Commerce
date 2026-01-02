<nav class="navbar navbar-expand-lg bg-dark navbar-dark shadow-sm sticky-top">
  <div class="container">

    {{-- Brand --}}
    <a class="navbar-brand fw-bold text-uppercase header-brand" href="{{ route('home') }}">
      WATCHSTORE</span>
    </a>

    {{-- Toggle Button (Mobile) --}}
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>

    {{-- Navbar Menu --}}
    <div class="collapse navbar-collapse" id="nav">

      {{-- Left (Products + Orders) --}}
      <ul class="navbar-nav me-auto">
        <li class="nav-item simple-link">
          <a class="nav-link text-light" href="{{ route('home') }}">Home</a>
        </li>
        <li class="nav-item simple-link">
          <a class="nav-link text-light" href="{{ route('product.list') }}">Products</a>
        </li>
        <li class="nav-item simple-link">
            <a class="nav-link text-light" href="{{ route('about')}}">About</a>
        </li>
      </ul>

      {{-- MOBILE ONLY SEPARATOR --}}
      <div class="nav-separator d-lg-none"></div>

{{-- RIGHT SIDE --}}
<ul class="navbar-nav ms-auto align-items-center">

    {{-- =========================
         GUEST (Belum Login)
       ========================= --}}
    

    @guest
        <li class="nav-item d-none d-lg-block me-2">
            <a href="{{ route('login') }}" class="btn btn-sm nav-auth-btn nav-auth-login">
                Login
            </a>
        </li>

        <li class="nav-item d-none d-lg-block">
            <a href="{{ route('register') }}" class="btn btn-sm nav-auth-btn nav-auth-register">
                Register
            </a>
        </li>

        {{-- Mobile version --}}
        <li class="nav-item d-lg-none w-100 mt-2">
          <a href="{{ route('login') }}" class="btn w-100 btn-sm nav-auth-btn nav-auth-login">
              Login
          </a>
        </li>

        <li class="nav-item d-lg-none w-100 mt-2">
          <a href="{{ route('register') }}" class="btn w-100 btn-sm nav-auth-btn nav-auth-register">
              Register
          </a>
        </li>
    @endguest


    {{-- =========================
         DESKTOP CART + PROFILE
       ========================= --}}
    @auth

        {{-- DESKTOP CART --}}
        <li class="nav-item d-none d-lg-block">
            <a class="btn btn-outline-light btn-sm border-0" href="{{ route('user.cart') }}" style="color:#C5A572;">
                <i class="bi bi-bag"></i> Cart
                <span class="badge" style="background-color:#C5A572; color:#000;">
                    {{ $cartCount ?? 0 }}
                </span>
            </a>
        </li>

        {{-- DESKTOP PROFILE --}}
        <li class="nav-item dropdown d-none d-lg-block ms-3">
            <a class="nav-link dropdown-toggle text-light" href="#" data-bs-toggle="dropdown">
                {{ Auth::user()->name }}
            </a>

        <ul class="dropdown-menu dropdown-menu-end bg-dark border-0 shadow">

            <li>
                <a class="dropdown-item text-light d-flex align-items-center" href="{{ route('user.orders') }}">
                    <i class="bi bi-bag-check me-2 "></i> Orders
                </a>
            </li>
            <li>
                <a class="dropdown-item text-light d-flex align-items-center" href="{{ route('user.profile.edit') }}">
                    <i class="bi bi-person-circle me-2"></i> Edit Profile
                </a>
            </li>
            <li><hr class="dropdown-divider bg-secondary"></li>
            <li>
                <a class="dropdown-item text-light d-flex align-items-center" href="{{ route('logout') }}">
                    <i class="bi bi-box-arrow-right me-2 "></i> Logout
                </a>
            </li>
        </ul>

        </li>

        {{-- MOBILE CART --}}
        <li class="nav-item action-btn d-lg-none mt-2">
            <a class="btn btn-outline-light btn-sm border-0" href="{{ route('user.cart') }}" style="color:#C5A572;">
                <i class="bi bi-bag"></i> Cart
                <span class="badge" style="background-color:#C5A572; color:#000;">
                    {{ $cartCount ?? 0 }}
                </span>
            </a>
        </li>

        {{-- MOBILE PROFILE --}}
        <li class="nav-item action-btn dropdown d-lg-none mt-2">
            <a class="nav-link dropdown-toggle text-light text-center" href="#" data-bs-toggle="dropdown">
                {{ Auth::user()->name }}
            </a>

        <ul class="dropdown-menu dropdown-menu-end bg-dark border-0 shadow">

            <li><a class="dropdown-item text-light d-flex align-items-center" href="{{ route('user.orders') }}"><i class="bi bi-bag-check me-2 "></i> Orders</a></li>
            <li><a class="dropdown-item text-light d-flex align-items-center" href="{{ route('user.profile.edit') }}"><i class="bi bi-person-circle me-2 "></i> Edit Profile</a></li>
            <li><hr class="dropdown-divider bg-secondary"></li>
            <li><a class="dropdown-item text-light d-flex align-items-center" href="{{ route('logout') }}"><i class="bi bi-box-arrow-right me-2 "></i> Logout</a></li></ul></li>

        </ul>

    @endauth
    </div>
  </div>
</nav>
