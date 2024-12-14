@extends('layouts.master')
@section('title', 'Trang Liên Hệ')
@section('content')

<div class="container" style="margin-top: 30px;">
    <div class="row">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- Form liên hệ -->
        <div class="col-md-6">
            <div class="p-4 rounded" style="background-color: #f7f9f8; border: 1px solid #d4d4d4;">
                <h2 class="mb-4" style="color: #74c26e; font-weight: bold;">Liên Hệ Chúng Tôi</h2>
                <p><strong>Địa chỉ:</strong> Công viên phần mềm Quang Trung TPHCM</p>
                <p><strong>Tổng Đài Hỗ Trợ:</strong> 0378966102</p>
                <p><strong>Email:</strong> uisfruits@gmail.com</p>

                <form action="/submit_form" method="POST" class="contact-form mt-4">
                    @csrf
                    <div class="mb-3">
                        <label for="category" class="form-label">Chọn danh mục cần hỗ trợ</label>
                        <select id="category" name="category" required class="form-select">
                            <option value="">Chọn danh mục</option>
                            <option value="support" {{ old('category') == 'support' ? 'selected' : '' }}>Hỗ Trợ</option>
                            <option value="feedback" {{ old('category') == 'feedback' ? 'selected' : '' }}>Góp Ý</option>
                        </select>
                        @error('category')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Họ tên*</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required class="form-control">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email*</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required class="form-control">
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại*</label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required class="form-control">
                        @error('phone')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="message" class="form-label">Nhập nội dung*</label>
                        <textarea id="message" name="message" rows="5" required class="form-control">{{ old('message') }}</textarea>
                        @error('message')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn w-100" style="background-color: #74c26e; color: white; font-weight: bold;">Gửi</button>
                </form>
            </div>
        </div>

        <!-- Bản đồ Google Maps -->
        <div class="col-md-6">
            <div class="rounded overflow-hidden" style="border: 2px solid #74c26e;">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3918.454437462157!2d106.62420897457578!3d10.852999257777634!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752bee0b0ef9e5%3A0x5b4da59e47aa97a8!2zQ8O0bmcgVmnDqm4gUGjhuqduIE3hu4FtIFF1YW5nIFRydW5n!5e0!3m2!1svi!2s!4v1731379816034!5m2!1svi!2s" 
                    width="100%" height="450" style="border: 0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@endsection
