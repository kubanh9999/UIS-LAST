@extends('layouts.master')
@section('title', 'Đăng ký')

@section('content')
<style>
    /* Styling for the registration form */
    .form-register {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    p.not-register {
    margin-top: 20px;
    text-align: center;
    font-size: small;
    }
    .h2-register {
        text-align: center;
        margin-bottom: 20px;
        font-size: 24px;
        color: #333;
    }

    .form-group {
        margin-bottom: 15px;
        width: 100%;
    }

    label {
        font-weight: bold;
        font-size: 14px;
        display: block;
        margin-bottom: 5px;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        font-size: 14px;
    }

    button[type="submit"],
    button[type="button"] {
        width: 100%;
        padding: 10px;
        background-color: #28a745;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
        margin-top: 15px;
    }

    button[type="submit"]:hover,
    button[type="button"]:hover {
        background-color: #218838;
    }

    .required {
        color: red;
        margin-left: 5px;
    }

    .text-danger {
        display: block;
        color: red;
        margin-top: 5px;
    }
</style>

<form class="form-register" action="{{ route('register') }}" method="POST">
    <div>
        @if (session()->has('swal'))
        <script>
            Swal.fire({
                icon: "{{ session('swal.icon') }}",
                title: "{{ session('swal.title') }}",
                text: "{{ session('swal.text') }}",
                confirmButtonText: 'OK'
            });
        </script>
    @endif
        <h2 class="h2-register">Đăng ký</h2>
        @csrf
      
        <div class="form-row">
            <div class="form-group">
                <label for="name">Họ và Tên<span class="required">*</span>:</label>
                <input type="text" name="name" value="{{ old('name') }}" required>
                @if ($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="email">Email<span class="required">*</span>:</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                <span class="text-danger" id="email-error">
                    @if ($errors->has('email'))
                        {{ $errors->first('email') }}
                    @endif
                </span>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="password">Mật khẩu<span class="required">*</span>:</label>
                <input type="password" name="password" required>
                @if ($errors->has('password'))
                    <span class="text-danger">{{ $errors->first('password') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="password_confirmation">Xác nhận lại mật khẩu<span class="required">*</span>:</label>
                <input type="password" name="password_confirmation" required>
                @if ($errors->has('password_confirmation'))
                    <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                @endif
            </div>
        </div>

        <div class="form-row">
            <button type="button" id="send-otp-btn">Gửi mã OTP</button>
        </div>
    
        <div id="otp-section" style="display: none;">
            <div class="form-group">
                <label for="otp">Nhập mã OTP<span class="required">*</span>:</label>
                <input type="text" name="verification_code" value="{{ old('verification_code') }}">
                <span class="text-danger" id="otp-error"></span>
            </div>
        </div>
      
        <button type="submit" id="register-btn" style="display: none;">Đăng ký</button>
    </div>
    <p class="not-register">Đã có mật khẩu <a href="{{ route('login') }}">đăng nhập</a> tại đây?</p>
</form>

<script>
    // Event listener for sending OTP
    document.getElementById('send-otp-btn').addEventListener('click', function () {
        const email = document.getElementById('email').value.trim();

        // Validate email input
        if (!email) {
        Swal.fire({
            icon: 'warning',
            title: 'Thiếu Email',
            text: 'Vui lòng nhập email trước khi gửi OTP.',
            confirmButtonText: 'Đóng'
        });
        return;
    }

        // Send AJAX request to send OTP
        fetch('{{ route("verification.send") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ email: email })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
            icon: 'success',
            title: 'OTP đã được gửi!',
            text: data.message,
            confirmButtonText: 'OK'
        });
        document.getElementById('send-otp-btn').style.display = 'none';
                document.getElementById('otp-section').style.display = 'block'; // Show OTP input section
                document.getElementById('register-btn').style.display = 'block'; // Show register button
            } else {
                Swal.fire({
            icon: 'error',
            title: 'Lỗi Gửi OTP',
            text: data.message,
            confirmButtonText: 'Đóng'
        });
            }
        })
        .catch(error => {
            Swal.fire({
        icon: 'error',
        title: 'Lỗi',
        text: 'Có lỗi xảy ra khi gửi OTP. Vui lòng thử lại!',
        confirmButtonText: 'Đóng'
    });
        });
    });

    // Event listener for verifying OTP
    document.getElementById('otp').addEventListener('blur', function () {
        const otp = document.getElementById('otp').value.trim();

        // Validate OTP input
        if (!otp) {
        Swal.fire({
            icon: 'warning',
            title: 'Thiếu Mã OTP',
            text: 'Vui lòng nhập mã OTP.',
            confirmButtonText: 'Đóng'
        });
        return;
    }

        // Send AJAX request to verify OTP
        fetch('{{ route("verification.verify") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ otp: otp })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                icon: 'success',
                title: 'Xác Minh Thành Công',
                text: 'Mã OTP chính xác. Bạn có thể đăng ký.',
                confirmButtonText: 'OK'
            });
                document.getElementById('register-btn').style.display = 'block'; // Enable register button
            } else {
                Swal.fire({
                icon: 'error',
                title: 'Xác Minh Thất Bại',
                text: data.message,
                confirmButtonText: 'Đóng'
            }); // Show error message for OTP
            }
        })
        .catch(error => {
            Swal.fire({
            icon: 'error',
            title: 'Lỗi Hệ Thống',
            text: 'Có lỗi xảy ra khi xác minh OTP. Vui lòng thử lại sau!',
            confirmButtonText: 'Đóng'
        });
        });
    });
</script>

@endsection
