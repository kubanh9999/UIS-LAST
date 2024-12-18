@extends('layouts.master')
@section('title', 'Quản lý tài khoản')
@section('content')
<style>
    .btn-light-green {
    background-color: #a8e6a3; /* Xanh lá nhạt */
    color: #000;
    border: none;
}

.btn-light-green:hover {
    background-color: #87d987; /* Xanh lá hơi đậm khi hover */
}

</style>


    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Quản lý tài khoản</li>
            </ol>
        </nav>
    </div>


    <section class="section-account-manager">
        <div class="container">
            <div class="swapper">
                <div class="inner-left">
                    <ul class="list-group list-group-flush">
                        <li class="group-item">
                            <a href="#" class="text-main" data-target="#info">Thông tin tài
                                khoản</a>
                        </li>
                        <li class="group-item">
                            <a href="#" class="text-main" data-target="#password">Thay đổi mật
                                khẩu</a>
                        </li>
                        <li class="group-item">
                            <a href="#" class="text-main" data-target="#khuyenmai">Khuyến mãi</a>
                        </li>
                        <li class="group-item">
                            <a href="#" class="text-main" data-target="#orders">Lịch sử mua
                                hàng</a>
                        </li>
                    </ul>
                </div>
                <div class="inner-right">
                    @if ($errors->any())
                        <script>
                            let errorMessage = '';
                            @foreach ($errors->all() as $error)
                                errorMessage += '{{ $error }}\n';
                            @endforeach
                            alert(errorMessage);
                        </script>
                    @endif

                    @if (session('status'))
                        <script>
                            alert('{{ session('status') }}');
                        </script>
                    @endif
                    <!-- Hiển thị thông báo thành công -->
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Hiển thị thông báo lỗi -->
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div id="info" class="inner-content">
                        <form action="{{ route('account.update') }}" method="POST" class="form-info">
                            @csrf
                            <div class="input-group">
                                <label for="name">Họ và tên</label>
                                <input type="text" name="name" class="input-control"
                                    value="{{ old('name', $user->name) }}" id="name">
                            </div>
                            <div class="input-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="input-control"
                                    value="{{ old('email', $user->email) }}" id="email">
                            </div>
                            <div class="input-group">
                                <label for="phone">Số điện thoại</label>
                                <input type="text" name="phone" class="input-control"
                                    value="{{ old('phone', $user->phone) }}" id="phone">
                            </div>
                            <div class="input-group">
                                <label for="province">Tỉnh, Thành phố</label>
                                <select class="input-control" name="province_id" id="province">
                                    <option value="{{ $user->province_id }}" id="data=[]">
                                        {{ $user->province->name ?? 'vui lòng chọn Tỉnh thành phố' }}</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->province_id }}"
                                            {{ $province->province_id == $user->province_id ? 'selected' : '' }}>
                                            {{ $province->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-group">
                                <label for="district">Quận, Huyện</label>
                                <select class="input-control district" name="district_id" id="district">
                                    <!-- Các option sẽ được tải thông qua Ajax khi chọn tỉnh -->
                                    <option value="">{{ $user->district->name ?? 'vui lòng chọn Quận/Huyện' }}
                                    </option>
                                </select>
                            </div>
                            <div class="input-group">
                                <label for="ward">Phường, Xã</label>
                                <select class="input-control" name="ward_id" id="ward">
                                    <option value="">{{ $user->ward->name ?? 'vui lòng chọn Phường/Xã' }}</option>
                                </select>
                            </div>
                            <div class="input-group">
                                <label for="address">Số nhà</label>
                                <input type="text" class="input-control" name="street"
                                    value="{{ old('street', $user->street) ?? '' }}" id="address">
                            </div>
                            <button type="submit" class="btn-update" id="update-btn">Cập nhật</button>
                        </form>
                    </div>

                    <div id="password" class="inner-content">
                        <form action="{{ route('update-password') }}" method="POST">
                            @csrf
                            <div class="input-group">
                                <label for="oldPassword">Mật khẩu cũ</label>
                                <input type="password" name="old_password"
                                    class="input-control @error('old_password') is-invalid @enderror" id="oldPassword"
                                    placeholder="Nhập mật khẩu cũ">
                                @error('old_password')
                                    <span class="text-danger">
                                        @if ($message == 'The old password field is required.')
                                            Vui lòng nhập mật khẩu cũ.
                                        @else
                                            {{ $message }}
                                        @endif
                                    </span>
                                @enderror
                            </div>
                            <div class="input-group">
                                <label for="newPassword">Mật khẩu mới</label>
                                <input type="password" name="new_password"
                                    class="input-control @error('new_password') is-invalid @enderror" id="newPassword"
                                    placeholder="Nhập mật khẩu mới">
                                @error('new_password')
                                    <span class="text-danger">
                                        @if ($message == 'The new password field is required.')
                                            Vui lòng nhập mật khẩu mới.
                                        @elseif ($message == 'The new password confirmation does not match.')
                                            Xác nhận mật khẩu không khớp.
                                        @else
                                            {{ $message }}
                                        @endif
                                    </span>
                                @enderror
                            </div>
                            <div class="input-group">
                                <label for="confirmPassword">Xác nhận mật khẩu</label>
                                <input type="password" name="new_password_confirmation" class="input-control"
                                    id="confirmPassword" placeholder="Xác nhận mật khẩu">
                            </div>
                            <button type="submit" class="btn-update">Cập nhật mật khẩu</button>
                        </form>
                    </div>

                    <div id="khuyenmai" class="inner-content">
                        <div class="input-group">
                            <label for="">Voucher</label>
                            <input disabled type="text" 
                            value="{{ $discount && $discount->quantity > 0 ? 'Mã voucher giảm giá ' . number_format($discount->discount_percent, 0) . '%: ' . $discount->code : 'Không có mã giảm giá' }}"
                                class="input-control" 
                                placeholder="Không có voucher">
                        </div>
                    </div>


                    <div id="orders" class="inner-content">
                        @foreach ($orders as $item)
                            <div class="card">
                                <div class="card-header">
                                    <strong>#{{ $item->id }} |
                                        {{ \Carbon\Carbon::parse($item->order_date)->timezone('Asia/Ho_Chi_Minh')->format('H:i:s | d/m/Y') }}</strong>
                                </div>
                                <div class="card-body">
                                    <p><strong>Tên người mua:</strong> {{ $item->user->name }}</p>
                                    <p><strong>Số điện thoại:</strong> {{ $item->phone }}</p>
                                    <p><strong>Trạng thái:</strong> <span class="badge {{ $item->status == 'Đang xử lý' ? 'bg-warning' : 'bg-success' }}">{{ $item->status }}</span></p>
                                    <p><strong>Phương thức thanh toán:</strong> {{ $item->payment_method }}</p>
                                    
                                    <div class="justify-content-between">
                                        @if ($item->status == 'Hoàn thành')
                                            <a href="https://www.facebook.com/profile.php?id=100094217616470" target="_blank" class="btn btn-light-green btn-sm">
                                                <i class="fa-solid fa-star"></i> Đánh giá
                                            </a>  
                                        @else
                                            <a href="{{ route('account.management.order.detail', $item->id) }}" class="btn btn-success btn-sm">
                                                <i class="fa-solid fa-eye"></i> Xem chi tiết
                                            </a>
                                        @endif

                                        {{-- @if ($item->payment_method == 'Thanh toán khi nhận hàng') --}}
                                        @if ($item->status == 'Đang xử lý')
                                            <a href="{{ route('account.order.cancel', $item->id) }}" 
                                            class="btn btn-danger btn-sm cancel-order" 
                                            data-method="POST" 
                                            data-confirm="Bạn có chắc chắn muốn hủy đơn hàng này?">
                                                <i class="fa-solid fa-trash"></i> Hủy đơn hàng
                                            </a>
                                        @elseif ($item->status == 'Đang vận chuyển')
                                            {{-- <a href="#" class="btn btn-warning btn-sm ">
                                                <i class="fa-solid fa-truck"></i> Đang vận chuyển
                                            </a> --}}
                                        @elseif ($item->status == 'Đã giao')
                                            <a href="{{ route('order.confirm', $item->id) }}" 
                                                class="btn btn-success btn-sm cancel-order" 
                                                data-method="POST" 
                                                data-confirm="Bạn có chắc chắn muốn xác nhận đơn hàng này?">
                                                <i class="fa-solid fa-check"></i> Đã nhận được hàng
                                            </a>
                                        @elseif ($item->status == 'Hoàn thành')
                                            <a href="{{ route('account.management.order.detail', $item->id) }}" class="btn btn-success btn-sm">
                                                <i class="fa-solid fa-eye"></i> Hoàn thành
                                            </a>          
                                        @elseif ($item->status == 'Đã hủy' && ($item->payment_method == 'Thanh toán VNPAY' || $item->payment_method == 'Thanh toán MOMO'))
                                            <div class="alert alert-info" role="alert">
                                                <i class="fa-solid fa-info-circle"></i> 
                                                Đơn hàng đã hủy. Liên hệ chúng tôi để hoàn tiền 
                                                <strong>
                                                    <a href="https://zalo.me/0326748389" target="_blank" class="me-2">
                                                        <i class="fa-brands fa-zalo"></i> Zalo: 0326748389
                                                    </a> 
                                                    - 
                                                    <a href="https://www.facebook.com/profile.php?id=100094217616470" target="_blank" class="ms-2">
                                                        <i class="fa-brands fa-facebook"></i> Uis Fruits
                                                    </a>
                                                </strong>.
                                            </div>
                                        @else
                                            <button class="btn btn-close btn-sm" disabled>
                                                <i class="fa-solid fa-trash"></i> Đã hủy
                                            </button>
                                        @endif
                                    
                                        {{-- @endif --}}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>


    
    <script>
        $(document).ready(function() {
            // Khi tỉnh thành thay đổi
            $('#province').change(function() {
                var provinceId = $(this).val();
                console.log(provinceId);
                console.log('dữ liệu district:', district.id);
                // Nếu tỉnh thành được chọn
                if (provinceId) {
                    console.log('Sending request to:', '/get-districts/' + provinceId);
                    $.ajax({

                        url: '/get-districts/' + provinceId, // Đường dẫn tới controller Laravel
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                'content') // Gửi CSRF token
                        },
                        success: function(data) {
                            console.log('Dữ liệu trả về từ server:', data);
                            // Xóa các option hiện tại trong select quận/huyện và phường/xã
                            $('#district').empty();
                            $('#ward').empty();

                            // Thêm option mặc định cho quận/huyện
                            $('#district').append(
                                '<option value="">Vui lòng chọn Quận/Huyện</option>');

                            // Thêm các quận/huyện mới vào select
                            if (data.districts && data.districts.length > 0) {
                                $.each(data.districts, function(index, district) {
                                    $('#district').append('<option value="' + district
                                        .district_id + '">' + district.name +
                                        '</option>');
                                });
                            } else {
                                alert('Không tìm thấy quận/huyện nào.');
                            }
                        },
                        error: function() {
                            alert('Có lỗi xảy ra khi tải quận huyện.');
                        }
                    });
                } else {
                    $('#district').empty();
                    $('#ward').empty();
                }
            });
            /* $('.ward').chance(function(){
                var ward = $(this).val;
                console.log('ward',ward);

            }) */
            // Khi quận huyện thay đổi
            $('.district').change(function() {
                console.log('Sự kiện change đã được gọi');
                var districtId = $(this).val();

                console.log('districtId:', districtId);
                /* console.log('ward',wards.wards_id); */


                // Nếu quận huyện được chọn
                if (districtId) {
                    $.ajax({
                        url: '/get-wards/' + districtId, // Đường dẫn tới controller Laravel
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                'content') // Gửi CSRF token
                        },
                        success: function(data) {
                            // Xóa các option hiện tại trong select phường/xã
                            $('#ward').empty();

                            // Thêm option mặc định cho phường/xã
                            $('#ward').append(
                                '<option value="">Vui lòng chọn Phường/Xã</option>');
                            // Thêm các phường/xã mới vào select
                            $.each(data.wards, function(index, ward) {
                                if (ward.wards_id) {
                                    $('#ward').append('<option value="' + ward
                                        .wards_id + '">' + ward.name + '</option>');
                                    console.log('aaa:', ward.wards_id);
                                }
                            });

                            // Gắn sự kiện change sau khi thêm các option vào dropdown
                            $('#ward').change(function() {
                                var selectedWardId = $(this).val();
                                console.log('Ward selected:', selectedWardId);
                            });
                        },
                        error: function() {
                            alert('Có lỗi xảy ra khi tải phường xã.');
                        }
                    });
                } else {
                    $('#ward').empty();
                }
            });

        });
        /* $('#district').change(function() {
            console.log('Sự kiện change đã được gọi');
            var districtId = $(this).val();  // Lấy giá trị của select theo id
            console.log('districtId:', districtId);  // Kiểm tra giá trị districtId

            if (districtId) {
                // Tiến hành xử lý nếu districtId hợp lệ
            } else {
                console.log('Không có giá trị districtId');
            }
        }); */
    </script>
    <script>
        document.querySelectorAll('.group-item a').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const target = this.getAttribute('data-target');

                // Ẩn tất cả các section
                document.querySelectorAll('.inner-content').forEach(section => {
                    section.style.display = 'none';
                });

                // Hiển thị section được chọn
                document.querySelector(target).style.display = 'block';
            });
        });
        document.querySelectorAll('.cancel-order').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault(); // Ngừng hành động mặc định của thẻ <a>

                // Hiển thị cảnh báo xác nhận
                if (confirm(link.getAttribute('data-confirm'))) {
                    // Tạo form tạm thời để gửi POST request
                    var form = document.createElement('form');
                    form.method = 'POST';
                    form.action = link.getAttribute('href');

                    // Thêm token CSRF vào form
                    var csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    form.appendChild(csrfToken);

                    // Thêm các input ẩn cần thiết cho POST request
                    var methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'POST'; // POST method
                    form.appendChild(methodInput);

                    // Gửi form
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });

        // Hiển thị các trường input có thể chỉnh sửa khi nhấn "Chỉnh sửa"
        /*     document.getElementById('edit-btn').addEventListener('click', function() {
                // Làm các trường input có thể chỉnh sửa
                document.getElementById('name').removeAttribute('readonly');
                document.getElementById('email').removeAttribute('readonly');
                document.getElementById('phone').removeAttribute('readonly');
                document.getElementById('address').removeAttribute('readonly');

                // Ẩn nút "Chỉnh sửa", hiển thị nút "Cập nhật"
                this.style.display = 'none';
                document.getElementById('update-btn').style.display = 'inline-block';
            }); */
    </script>

@endsection
