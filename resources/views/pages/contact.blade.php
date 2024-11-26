@extends('layouts.master')
@section('title', 'Trang Liên Hệ')
@section('content')

    <!-- Đảm bảo không bị chồng lấn bằng cách thêm padding trên -->
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

            <!-- Form bên trái -->
            <div class="col-md-6">
                <div class="contact-form-container">
                    <h2>Mọi thắc mắc, ý kiến đóng góp vui lòng liên hệ:</h2>
                    <p>📍 Địa chỉ: công viên phần mềm Quang Trung TPHCM</p>
                    <p>📞 Tổng Đài Hỗ Trợ: 0378966102</p>
                    <p>📧 Email: theanhdzno1st@gmail.com</p>

                    <form action="/submit_form" method="POST" class="contact-form">
                        @csrf
                        <label for="category">Chọn danh mục cần hỗ trợ tại đây</label>
                        <select id="category" name="category" required class="form-control">
                            <option value="">Chọn danh mục</option>
                            <option value="support" {{ old('category') == 'support' ? 'selected' : '' }}>Hỗ Trợ</option>
                            <option value="feedback" {{ old('category') == 'feedback' ? 'selected' : '' }}>Góp Ý</option>
                        </select>
                        @error('category')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    
                        <label for="name">Họ tên*</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required class="form-control">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    
                        <label for="email">Email*</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required class="form-control">
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    
                        <label for="phone">Số điện thoại*</label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required class="form-control">
                        @error('phone')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    
                        <label for="message">Nhập nội dung*</label>
                        <textarea id="message" name="message" rows="5" required class="form-control">{{ old('message') }}</textarea>
                        @error('message')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    
                        <button type="submit" class="btn btn-success w-100 mt-3">Gửi</button>
                    </form>
                    
                </div>
            </div>

            <!-- Bản đồ bên phải -->
            <div class="col-md-6">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3918.454437462157!2d106.62420897457578!3d10.852999257777634!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752bee0b0ef9e5%3A0x5b4da59e47aa97a8!2zQ8O0bmcgVmnDqm4gUGjhuqduIE3hu4FtIFF1YW5nIFRydW5n!5e0!3m2!1svi!2s!4v1731379816034!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>

    <!-- Thêm Bootstrap JS và Google Maps API -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    {{-- <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY&callback=initMap" async defer></script>

    <script>
        function initMap() {
            var location = {lat: 10.779217, lng: 106.692141}; // Vị trí của bạn

            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 15,
                center: location
            });

            var marker = new google.maps.Marker({
                position: location,
                map: map
            });
        }
    </script> --}}
@endsection
