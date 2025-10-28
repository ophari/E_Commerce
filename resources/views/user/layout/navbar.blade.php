<nav class="navbar navbar-expand-lg bg-dark navbar-dark shadow-sm sticky-top">
  <div class="container">
    {{-- Brand --}}
    <a class="navbar-brand fw-bold text-uppercase" href="{{ route('user.home') }}"
       style="color:#C5A572; font-family:'Playfair Display', serif; letter-spacing:1px;">
      WatchStore
    </a>

    {{-- Toggle Button (Mobile) --}}
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>

    {{-- Navbar Menu --}}
    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link text-light" href="{{ route('user.product.list') }}">Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-light" href="{{ route('user.orders') }}">Orders</a>
        </li>
      </ul>

      {{-- Search Bar --}}
      <li class="nav-item search-nav">
        <a class="nav-link" href="#" id="searchToggle">
          <i class="bi bi-search"></i>
        </a>
        <div class="search-box">
          <input type="text" class="form-control form-control-sm" placeholder="Search...">
        </div>
      </li>

      {{-- Right Side --}}
      <ul class="navbar-nav ms-auto align-items-center">
        {{-- Cart --}}
        <li class="nav-item me-2">
          <a class="btn btn-outline-light btn-sm border-0" href="{{ route('user.cart') }}" style="color:#C5A572;">
            <i class="bi bi-bag"></i> Cart
            <span class="badge" style="background-color:#C5A572; color:#000;">
              {{ $cartCount ?? 0 }}
            </span>
          </a>
        </li>

        {{-- Authentication --}}
        @auth
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-light" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
              {{ Auth::user()->name }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end bg-dark border-0 shadow">
              <li>
                <a class="dropdown-item text-light" href="{{ route('user.profile.edit') }}">
                  <i class="bi bi-person-circle me-2"></i> Profile
                </a>
              </li>
              <li><hr class="dropdown-divider bg-secondary"></li>
              <li>
                <a class="dropdown-item text-light" href="{{ route('logout') }}">
                  <i class="bi bi-box-arrow-right me-2"></i> Logout
                </a>
              </li>
            </ul>
          </li>
        @else
          <li class="nav-item">
            <a class="btn btn-sm px-3" href="{{ route('login') }}"
               style="background-color:#C5A572; color:#000; font-weight:600;">
              Login
            </a>
          </li>
        @endauth
      </ul>
    </div>
  </div>
</nav>
