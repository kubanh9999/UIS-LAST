<style>
    .sdt-contact .contact-sdt {
        margin-left: 5px;
    }

    .mail-contact .contact-mail {
        margin-left: 5px;
    }
</style>
<header>

    <div class="top-bar" id="topBar">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <ul class="contact-info nav">
                    <li class="nav-item d-flex align-items-center sdt-contact">
                        <i class='fa fa-phone'></i>
                        <p class="contact-sdt">0961710742</p>
                    </li>
                    <li class="nav-item d-flex align-items-center mail-contact">
                        <i class="fa-solid fa-envelope"></i>
                        <p class="contact-mail">uisfruits@gmail.com</p>
                    </li>
                </ul>
                <div class="auth-links nav justify-content-center align-items-center">
                    @if (Auth::check())
                        <li class="nav-item d-flex align-items-center">
                            <a class="login" href="{{ route('account.management') }}"><span
                                    class="login">{{ Auth::user()->name }}</span></a>
                        </li>
                        <li class="nav-item">|</li>
                        <li class="nav-item d-flex align-items-center">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            <a href="#" class="login"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                    class="fa-solid fa-right-to-bracket"></i></a>
                        </li>
                    @else
                        <li class="nav-item d-flex align-items-center login">
                            <a href="{{ route('login') }}" class="login">Đăng nhập</a>
                        </li>
                    @endif
                </div>

            </div>
        </div>
    </div>


    <div class="nav-bar">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <!-- Logo -->
                <div class="mobile-menu-start d-lg-none col-2">
                    <button type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas-menu">
                        <i class="fa fa-bars"></i>
                    </button>
                </div>

                <div class="col-lg-2 col-5">
                    <a href="{{ route('home.index') }}" class="text-decoration-none">
                        <div class="imagess m-0">
                            <img src="{{ asset('layouts/img/logota.png') }}" alt="" class="img-fluid" style="width: 90%;"> <!-- Ảnh sẽ chiếm 90% chiều rộng của container -->   
                        </div>
                    </a>
                </div>

                <!-- Search Bar -->
                <form action="{{ route('products.search') }}" method="GET" class="search col-lg-4">
                    <input name="query" type="text" placeholder="Tìm kiếm sản phẩm"
                        value="{{ request()->input('query') }}">
                    <button><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>

                <!-- Navigation Menu -->
                <ul class="menu nav col-lg-5">
                    <li class="nav-item"><a href="{{ route('home.index') }}" class="nav-link">Trang chủ</a></li>
                    <li class="nav-item"><a href="{{ route('home.introduction') }}" class="nav-link">Giới thiệu</a></li>
                    <li class="nav-item"><a href="{{ route('products.index') }}" class="nav-link">Sản phẩm</a></li>
                    <li class="nav-item"><a href="{{ route('posts.index') }}" class="nav-link">Tin tức</a></li>
                    <li class="nav-item"><a href="{{ route('contact.index') }}" class="nav-link">Liên hệ</a></li>
                </ul>

                <!-- Biểu tượng Giỏ hàng -->
                <div class="cart col-lg-1">
                    <a href="{{ route('cart.index') }}" class="d-flex align-items-center">
                        <img src="{{ asset('layouts/img/cart-icon.svg') }}" alt="Giỏ hàng" class="img-fluid">
                        <span class="badge bg-danger translate-middle"
                            id="cart-count">{{ count(Session::get('cart', [])) }}</span> <!-- Số lượng sản phẩm -->
                    </a>

                </div>

                <!-- Mobile & Tablet Menu -->
                <div class="mobile-menu col-3">
                    {{-- <button><i class="fa-solid fa-magnifying-glass"></i></button> --}}
                    {{-- <button><i class="fa-solid fa-user"></i></button> --}}

                    <a href="{{ route('cart.index') }}" style="color: black">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span style="font-size: 12px; padding: 4px 6px" class="badge bg-danger translate-middle"
                            id="cart-count">{{ count(Session::get('cart', [])) }}</span> <!-- Số lượng sản phẩm -->
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
