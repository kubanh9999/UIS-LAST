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
            <iframe width="640" height="360" src="https://www.youtube.com/embed/KPP4Cfupzhs" title="Hey Bear Sensory - Smoothie Mix!- Fun Dance Video with music and animation !" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
    </div>
</section>
@endsection
