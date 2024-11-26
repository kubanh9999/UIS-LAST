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
    <title>Admin</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.jpg') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    
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
                    <img src="{{ asset('layouts/img/logota.png') }}" alt="" class="img-fluid" style="width: 90%;"> <!-- Ảnh sẽ chiếm 90% chiều rộng của container -->
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
                    
                    
                            <div class="profileset">
                                @if (Auth::check())
                                <ul class="nav user-menu">
                                    <li class="nav-item d-flex align-items-center">
                                        <a class="login" href="{{ route('account.management') }}">
                                            <span class="login">Xin chào {{ Auth::user()->name }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">|</li>
                                    <br>
                                  
                                </ul>
                                <li class="nav-item d-flex align-items-center">
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                    <a href="#" class="login" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fa-solid fa-right-to-bracket"></i> 
                                    </a>
                                </li>
                                @endif
                            </div>
                            <hr class="m-0">
                            <a class="dropdown-item logout pb-0" href="signin.html">
                                <img src="{{ asset('assets/img/icons/log-out.svg') }}" class="me-2">Logout
                            </a>
                       
                    
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
    {{-- <style>
        /* Sidebar */
        #sidebar {
            margin-top: 60px;
    width: 250px;
    background-color:white; /* Primary green color */
    color: black;
    height: 100vh;
    font-family: Arial, sans-serif;
    position: fixed;
    top: 0;
    left: 0;
    overflow-y: auto;
    z-index: 1000; /* Ensures sidebar stays on top */
}

#sidebar-menu {
    list-style-type: none;
    padding: 0;
    margin: 0;
}

#sidebar-menu ul li {
    padding: 15px 20px;
    font-size: 16px;
    transition: background 0.3s;
}

#sidebar-menu ul li.active,
#sidebar-menu ul li:hover {
    background-color: #1b5e20; /* Darker green on hover/active */
}

#sidebar-menu ul li a {
    color: black;
    text-decoration: none;
    display: flex;
    align-items: center;
}

#sidebar-menu ul li a img {
    margin-right: 15px;
    width: 20px;
}

#sidebar-menu ul li a span {
    font-weight: bold;
}

#sidebar-menu ul li a:hover {
    color: #a5d6a7; /* Light green hover effect */
}

#sidebar-menu ul li.submenu a i {
    margin-right: 15px;
    color: white;
}

/* Slimscroll style */
.sidebar-inner.slimscroll {
    overflow-y: auto;
    max-height: calc(100vh - 20px);
    padding: 10px 0;
}

    </style> --}}
  {{--   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
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
</script>
</body>

</html>
