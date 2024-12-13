@extends('layouts.master')
@section('title', 'Đăng ký')

@section('content')

    <section class="section-account">
        <div class="container">
            <div class="swapper">
                <form class="form-register" action="{{ route('register') }}" method="POST">
                    @csrf
                    <h3 class="inner-head">Đăng ký</h3>
                    <div class="inner-content-form">
                        <div class="group-input">
                            <label for="name">Họ và Tên<span class="required">*</span>:</label>
                            <input type="text" name="name" value="{{ old('name') }}" required>
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="group-input">
                            <label for="email">Email<span class="required">*</span>:</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                            <span class="text-danger" id="email-error">
                                @if ($errors->has('email'))
                                    {{ $errors->first('email') }}
                                @endif
                            </span>
                        </div>
                        <div class="group-input">
                            <label for="password">Mật khẩu<span class="required">*</span>:</label>
                            <input type="password" name="password" required>
                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                        <div class="group-input">
                            <label for="password_confirmation">Xác nhận lại mật khẩu<span class="required">*</span>:</label>
                            <input type="password" name="password_confirmation" required>
                            @if ($errors->has('password_confirmation'))
                                <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                            @endif
                        </div>
                        <div class="submit-form">
                            <button type="button" id="send-otp-btn">Gửi mã OTP</button>
                        </div>
                        <div id="otp-section" style="display: none">
                            <div class="group-input">
                                <label for="otp">Nhập mã OTP<span class="required">*</span>:</label>
                                <input type="text" name="verification_code" value="{{ old('verification_code') }}">
                                <span class="text-danger" id="otp-error"></span>
                            </div>
                        </div>
                        <div class="submit-form">
                            <button type="submit" id="register-btn" style="display: none;">Đăng Ký</button>
                            <p class="not-register mt-2">Đã có mật khẩu <a href="{{ route('login') }}">Đăng nhập</a> tại đây?</p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script>
        document.getElementById('send-otp-btn').addEventListener('click', function() {
            // Vô hiệu hóa nút
            this.disabled = true;

            // Gửi OTP (mô phỏng xử lý gửi OTP)
            console.log("Mã OTP đã được gửi!");
        });
    </script>
    <script>
        // Event listener for sending OTP
        document.getElementById('send-otp-btn').addEventListener('click', function() {
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
            fetch('{{ route('verification.send') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        email: email
                    })
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
                        document.getElementById('otp-section').style.display =
                            'block'; // Show OTP input section
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
        document.getElementById('otp').addEventListener('blur', function() {
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
            fetch('{{ route('verification.verify') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        otp: otp
                    })
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
                        document.getElementById('register-btn').style.display =
                            'block'; // Enable register button
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
