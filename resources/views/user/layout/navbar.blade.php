<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="{{ route('user.home') }}">WatchStore</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="{{ route('user.products') }}">Products</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('user.orders') }}">Orders</a></li>
      </ul>

      <ul class="navbar-nav ms-auto align-items-center">
        <li class="nav-item me-2">
          <a class="btn btn-outline-dark btn-sm" href="{{ route('user.cart') }}">
            Cart <span class="badge bg-dark text-white ms-1">{{ count(session('cart', [])) }}</span>
          </a>
        </li>
        @auth
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
              {{ Auth::user()->name }}
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
            </ul>
          </li>
        @else
          <li class="nav-item">
            <a class="btn btn-dark btn-sm" href="{{ route('login') }}">Login</a>
          </li>
        @endauth
      </ul>
    </div>
  </div>
</nav>
