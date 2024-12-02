@extends('layouts.master')
@section('title', 'Đăng nhập')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    body {
        background-color: #f0f2f5; /* Màu nền nhẹ nhàng cho trang */
    }

    #login-form {
        max-width: 700px; /* Chiều rộng tối đa của form */
        margin: 50px auto; /* Giữa trang */
        padding: 20px; /* Padding bên trong */
        background-color: #ffffff; /* Màu nền trắng cho form */
        border-radius: 8px; /* Bo tròn các góc */
    }

    .h1-login {
        text-align: center; /* Căn giữa tiêu đề */
        margin-bottom: 20px; /* Khoảng cách dưới tiêu đề */
        font-size: 24px; /* Kích thước chữ cho tiêu đề */
        color: #333; /* Màu chữ tối */
    }

    label {
        font-size: small;
        font-weight: bold; /* Chữ đậm cho nhãn */
        display: block; /* Để nhãn nằm trên cùng trường nhập liệu */
        margin-bottom: 5px; /* Khoảng cách dưới nhãn */
        color: #555; /* Màu chữ cho nhãn */
    }

    input[type="email"],
    input[type="password"] {
        width: 100%; /* Chiều rộng 100% */
        padding: 10px; /* Padding bên trong */
        border: 1px solid #ccc; /* Viền màu xám */
        border-radius: 4px; /* Bo tròn các góc */
        box-sizing: border-box; /* Bao gồm padding và border trong chiều rộng */
        font-size: 14px; /* Kích thước chữ */
        margin-bottom: 15px; /* Khoảng cách giữa các trường nhập liệu */
        transition: border-color 0.3s; /* Hiệu ứng chuyển tiếp cho viền */
    }

    input[type="email"]:focus,
    input[type="password"]:focus {
        border-color: #66afe9; /* Màu viền khi trường được chọn */
        outline: none; /* Xóa viền mặc định */
        box-shadow: 0 0 5px rgba(102, 175, 233, 0.5); /* Đổ bóng khi chọn trường */
    }

    button[type="submit"] {
        width: 100%; /* Chiều rộng 100% cho nút */
        padding: 10px; /* Padding bên trong */
        background-color: #28a745; /* Màu nền nút */
        color: white; /* Màu chữ trắng */
        border: none; /* Không viền */
        border-radius: 4px; /* Bo tròn các góc */
        font-size: 16px; /* Kích thước chữ */
        cursor: pointer; /* Đổi con trỏ khi hover */
        transition: background-color 0.3s; /* Hiệu ứng chuyển tiếp cho màu nền */
    }

    button[type="submit"]:hover {
        background-color: #218838; /* Màu nền khi hover */
    }

    /* Thông báo lỗi */
    .error-message {
        font-size: 18px; /* Kích thước chữ cho thông báo lỗi */
        margin-top: 5px; /* Khoảng cách trên */
        color: red; /* Màu chữ cho thông báo lỗi */
        text-align: center; /* Căn giữa thông báo lỗi */
    }

    .logo_google {
        width: 28px;
        height: 28px;
        margin-right: 5px;
    }
    p.not-register {
    margin-top: 20px;
    text-align: center;
    font-size: small;
}
</style>


@if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: "{{ session('error') }}", // Bọc giá trị PHP trong chuỗi
            text: "{{ $errors->first('error', '') }}", // Sử dụng giá trị mặc định nếu không có lỗi
            confirmButtonText: 'Đóng'
        });
    </script>
@endif

@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Thành công!',
            text: "{{ session('success') }}",
            confirmButtonText: 'OK'
        });
    </script>
@endif
@if ($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Tài khoản hoặc mật khẩu không chính xác!',
            text: "{{ $errors->first('error') }}",
            confirmButtonText: 'Đóng'
        });
    </script>
@endif

<form id="login-form" action="{{ route('login') }}" method="POST" onsubmit="return validateForm()">

    @csrf
    <h1 class="h1-login">Đăng Nhập</h1> <!-- Tiêu đề cho form -->
   {{--  @if ($errors->any())
        <div class="error-message">
            {{ $errors->first() }} 
        </div>
    @endif --}}
   

    <div>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <span id="email-error" class="error-message" style="display: none;"></span> <!-- Thông báo lỗi cho email -->
    </div>
    <div>
        <label for="password">Mật khẩu:</label>
        <input type="password" name="password" id="password" required>
        <span id="password-error" class="error-message" style="display: none;"></span> <!-- Thông báo lỗi cho password -->
    </div>
    <button type="submit">Đăng Nhập</button>
    <p class="not-register">Bạn chưa có tài khoản <a href="{{ route('register') }}">đăng ký</a> tại đây?</p>
    <div style="text-align: center; margin-top: -10px;">
        <a href="{{ route('login.google') }}" class="btn btn-google"><img class="logo_google" src="{{ asset('layouts/img/google_logo.png') }}" alt="">Google</a>
    </div>
</form>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function validateForm() {
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const emailError = document.getElementById('email-error');
        const passwordError = document.getElementById('password-error');

        // Reset lỗi cũ
        emailError.style.display = 'none';
        emailError.innerHTML = '';
        passwordError.style.display = 'none';
        passwordError.innerHTML = '';

        // Kiểm tra xem có trường nào rỗng không
        let isValid = true; // Biến để kiểm tra tính hợp lệ

        if (!email) {
            emailError.innerHTML = 'Vui lòng nhập địa chỉ email.';
            emailError.style.display = 'block'; // Hiển thị thông báo lỗi cho email
            isValid = false; // Đánh dấu là không hợp lệ
        } else {
            // Kiểm tra định dạng email
            const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
            if (!email.match(emailPattern)) {
                emailError.innerHTML = 'Vui lòng nhập địa chỉ email hợp lệ.';
                emailError.style.display = 'block'; // Hiển thị thông báo lỗi cho email
                isValid = false; // Đánh dấu là không hợp lệ
            }
        }

        if (!password) {
            passwordError.innerHTML = 'Vui lòng nhập mật khẩu.';
            passwordError.style.display = 'block'; // Hiển thị thông báo lỗi cho password
            isValid = false; // Đánh dấu là không hợp lệ
        }

        return isValid; // Trả về kết quả kiểm tra
    }
</script>

@endsection
