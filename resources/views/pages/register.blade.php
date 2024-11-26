@extends('layouts.master')
@section('title', 'Đăng nhập')

@section('content')
<style>
.form-register {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.h2-register {
    text-align: center;
    margin-bottom: 20px;
    font-size: 24px;
    color: #333;
}

.form-group {
    margin-bottom: 15px; /* Khoảng cách giữa các nhóm */
    width: 100%; /* Đảm bảo mỗi nhóm chiếm toàn bộ chiều rộng */
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
    width: 100%; /* Để các input dài ra toàn bộ */
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    font-size: 14px;
}

input[type="text"]:focus,
input[type="email"]:focus,
input[type="password"]:focus {
    border-color: #66afe9;
    outline: none;
    box-shadow: 0 0 8px rgba(102, 175, 233, 0.6);
}

button[type="submit"] {
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

button[type="submit"]:hover {
    background-color: #218838;
}

/* Responsive cho màn hình nhỏ */
@media (max-width: 768px) {
    .form-group {
        width: 100%;
    }
}

.required {
    color: red;
    margin-left: 5px;
}

.text-danger {
    display: block; /* Đảm bảo thông báo lỗi xuống hàng */
    color: red;
    margin-top: 5px; /* Thêm khoảng cách phía trên để tránh chồng lên nhau */
}

</style>
<form class="form-register" action="{{ route('register') }}" method="POST">
    <div>
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
                <input type="email" name="email" value="{{ old('email') }}" required>
                @if ($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="phone">Số điện thoại<span class="required">*</span>:</label>
                <input type="text" name="phone" value="{{ old('phone') }}" required>
                @if ($errors->has('phone'))
                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                @endif
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
            <div class="form-group">
                <label for="address">Địa chỉ:</label>
                <input type="text" name="address" value="{{ old('address') }}">
                @if ($errors->has('address'))
                    <span class="text-danger">{{ $errors->first('address') }}</span>
                @endif
            </div>
        </div>

        <button type="submit">Đăng ký</button>
    </div>
</form>











@endsection
