@extends('layouts.master')

@section('title', 'Đặt Hàng Thành Công')

<style>
    /* Vùng chứa xe ô tô */
    .car-container {
        position: relative;
        overflow: hidden;
        height: 100px; /* Chiều cao của vùng chứa */
        margin-top: 20px;
    }

    /* Xe ô tô di chuyển */
    .car-img {
        position: absolute;
        top: 20px;  /* Đặt xe ở vị trí mong muốn */
        left: -150px; /* Xe bắt đầu ở ngoài màn hình bên trái */
        width: 120px; /* Kích thước xe */
        animation: carDrive 5s forwards; /* Hiệu ứng animation chạy trong 5 giây */
    }

    /* Animation di chuyển xe */
    @keyframes carDrive {
        0% {
            left: -150px; /* Xe bắt đầu từ ngoài bên trái */
        }
        100% {
            left: 100%; /* Xe di chuyển đến ngoài bên phải */
        }
    }

    /* Màu chủ đạo */
    .text-main {
        color: #74c26e;
    }

    .btn-main {
        background-color: #74c26e;
        border-color: #74c26e;
    }

    .btn-main:hover {
        background-color: #66b257;
        border-color: #66b257;
    }

    /* Hiển thị thông báo thành công */
    .success-message {
        display: none;
        margin-top: 20px;
    }

    .success-message.show {
        display: block;
    }
</style>

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card text-center card-main">
                    <div class="card-body">
                        <!-- Thông báo thành công sẽ ẩn cho đến khi xe di chuyển xong -->
                        <div class="success-message" id="success-message">
                            <h1 class="card-title text-main"><i class="bi bi-check-circle-fill"></i>Chúc Mừng Bạn Đặt Hàng Thành Công!</h1>
                            <p class="card-text">Cảm ơn bạn đã tin tưởng mua sắm tại cửa hàng của chúng tôi. Đơn hàng của bạn đã được đặt thành công. Vui lòng kiểm tra email của bạn để xác nhận đơn hàng.</p>
                            <p class="card-text">
                                Mã đơn hàng của bạn là <strong>#{{ $order->token ?? 'XXXXXX' }}</strong>
                            </p>

                            <a href="{{ route('home.index') }}" class="btn btn-main btn-lg">
                                <i class="bi bi-house-door-fill"></i> Quay lại Trang Chủ
                            </a>
                        </div>

                        <!-- Vùng chứa hiệu ứng xe ô tô chở hàng -->
                        <div class="car-container">
                            <img src="{{ asset('uploads/member/car.png') }}" alt="Xe ô tô" class="car-img">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Đợi 5 giây sau khi hiệu ứng xe chạy qua
        setTimeout(function() {
            // Hiển thị thông báo sau khi xe di chuyển xong
            document.getElementById("success-message").classList.add("show");
        }, 5000);  // 5000ms = 5 giây (thời gian di chuyển của xe)

        setTimeout(function() {
            // Chuyển hướng đến trang chủ sau 5 giây nữa (sau khi thông báo thành công)
            window.location.href = "{{ route('home.index') }}";  // Chuyển hướng đến trang chủ
        }, 50000);  // Chờ 10 giây sau khi thông báo
    </script>
@endsection
