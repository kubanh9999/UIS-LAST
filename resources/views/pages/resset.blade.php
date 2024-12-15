@extends('layouts.master')
@section('title', 'Đăng ký')

@section('content')
@if (session('swal'))
    <script>
        Swal.fire({
            icon: '{{ session('swal')['icon'] }}',
            title: '{{ session('swal')['title'] }}',
            text: '{{ session('swal')['text'] }}'
        });
    </script>
@endif

<section class="section-account">
    <div class="container">
        <div class="swapper">
            <form class="form-register" action="{{ route('reset.password') }}" method="POST">
                @csrf
                <h3 class="inner-head">Đăng ký</h3>
                <div class="inner-content-form">
                    <div class="group-input">
                        <label for="email">Email<span class="required">*</span>:</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                        <span class="text-danger" id="email-error">
                            @if ($errors->has('email'))
                                {{ $errors->first('email') }}
                            @endif
                        </span>
                    </div>

                    <div class="submit-form">
                        <button type="button" id="send-otp-btn">Gửi mã OTP</button>
                    </div>

                    <!-- OTP input section (hidden initially) -->
                    <div id="otp-section" style="display: none;">
                        <div class="group-input">
                            <label for="otp">Nhập mã OTP<span class="required">*</span>:</label>
                            <input type="text" id="otp" name="verification_code" value="{{ old('verification_code') }}" required>
                            <span class="text-danger" id="otp-error"></span>
                        </div>
                    </div>

                    <!-- Password input section (hidden initially) -->
                    <div id="password-section" style="display: none;">
                        <div class="group-input">
                            <label for="password_confirmation">Mật khẩu mới<span class="required">*</span>:</label>
                            <input type="password" name="password" required>
                            <span class="text-danger" id="password-error"></span>
                        </div>
                        <div class="group-input">
                            <label for="password_confirmation">Xác nhận mật khẩu mới<span class="required">*</span>:</label>
                            <input type="password" name="password_confirmation" required>
                        </div>
                    </div>

                    <div class="submit-form">
                        <button type="submit" id="register-btn" style="display: none;">Cập nhật mật khẩu</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<script>
    $(document).ready(function() {
        $('#send-otp-btn').click(function() {
            // Vô hiệu hóa nút sau khi nhấn
            $(this).prop('disabled', true);
            
            // Gửi OTP hoặc thực hiện hành động nào đó
            // Thực hiện AJAX hoặc một hành động khác ở đây

            // Tùy chọn: có thể thêm thông báo hoặc set lại nút sau thời gian nhất định
            setTimeout(function() {
                $('#send-otp-btn').prop('disabled', false);  // Kích hoạt lại nút sau 30 giây (hoặc tùy theo yêu cầu)
            }, 30000); // 30 giây
        });
    });
</script>
<script>
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

    // Disable the "Send OTP" button to prevent multiple clicks
    this.disabled = true;

    // Send AJAX request to send OTP
    fetch('{{ route('verification.send') }}', {
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

            // Show OTP section and hide OTP button
            document.getElementById('send-otp-btn').style.display = 'none';
            document.getElementById('otp-section').style.display = 'block';  // Show OTP input
            document.getElementById('password-section').style.display = 'block'; // Show password input section
            document.getElementById('register-btn').style.display = 'block'; // Show update password button
 // Show OTP input section
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
    })
    .finally(() => {
        // Re-enable the button after a delay (if needed) or based on logic
        setTimeout(() => {
            document.getElementById('send-otp-btn').disabled = false;
        }, 30000);  // 30 seconds delay before allowing resend
    });
});

</script>

@endsection
