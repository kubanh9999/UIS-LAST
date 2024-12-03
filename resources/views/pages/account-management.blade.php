@extends('layouts.master')
@section('title', 'Quản lý tài khoản')
@section('content')

    <style>
       /* Đặt container tổng quát */
.container {
    font-family: Arial, sans-serif;
}

/* Sidebar */
.list-group-item {
    background-color: #f8f9fa;
    border: none;
    padding: 12px 15px;
}

.list-group-item a {
    color: #007bff;
    font-weight: 500;
    text-decoration: none;
    transition: color 0.3s ease;
}

.list-group-item a:hover {
    color: #0056b3;
}

/* Nội dung chính */
.content-section {
    background: #ffffff;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
    display: none; /* Ẩn mặc định */
}

#info {
    display: block; /* Chỉ hiển thị phần thông tin tài khoản */
}

.content-section h3 {
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 15px;
    color: #007bff;
}

.content-section p, .content-section .form-label {
    font-size: 14px;
    color: #555;
}

/* Form inputs */
.form-control {
    font-size: 14px;
    padding: 8px 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    transition: border-color 0.3s ease;
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: none;
}

.text-danger {
    font-size: 13px;
    color: #dc3545;
}

/* Nút cập nhật mật khẩu */
.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    transition: background-color 0.3s ease;
}

.btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
}

/* Phần lịch sử mua hàng */
.card {
    border: 1px solid #f0f0f0;
    border-radius: 8px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.05);
}

.card-title {
    font-size: 18px;
    font-weight: 600;
    color: #333;
}

.card-text {
    font-size: 14px;
    color: #666;
}

.text-success {
    font-weight: bold;
    color: #28a745;
}

/* Nút xem chi tiết */
.btn-secondary {
    font-size: 14px;
    background-color: #6c757d;
    border: none;
    transition: background-color 0.3s ease;
}

.btn-secondary:hover {
    background-color: #5a6268;
}

/* Hiệu ứng chọn trên sidebar */
.list-group-item.active {
    background-color: #007bff;
    color: #fff;
}

.list-group-item.active a {
    color: #fff;
}

    </style>

<body>

@if($errors->any())
<script>
    let errorMessage = '';
    @foreach ($errors->all() as $error)
        errorMessage += '{{ $error }}\n';
    @endforeach
    alert(errorMessage);
</script>
@endif

