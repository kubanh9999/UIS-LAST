@extends('layouts.master')
@section('title', 'Đăng nhập')

@section('content')
<style>
    .service-img {
        height: 250px; /* Thiết lập chiều cao cho hình ảnh */
        object-fit: cover; /* Đảm bảo hình ảnh không bị méo */
        border-radius: 5px; /* Tạo bo góc nhẹ cho ảnh */
    }

    .card {
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }

    .card:hover {
        transform: scale(1.05); /* Hiệu ứng phóng to nhẹ khi hover */
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15); /* Bóng đổ lớn hơn khi hover */
    }

    h2 {
        font-size: 2rem;
    }

    .card-title {
        font-size: 1.2rem;
        font-weight: 600;
    }

    .video-container {
        position: relative; /* Đặt vị trí tương đối cho container */
        text-align: center; /* Căn giữa nội dung bên trong */
        margin-bottom: 20px; /* Khoảng cách dưới cùng */
    }

    .video-container img {
        width: 100%; /* Đặt chiều rộng của hình ảnh 100% */
        height: auto; /* Đảm bảo chiều cao tự động điều chỉnh */
        border-radius: 5px; /* Tạo bo góc nhẹ cho ảnh */
    }

    .video-container iframe {
        position: absolute; /* Đặt vị trí tuyệt đối cho video */
        top: 50%; /* Đặt vị trí ở giữa theo chiều dọc */
        left: 50%; /* Đặt vị trí ở giữa theo chiều ngang */
        transform: translate(-50%, -50%); /* Giúp video nằm chính giữa */
        width: 560px; /* Đặt chiều rộng cho video */
        height: 315px; /* Đặt chiều cao cho video */
    }
</style>
<section id="about" class="py-5">
    <div class="container">
        <h2 class="text-center">Về Chúng Tôi</h2>
        <p class="text-center">Chúng tôi là một công ty chuyên cung cấp các sản phẩm và dịch vụ tốt nhất cho khách hàng.</p>
        <!-- Nhúng video vào đây -->
        <div class="video-container">
            <img src="https://png.pngtree.com/background/20210711/original/pngtree-fresh-literary-fruit-lemon-tea-fruit-tea-taobao-banner-picture-image_1126915.jpg" alt="Hình ảnh mô tả" class="video-img">
            <iframe src="https://www.youtube.com/embed/TmqH0kp1NN4?si=GYsfyrBF2kxtlDuu" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
    </div>
</section>

<section id="services" class="bg-light py-5">
    <div class="container">
        <h2 class="text-center mb-4">Dịch Vụ Của Chúng Tôi</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                    <img src="https://berryfruit.vn/upload/images/banner/banner-web-1.jpg" class="card-img-top service-img" alt="Dịch Vụ 1">
                    <div class="card-body text-center">
                        <h5 class="card-title">Dịch Vụ 1</h5>
                        <p class="card-text">Mô tả dịch vụ 1.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                    <img src="https://bizweb.dktcdn.net/100/421/036/files/banner-khoa-hoc-pha-che-tra-trai-cay-chuyen-sau-tobeefood.jpg?v=1625132040009" class="card-img-top service-img" alt="Dịch Vụ 2">
                    <div class="card-body text-center">
                        <h5 class="card-title">Dịch Vụ 2</h5>
                        <p class="card-text">Mô tả dịch vụ 2.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                    <img src="https://cdn.tgdd.vn/Files/2022/09/07/1465850/tu-26-8-21-9-2022-trai-cay-cac-loai-khuyen-mai-chi-tu-18000d-202209071257591236.jpg" class="card-img-top service-img" alt="Dịch Vụ 3">
                    <div class="card-body text-center">
                        <h5 class="card-title">Dịch Vụ 3</h5>
                        <p class="card-text">Mô tả dịch vụ 3.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="contact" class="py-5">
    <div class="container">
        <h2 class="text-center">Liên Hệ Với Chúng Tôi</h2>
        <form>
            <div class="form-group">
                <label for="name">Họ và tên:</label>
                <input type="text" class="form-control" id="name" placeholder="Nhập họ và tên">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" placeholder="Nhập email">
            </div>
            <div class="form-group">
                <label for="message">Tin nhắn:</label>
                <textarea class="form-control" id="message" rows="3" placeholder="Nhập tin nhắn"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Gửi</button>
        </form>
    </div>
</section>
@endsection
