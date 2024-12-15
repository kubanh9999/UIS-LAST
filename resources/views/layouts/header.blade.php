<header class="header">
    <div class="background-main" id="hidden-topbar">
        <div class="container">
            <div class="inner-topbar">
                <div class="inner-topleft">
                    <div class="inner-top-contact">
                        <img class="inner-icon" src="{{asset('client/assets/icons/phone.svg')}}" alt="">
                        <span class="inner-text">0961710742</span>
                    </div>
                    <div class="inner-top-contact">
                        <img class="inner-icon" src="{{asset('client/assets/icons/mail.svg')}}" alt="">
                        <span class="inner-text">uisfruits@gmail.com</span>
                    </div>
                </div>
                <div class="inner-topright">
                    <div class="dropdown">
                        @if (Auth::check())

    @if (Auth::user()->role == 1)
        <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="assets/icons/user.svg" alt=""> {{ Auth::user()->name }}
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <li><a class="dropdown-item" href="{{ route('account.management')}}">Quản lý tài khoản</a></li>

            <li><a class="dropdown-item" href="{{ url('admin') }}">Đến trang Admin</a></li>
            <li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Đăng Xuất</a>
            </li>
        </ul>
    @else
        <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="{{asset('client/assets/icons/user.svg')}}" alt=""> {{ Auth::user()->name }}
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <li><a class="dropdown-item" href="{{ route('account.management')}}">Quản lý tài khoản</a></li>

            <li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Đăng Xuất</a>
            </li>
        </ul>
            @endif
        @else
            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="assets/icons/user.svg" alt=""> Tài khoản
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li><a class="dropdown-item" href="{{ route('login') }}">Đăng Nhập</a></li>
                <li><a class="dropdown-item" href="{{ route('register') }}">Đăng ký</a></li>
            </ul>
        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="inner-navbar">
            <div class="inner-offcanva">
                <button class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"
                    aria-controls="offcanvasExample">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample"
                    aria-labelledby="offcanvasExampleLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Menu</h5>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="menu-offcanvas mb-0">
                            <li><a href="{{ route('home.index') }}">Trang chủ</a></li>
                            <li><a href="{{ route('products.index') }}">Sản phẩm</a></li>
                            <li><a href="{{ route('home.introduction') }}">Về chúng tôi</a></li>
                            <li><a href="{{ route('posts.index') }}">Tin tức</a></li>
                            <li><a href="{{ route('contact.index') }}">Liên hệ</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="inner-logo">
                <a href="{{ route('home.index') }}">
                    <img src="{{asset('client/assets/img/logo3.png')}}" alt="logo">
                </a>
            </div>
            <div class="inner-search">
                <form action="{{ route('products.search') }}" method="GET">
                    <input name="query" type="text" placeholder="Tìm kiếm ở đây ..." value="{{ request()->input('query') }}">
                    <button><img src="{{asset('client/assets/icons/search.svg')}}" alt=""></button>
                </form>
            </div>
            <div class="inner-menu">
                <ul class="inner-main">
                    <li><a href="{{ route('home.index') }}">Trang chủ</a></li>
                    <li><a href="{{ route('products.index') }}">Sản phẩm</a></li>
                    <li><a href="{{ route('home.introduction') }}">Về chúng tôi</a></li>
                    <li><a href="{{ route('posts.index') }}">Tin tức</a></li>
                    <li><a href="{{ route('contact.index') }}">Liên hệ</a></li>
                </ul>
            </div>
            <div class="inner-cart">
                <a href="{{ route('cart.index') }}" class="inner-main">
                    <img src="{{asset('client/assets/icons/cart.svg')}}" alt="cart">
                    <span class="translate-middle badge rounded-pill bg-danger"
                        id="cart-count">{{ count(Session::get('cart', [])) }}</span>
                </a>
            </div>
        </div>
    </div>
</header>
