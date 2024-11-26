<!doctype html>
<html lang="en">

<head>
    <title>UIS FRUITS</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('layouts/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('layouts/css/global.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <!-- Slick Slider CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
</head>

<body>
    <div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v12.0"></script>

<!-- Messenger Module -->
<div class="fb-messengermodule" 
     data-href="https://m.me/110400522102841"  
     data-width="340" 
     data-height="500" 
     data-colorscheme="light"></div>

    @include('layouts.header')

    <main>
        @yield('content')

        <!-- Facebook Messenger Module -->
       
        <!-- Start of Tawk.to Script -->
        <script type="text/javascript">
            var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
            (function(){
                var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
                s1.async=true;
                s1.src='https://embed.tawk.to/6710d27d2480f5b4f58eef24/1iacrcf8v';
                s1.charset='UTF-8';
                s1.setAttribute('crossorigin','*');
                s0.parentNode.insertBefore(s1,s0);
            })();
        </script>
        <!-- End of Tawk.to Script -->
    </main>

    @include('layouts.footer')

    <!-- Offcanvas Sidebar for Mobile Navigation -->
    <div class="offcanvas offcanvas-start" id="offcanvas-menu">
        <div class="offcanvas-header">
            <div class="offcanvas-title">
                <a href="{{route('home.index')}}" class="text-decoration-none">
                    <h2 class="m-0">UIS <span>Fruits</span></h2>
                </a>
            </div>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="menu-offcanvas list-unstyled">
                <li class="nav-item"><a href="{{ route('home.index') }}">Trang chủ</a></li>
                <li class="nav-item"><a href="{{ route('home.introduction') }}">Giới thiệu</a></li>
                <li class="nav-item"><a href="{{ route('products.index') }}">Sản phẩm</a></li>
                <li class="nav-item"><a href="{{route('posts.index')}}">Tin tức</a></li>
                <li class="nav-item"><a href="{{route('contact.index')}}">Liên hệ</a></li>
                <li class="nav-item"> <a href="{{ route('login') }}">Đăng nhập</a></li>
            </ul>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" id="category-shop">
        <div class="offcanvas-header">
            <h3 class="offcanvas-title">Danh mục sản phẩm</h3>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
        </div>
        <ul class="category-list list-unstyled mb-0">
            <li class="category-item"><a href="#">Khuyến mãi hot</a></li>
            <li class="category-item"><a href="#">Trái cây & hoa</a></li>
            <li class="category-item"><a href="#">Giỏ trái cây</a></li>
            <li class="category-item"><a href="#">Quà tặng</a></li>
            <li class="category-item"><a href="#">Thịt cá, trứng & hải sản</a></li>
            <li class="category-item"><a href="#">Rau củ & nấm</a></li>
        </ul>
    </div>

  

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="{{ asset('layouts/js/main.js') }}"></script>
    <!-- Slick Slider JS -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script>
        fetch('/users/log-time', { // Thay đổi đường dẫn
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}' // CSRF token
    },
    body: JSON.stringify({ duration: duration })
});
        let startTime = new Date().getTime();

        // Gửi thời gian truy cập về server sau mỗi 30 giây
        setInterval(() => {
            let currentTime = new Date().getTime();
            let duration = Math.floor((currentTime - startTime) / 1000); // Tính thời gian ở lại trang tính bằng giây

            fetch('/api/log-time', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Nếu bạn sử dụng CSRF
                },
                body: JSON.stringify({ duration: duration })
            });
        }, 30000); // Gửi mỗi 30 giây
    </script>
 <script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var textContent = document.getElementById('text-content');
            var toggleButton = document.getElementById('toggle-button-content');

            // Kiểm tra nếu nội dung dài hơn 250 ký tự
            if (textContent.textContent.length > 900) {
                toggleButton.style.display = 'block'; // Hiển thị nút "Xem thêm"
            }

            toggleButton.addEventListener('click', function() {
                if (textContent.classList.contains('expanded')) {
                    textContent.classList.remove('expanded');
                    this.textContent = 'Xem thêm';
                } else {
                    textContent.classList.add('expanded');
                    this.textContent = 'Thu gọn ';
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Kiểm tra nếu người dùng đã truy cập trước đó
            if (!localStorage.getItem('bannerDisplayed')) {
                // Hiển thị overlay và banner
                const overlay = document.getElementById('overlay');
                const banner = document.getElementById('welcome-banner');

                overlay.style.display = 'block';
                banner.style.display = 'block';

                // Ẩn banner và overlay sau 5 giây
                setTimeout(function() {
                    overlay.style.display = 'none';
                    banner.style.display = 'none';
                    localStorage.setItem('bannerDisplayed', 'true'); // Lưu trạng thái đã hiển thị
                }, 5000);

                // Khi người dùng đóng banner
                document.getElementById('close-banner').addEventListener('click', function() {
                    overlay.style.display = 'none';
                    banner.style.display = 'none';
                    localStorage.setItem('bannerDisplayed', 'true'); // Lưu trạng thái đã hiển thị
                });
            }
        });
    </script>
</body>

</html>
