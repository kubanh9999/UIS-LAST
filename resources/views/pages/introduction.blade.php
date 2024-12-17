@extends('layouts.master')
@section('title', 'Đăng nhập')

@section('content')

<!-- Custom CSS -->
<style>
    /* --- Màu chủ đạo #74c26e --- */

    /* 1. Màu chữ chính */
   /*  .text-primary, a, a:hover {
        color: #74c26e ;
        text-decoration: none;
    } */

    /* 2. Màu nền nhấn mạnh */
    .bg-primary {
        background-color: #74c26e !important;
        color: #fff !important;
    }

    /* 3. Nút (Buttons) */
    .btn-primary {
        background-color: #74c26e;
        border-color: #74c26e;
    }

    .btn-primary:hover, .btn-primary:focus {
        background-color: #66af5f; /* Màu tối hơn khi hover */
        border-color: #66af5f;
    }

    /* 4. Thẻ card */
    .card {
        border: 1px solid #e0e6e3;
    }

    .card-title, .card-text {
        color: #4d774e;
    }

    .card-img-top {
        border: 3px solid #74c26e;
        border-radius: 50%;
    }

    /* 5. Màu nền phụ */
    .bg-light {
        background-color: #eaf7ed !important;
    }

    /* 6. Tiêu đề và khoảng cách */
    h1, h2, h3, h4, h5, h6 {
        color: #74c26e;
    }

    section {
        padding: 50px 0;
    }

    /* 7. Căn chỉnh container */
   /*  .container {
        max-width: 1200px;
    } */
    .card-img-top {
    width: 150px;
    height: 150px;
    object-fit: cover; /* Giúp ảnh không bị kéo dãn */
}
</style>

<!-- Phần giới thiệu -->
<section id="about" class="py-5">
    <div class="container text-center">
        <h2 class="fw-bold mb-4">
            Chào mừng đến với <span  style="color: #66af5f">UIS Fruits</span>!
        </h2>
        <p class="lead">
            Chúng tôi mang đến những loại hoa quả tươi ngon, an toàn và chất lượng nhất cho bạn và gia đình.
        </p>
    </div>
</section>

<!-- Phần sứ mệnh -->
<section id="mission" class="py-5 bg-light">
    <div class="container text-center">
        <h2 class="fw-bold mb-4 " style="color: #66af5f">🎯 Sứ mệnh của chúng tôi</h2>
        <p class="lead mx-auto" style="max-width: 800px;">
            "UIS Fruits được tạo nên với mong muốn mang đến cho khách hàng những loại hoa quả tươi ngon, sạch và an toàn nhất. 
            Chúng tôi tin rằng mỗi sản phẩm đều mang một câu chuyện - câu chuyện về sức khỏe, niềm vui và sự kết nối."
        </p>
    </div>
</section>

<!-- Phần đội ngũ thực hiện -->
{{-- <section id="team" class="py-5">
    <div class="container">
        <h2 class="text-center fw-bold mb-5">🤝 Đội ngũ thực hiện</h2>
        <div class="row g-4">
            @php
                $teamMembers = [
                    ['name' => 'Nguyễn Đăng Duy', 'role' => 'Backend', 'image' => 'member1.jpg'],
                    ['name' => 'Nguyễn Thanh Hào', 'role' => 'Backend', 'image' => 'member2.jpg'],
                    ['name' => 'Đặng Thế Anh', 'role' => 'Quản lý dự án', 'image' => 'member1.jpg'],
                    ['name' => 'Lại Thanh Hòa', 'role' => 'Full Stack', 'image' => 'member4.jpg'],
                    ['name' => 'Bùi Văn Phúc', 'role' => 'Thiết kế UI/UX & Backend', 'image' => 'member5.jpg'],
                ];
            @endphp
    
            @foreach ($teamMembers as $member)
                <div class="col-md-4 col-lg-2 mx-auto">
                    <div class="card h-100 shadow-sm border-0">
                        <!-- Thêm class để làm tròn ảnh -->
                        <img src="{{ asset('uploads/member/' . $member['image']) }}" class="card-img-top rounded-circle p-3" alt="{{ $member['name'] }}">
                        <div class="card-body text-center">
                            <h5 class="card-title fw-bold">{{ $member['name'] }}</h5>
                            <p class="card-text">{{ $member['role'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
 --}}
@endsection