@if(session('status'))
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
<div class="container mt-5">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <a href="#" class="text-main" data-target="#info">Thông tin tài khoản</a>
                </li>
                <li class="list-group-item">
                    <a href="#" class="text-main" data-target="#password">Thay đổi mật khẩu</a>
                </li>
                <li class="list-group-item">
                    <a href="#" class="text-main" data-target="#orders">Lịch sử mua hàng</a>
                </li>
            </ul>
        </div>

        <!-- Nội dung chính -->
        <div class="col-md-9">
            <!-- Thông tin tài khoản -->
            <div id="info" class="content-section">
                <form action="{{ route('account.update') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Họ và tên</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}" id="name" >
                    </div>
                
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" id="email" >
                    </div>
                
                    <div class="mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" name="phone" value="{{ old('phone', $user->phone) }}" id="phone" >
                    </div>
                
                   
                    <!-- Hiển thị thông tin tỉnh thành, quận huyện, phường xã -->
                    <div class="mb-3">
                        <label class="form-label ">Tỉnh/Thành phố</label>
                        <select class="form-control" name="province_id" id="province" >
                            <option value="{{ $user->province_id }}" id="data=[]">{{ $user->province->name ?? 'vui lòng chọn Tỉnh thành phố' }}</option>
                            @foreach ($provinces as $province)
                                <option value="{{ $province->province_id }}" 
                                    {{ $province->province_id == $user->province_id ? 'selected' : '' }}>
                                    {{ $province->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                
                    <div class="mb-3">
                        <label class="form-label" ></label>
                        <select class="form-control district" name="district_id" id="district">
                            <!-- Các option sẽ được tải thông qua Ajax khi chọn tỉnh -->
                            <option value="">Vui lòng chọn Quận/Huyện</option>
                        </select>
                    </div>
                    
                    
                    <div class="mb-3">
                        <label class="form-label">Phường/Xã</label>
                        <select class="form-control" name="ward_id" id="ward">
                            <option value="">Vui lòng chọn Phường/Xã</option>
                        </select>
                    </div>
                   
                    <div class="mb-3">
                        <label class="form-label">Số nhà</label>
                        <input type="text" class="form-control" name="street" value="{{ old('street', $user->street) ?? ''}}" id="address" >
                    </div>
                
                    <!-- Nút chỉnh sửa và cập nhật -->
                   {{--  <button type="button" class="btn btn-success" id="edit-btn">Chỉnh sửa</button> --}}
                    <button type="submit" class="btn btn-success" id="update-btn" >Cập nhật</button>
                </form>
                
            </div>
            <!-- Thay đổi mật khẩu -->
            <div id="password" class="content-section">
                <h3>Thay đổi mật khẩu</h3>
                <form action="{{ route('update-password') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="oldPassword" class="form-label">Mật khẩu cũ</label>
                        <input type="password" name="old_password" class="form-control @error('old_password') is-invalid @enderror" id="oldPassword" placeholder="Nhập mật khẩu cũ">
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
                    <div class="mb-3">
                        <label for="newPassword" class="form-label">Mật khẩu mới</label>
                        <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" id="newPassword" placeholder="Nhập mật khẩu mới">
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
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Xác nhận mật khẩu</label>
                        <input type="password" name="new_password_confirmation" class="form-control" id="confirmPassword" placeholder="Xác nhận mật khẩu">
                    </div>                    
                    <button type="submit" class="btn btn-primary">Cập nhật mật khẩu</button>
                </form>
            </div>

            <!-- Lịch sử mua hàng -->
            <div id="orders" class="content-section">
                <h3>Lịch sử mua hàng</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">#ID</th>
                            <th scope="col">Tên người mua</th>
                            <th scope="col">Địa chỉ giao hàng</th>
                            <th scope="col">Số điện thoại</th>
                            <th scope="col">Ngày đặt hàng</th>
                          
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Phương thức thanh toán</th>
                            <th scope="col">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $item)
                        <tr>
                            <td>#{{ $item->id }}</td>
                            <td>{{ $item->user->name }}</td> <!-- Hiển thị tên người mua -->
                            <td>{{ $item->address }}</td> <!-- Hiển thị địa chỉ giao hàng -->
                            <td>{{ $item->phone }}</td> <!-- Hiển thị số điện thoại -->
                            <td>{{ \Carbon\Carbon::parse($item->order_date)->format('d/m/Y') }}</td>
                         
                            <td>
                                <span class="badge 
                                    @if($item->status == -1) bg-danger 
                                    @elseif($item->status == 0) bg-warning 
                                    @elseif($item->status == 1) bg-info 
                                    @elseif($item->status == 2) bg-success 
                                    @else bg-secondary @endif">
                                    @if($item->status == -1)
                                        Đơn hàng đã hủy
                                    @elseif($item->status == 0)
                                        Đơn hàng đang được xử lý
                                    @elseif($item->status == 1)
                                        Đơn hàng đang vận chuyển
                                    @elseif($item->status == 2)
                                        Đơn hàng đã được giao thành công
                                    @else
                                        Không xác định
                                    @endif
                                </span>
                            </td>
                            <td>{{ $item->payment_method }}</td>
                            <td>
                                <a href="{{ route('account.management.order.detail', $item->id) }}" class="btn btn-success btn-sm"><i class="fa-solid fa-eye"></i></a>
                                @if ($item->status == 0) <!-- Chỉ hiển thị nút hủy nếu trạng thái là "Đang xử lý" -->
                                    <a href="{{ route('account.order.cancel', $item->id) }}" class="btn btn-danger btn-sm cancel-order" data-method="POST" data-confirm="Bạn có chắc chắn muốn hủy đơn hàng này?">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                @else
                                    <button class="btn btn-secondary btn-sm" disabled>    <i class="fa-solid fa-trash"></i></button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
    // Khi tỉnh thành thay đổi
    $('#province').change(function() {
        var provinceId = $(this).val();
        console.log(provinceId);
        console.log('dữ liệu district:',district.id);
        // Nếu tỉnh thành được chọn
        if (provinceId) {
            console.log('Sending request to:', '/get-districts/' + provinceId);
            $.ajax({
           
                url: '/get-districts/' + provinceId,  // Đường dẫn tới controller Laravel
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Gửi CSRF token
                },
                success: function (data) {
                    console.log('Dữ liệu trả về từ server:', data);
                    // Xóa các option hiện tại trong select quận/huyện và phường/xã
                    $('#district').empty();
                    $('#ward').empty();
                    
                    // Thêm option mặc định cho quận/huyện
                    $('#district').append('<option value="">Vui lòng chọn Quận/Huyện</option>');

                    // Thêm các quận/huyện mới vào select
                    if (data.districts && data.districts.length > 0) {
                        $.each(data.districts, function (index, district) {
                            $('#district').append('<option value="' + district.district_id + '">' + district.name + '</option>');
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

    // Khi quận huyện thay đổi
    $('.district').change(function() {
        console.log('Sự kiện change đã được gọi');
        var districtId = $(this).val();
console.log('districtId:',districtId);


        // Nếu quận huyện được chọn
        if (districtId) {
            $.ajax({
                url: '/get-wards/' + districtId,  // Đường dẫn tới controller Laravel
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Gửi CSRF token
                },
                success: function(data) {
                    // Xóa các option hiện tại trong select phường/xã
                    $('#ward').empty();

                    // Thêm option mặc định cho phường/xã
                    $('#ward').append('<option value="">Vui lòng chọn Phường/Xã</option>');
                    // Thêm các phường/xã mới vào select
                    $.each(data.wards, function(index, ward) {
                        $('#ward').append('<option value="' + ward.id + '">' + ward.name + '</option>');
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
    
    document.querySelectorAll('.list-group-item a').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const target = this.getAttribute('data-target');
            
            // Ẩn tất cả các section
            document.querySelectorAll('.content-section').forEach(section => {
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
    document.getElementById('edit-btn').addEventListener('click', function() {
        // Làm các trường input có thể chỉnh sửa
        document.getElementById('name').removeAttribute('readonly');
        document.getElementById('email').removeAttribute('readonly');
        document.getElementById('phone').removeAttribute('readonly');
        document.getElementById('address').removeAttribute('readonly');
        
        // Ẩn nút "Chỉnh sửa", hiển thị nút "Cập nhật"
        this.style.display = 'none';
        document.getElementById('update-btn').style.display = 'inline-block';
    });


</script>
<script>
     $(document).on('change', '.select2[name$="[city]"]', function() {
            const addressId = $(this).attr('id').split('_')[1];
            const cityId = $(this).val();
            loadOptions(`https://esgoo.net/api-tinhthanh/2/${cityId}.htm`, `district_${addressId}`,
                'Chọn Quận/Huyện');
            $(`#ward_${addressId}`).html('<option value="">Chọn Phường/Xã</option>').trigger(
                'change');
        });

        // Handle district change to load wards
        $(document).on('change', '.select2[name$="[district]"]', function() {
            const addressId = $(this).attr('id').split('_')[1];
            const districtId = $(this).val();
            loadOptions(`https://esgoo.net/api-tinhthanh/3/${districtId}.htm`, `ward_${addressId}`,
                'Chọn Phường/Xã');
        });
</script>
@endsection
