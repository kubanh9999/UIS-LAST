@extends('layouts.master')
@section('title', 'Đăng nhập')
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- <style>
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
</style> --}}
<style>
     .quenmk {
    margin-left: 350px;
    font-size: 12px;
    }
</style>

    @if (session('replaceHistory'))
        <script type="text/javascript">
            // Thay thế lịch sử trang để ngăn quay lại trang trước
            window.history.replaceState(null, null, window.location.href);
            window.history.pushState(null, null, window.location.href);

            // Lắng nghe sự kiện back của trình duyệt và ngăn lại
            window.onpopstate = function() {
                window.history.forward();
            };
        </script>
    @endif

    @if (session('error'))
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

    <section class="section-account">
        <div class="container">
            <div class="swapper">
                <form id="login-form" action="{{ route('login') }}" method="POST" onsubmit="return validateForm()">
                    @csrf
                    <h3 class="inner-head">Đăng nhập</h3>
                    <div class="inner-content-form">
                        <div class="group-input">
                            <label for="email">Email:</label>
                            <input type="email" name="email" id="email" required>
                            <span id="email-error" class="error-message d-none"></span>
                        </div>
                        <div class="group-input">
                            <label for="password">Mật khẩu:</label>
                            <input type="password" name="password" id="password" required>
                            <span id="password-error" class="error-message d-none"></span>
                        </div>
                        {{-- <div class="quenmk">
                            <p><a href="{{route('reset')}}">Quên mật khẩu?</a></p>
                        </div> --}}
                        <div class="submit-form">
                            <button type="submit">Đăng Nhập</button>
                            <p class="mb-0"><a href="{{route('reset')}}">Quên mật khẩu?</a></p>
                            <p class="not-register">Bạn chưa có tài khoản <a href="{{ route('register') }}">Đăng ký</a> tại đây? </p>
                        </div>
                    </div>
                    <div class="inner-more">
                        <a href="{{ route('login.google') }}">
                            <img src="{{asset('client/assets/img/google_logo.png')}}" alt="google_logo.png" width="35px">
                            <span>Đăng nhập bằng Google</span>
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </section>
    
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
