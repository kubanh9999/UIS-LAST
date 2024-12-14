<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="POS - Bootstrap Admin Template">
    <meta name="keywords"
        content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern,  html5, responsive">
    <meta name="author" content="Dreamguys - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">
    <title>Admin</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.jpg') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.26/dist/sweetalert2.min.css" rel="stylesheet" />

    <!-- Thêm JS của SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.26/dist/sweetalert2.all.min.js"></script>
    <!-- Thêm CSS của SweetAlert2 -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.min.css" rel="stylesheet">

<!-- Thêm JS của SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.min.js"></script>

<script>
 window.onload = function() {
    if (!{{ Auth::check() ? 'true' : 'false' }}) {
        window.location.href = '/';  // Chuyển hướng về trang chủ nếu chưa đăng nhập
    } else {
        // Đảm bảo không cho quay lại trang trước đó
        history.pushState(null, null, location.href);
        window.onpopstate = function() {
            history.go(1); // Khi ấn nút "quay lại", chuyển hướng người dùng
        };
    }
};
</script>
</head>

<body>
    <!-- <div id="global-loader">
        <div class="whirly-loader"> </div>
    </div> -->

    <div class="main-wrapper">

        <div class="header">
            <div class="col-lg-2 col-5">
                <a href="{{ route('home.index') }}" class="text-decoration-none">
                    
                </a>
            </div>
            <div class="header-left active">
                <div class="imagess m-0">
                    <a href="/admin">
                        <img src="{{ asset('layouts/img/logota.png') }}" alt="" class="img-fluid" style="width: 90%;"> <!-- Ảnh sẽ chiếm 90% chiều rộng của container -->
                    </a>
                 
                </div>
                <a id="toggle_btn" href="javascript:void(0);">
                </a>
            </div>

            <a id="mobile_btn" class="mobile_btn" href="#sidebar">
                <span class="bar-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </a>

            <ul class="nav user-menu">

                <li class="nav-item dropdown has-arrow main-drop">
                    
                    
                    <div class="inner-topright">
                        <div class="dropdown">
                            @if (Auth::check())
                                <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="assets/icons/user.svg" alt=""> {{ Auth::user()->name }}
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
    
                                    <li>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                        <a class="dropdown-item" href="#" onclick="event.preventDefault(); handleLogout();">Đăng Xuất</a>
                                        <a class="dropdown-item" href="{{ route('home.index') }}" >Đến trang website</a>
                                    </li>                                    
                                    </ul>
                                @endif
                            </div>
                        </div>            
                    </li>
                </ul>
            </div>
       
        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div class="sidebar-menu">
                    <ul>
                        <li class="active">
                            <a href="{{route('admin.dashboard.index')}}"><img src="{{ asset('assets/img/icons/dashboard.svg') }}"
                                    alt="img"><span>
                                    Thống kê</span> </a>
                        </li>
                        <li class="submenu">
                            <a href="{{route('admin.products.index')}}"><img src="{{ asset('assets/img/icons/product.svg') }}"
                                    alt="img"><span>
                                    Quản lý sản phẩm</span> </a>
                           
                        </li>
                        <li class="submenu">
                            <a href="{{route('admin.categories.index')}}"><img src="{{ asset('assets/img/icons/category.svg') }}"
                                    alt="img"><span>
                                    Quản lý danh mục</span> </a>
                           
                            </li>
                            <li class="submenu">
                                <a href="{{route('admin.comments.management')}}"><i class="fa-solid fa-comment"></i>
                                        <span>Quản lý bình luận</span></a>
                            </li>
                        <li class="submenu">
                            <a href="{{route('admin.orders.index')}}"><img src="{{ asset('assets/img/icons/quotation1.svg') }}"
                                    alt="img"><span>
                                   Quản lý đơn hàng</span> </a>
                           
                        </li>

                        <li class="submenu">
                            <a href="{{route('admin.users.index')}}"><img src="{{ asset('assets/img/icons/users1.svg') }}"
                                    alt="img"><span>
                                    Quản lý người dùng</span> </a>
                          
                        </li>
                        <li class="submenu">
                            <a href="{{ route('admin.discount.index') }}">
                                <i class="fa-solid fa-tag" style="color:black"></i>
                                <span>Quản lý mã giảm giá</span>
                                
                            </a>
                           
                        </li>
                        <li class="submenu">
                            <a href="{{ route('admin.post.index') }}">
                                <i class="fa-brands fa-usps" style="color:black"></i>
                                <span>Quản lý bài viết</span>
                                
                            </a>
                        </li>
                        <li class="submenu">
                            <a href="{{ route('admin.banners.management') }}">
                                <i class="fa-regular fa-image" style="color:black"></i>
                                <span>Quản lý Banner</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
   
        @yield('content')

    </div>
   
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />

<!-- Thêm JS của Toastr -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>

    <script src="{{ asset('assets/js/feather.min.js') }}"></script>

    <script src="{{ asset('assets/js/jquery.slimscroll.min.js') }}"></script>

    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/apexchart/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/apexchart/chart-data.js') }}"></script>

    <script src="{{ asset('assets/js/script.js') }}"></script>

    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert/sweetalerts.min.js') }}"></script>

<!-- SweetAlert2 confirm dialog -->
<script>
    function confirmDelete(itemId) {
        Swal.fire({
            title: 'Bạn có chắc chắn?',
            text: "Hành động này không thể hoàn tác!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Vâng, xóa nó!',
            cancelButtonText: 'Hủy bỏ'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form nếu người dùng nhấn đồng ý
                document.getElementById('delete-form-' + itemId).submit();
            }
        })
    }
    // Sau khi người dùng nhấn đăng xuất
// Hàm thay thế lịch sử trình duyệt sau khi đăng xuất
const handleLogout = () => {
    // Ngừng lưu lịch sử trình duyệt
    window.history.pushState(null, null, window.location.href); // Thêm trang hiện tại vào lịch sử
    window.history.forward(); // Điều hướng trình duyệt tới trang trước đó

    // Thêm sự kiện trước khi tải lại trang (ngăn quay lại)
    window.addEventListener("popstate", function() {
        window.history.forward();
    });

    // Gửi form đăng xuất
    document.getElementById('logout-form').submit();
};

// Hàm xử lý sự kiện beforeunload để cảnh báo người dùng nếu họ cố gắng rời khỏi trang
const beforeUnloadHandler = (event) => {
    event.preventDefault();
    event.returnValue = "Bạn có chắc chắn muốn rời khỏi trang?"; // Thông báo cảnh báo
};

// Thêm sự kiện beforeunload khi có thay đổi dữ liệu hoặc khi người dùng nhấn logout
const nameInput = document.querySelector("#name");
nameInput.addEventListener("input", (event) => {
    if (event.target.value !== "") {
        window.addEventListener("beforeunload", beforeUnloadHandler);
    } else {
        window.removeEventListener("beforeunload", beforeUnloadHandler);
    }
});


</script>
</body>

</html>
