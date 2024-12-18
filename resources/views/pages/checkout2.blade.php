@extends('layouts.master')
@section('title', 'Thanh toán')
@section('content')
<style>
    #message {
        text-align: center;
    border-radius: 5px;
    padding: 15px;
    font-size: 14px;
    font-weight: bold;
    /* box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); */
}
.alert-success {
    background-color: #d4edda;
    color: #155724;
    border-color: #c3e6cb;
}
.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
    border-color: #f5c6cb;
}
.discount-message {
    color: green;
    font-size: 14px;
    background-color: #d6e1d2; /* Màu nền nhẹ để nổi bật */
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #4CAF50; /* Đường viền màu xanh lá */
    margin: 10px 0; /* Khoảng cách trên và dưới */
}

</style>

    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="#">Giỏ hàng</a></li>
                <li class="breadcrumb-item active" aria-current="page">Thanh toán</li>
            </ol>
        </nav>
    </div>
    
    <section class="section-checkout">
        <div class="container">
            <div class="swapper">
                <div id="message" class="message"></div>
                <form id="discount-form" class="discount-form" action="{{ route('applyDiscount') }}" method="POST">
                    @csrf
                    <div class="inner-form-group">
                        @if($discount && $discount->quantity > 0)
                            <p class="discount-message">
                                Bạn có mã giảm giá: <strong>{{ $discount->code }}</strong> 
                                (Giảm {{ intval($discount->discount_percent) }}%)
                            </p>
                        @endif
                        <div class="input-group">
                            <input type="text"name="discount_code" id="discount_code"  placeholder="Nhập mã giảm giá"
                                required>
                            <button type="submit">Áp dụng</button>
                        </div>
                    </div>
                </form>
                <form id="checkout-form" action="{{ route('checkout.complete') }}" method="POST" class="inner-section">
                    @csrf
                    <div class="inner-left">
                        <h3 class="inner-title info">Thông tin nhận hàng</h3>
                        <div class="inner-info">
                            <div class="group-form">
                                <label for="name">Họ và tên</label>
                                <input type="text" name="name" id="name" class="custom-form-control"
                                    placeholder="Họ và tên" value="{{ old('name', $user->name ?? '') }}" required>
                                <small id="name-error" class="text-danger" style="display:none;">
                                    Vui lòng nhập họ và tên
                                </small>
                            </div>
                            <div class="group-form">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="custom-form-control"
                                    placeholder="Email" value="{{ old('email', $user->email ?? '') }}" required>
                                <small id="email-error" class="text-danger" style="display:none;">
                                    Vui lòng nhập email
                                </small>
                            </div>
                            <div class="group-form">
                                <label for="phone">Số điện thoại</label>
                                <input type="text" name="phone" id="phone" class="custom-form-control"
                                    placeholder="Số điện thoại" value="{{ old('phone', $user->phone ?? '') }}" required>
                                <small id="phone-error" class="text-danger" style="display:none;">
                                    Vui lòng nhập số điện thoại
                                </small>
                            </div>
                            <div class="group-form">
                                <label for="name">Địa chỉ</label>
                                <input type="text" name="address" id="street" class="custom-form-control"
                                    placeholder="Địa chỉ" value="{{ old('street', $user->street ?? '') }}" required>
                                <small id="street-error" class="text-danger" style="display:none;">
                                    Vui lòng nhập địa chỉ
                                </small>
                            </div>
                            <div class="group-form">
                                <label for="name">Tỉnh/Thành phố</label>
                                <select class="custom-form-control" name="province_id" id="province" required>
                                    <option value="{{ $user->province_id ?? '' }}">
                                        {{ $user->province->name ?? 'Vui lòng chọn Tỉnh/Thành phố' }}
                                    </option>
                                    @if (!empty($provinces))
                                        @foreach ($provinces as $province)
                                            <option value="{{ $province->province_id ?? '' }}" 
                                                {{ $province->province_id == ($user->province_id ?? '') ? 'selected' : '' }}>
                                                {{ $province->name }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="">Không có dữ liệu</option>
                                    @endif
                                </select>
                            </div>
                            <div class="group-form">
                                <label for="name">Quận/Huyện</label>
                                <select class="custom-form-control district" name="district_id" id="district" required>
                                    <option value="{{ $user->district_id ?? ''}}">
                                        {{ $user->district->name ?? 'Vui lòng chọn Quận/Huyện' }}
                                    </option>
                                </select>
                            </div>
                            <div class="group-form">
                                <label for="name">Phường/Xã</label>
                                <select class="custom-form-control" name="ward_id" id="ward" required>
                                    <option value="{{ $user->wards_id ?? ''}}">
                                        {{ $user->ward->name ?? 'Vui lòng chọn Phường/Xã' }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <h3 class="inner-title shipping">Vận chuyển</h3>
                        <div class="group-form-check">
                            <label for="shipping-home" class="form-check-label">
                                <input type="radio" class="form-check-input" name="shipping_method" id="shipping-home"
                                    value="home_delivery" required> Giao hàng tận nơi</label>
                        </div>
                        <h3 class="inner-title payment-method">Phương thức thanh toán</h3>
                        @foreach (['cod' => 'Thanh toán khi nhận hàng', 'vnpay' => 'Thanh toán qua VNPAY', 'momo' => 'Thanh toán qua MoMo'] as $method => $label)
                            <div class="group-form-check">
                                <label for="payment-{{ $method }}" class="form-check-label">
                                    <input type="radio" class="form-check-input" name="payment_method"
                                        id="payment-{{ $method }}" value="{{ $method }}" required>
                                    {{ $label }}</label>
                            </div>
                        @endforeach
                    </div>


                    @if (isset($cart) && count($cart) > 0)
                        @php
                            $totalPrice = 0;
                            $shippingCost = 0; // Phí vận chuyển
                        @endphp
                        <div class="inner-right">
                            <h3 class="inner-title">Đơn hàng có ({{ count($cart) }}) sản phẩm</h3>
                            @foreach ($cart as $item)
                                <div class="inner-product-cart">

                                    @php
                                        // Ưu tiên sử dụng price_gift nếu tồn tại
                                        $price = $item['price_gift'] ?? ($item['price'] ?? 0);

                                        // Tính tổng giá cho từng sản phẩm hoặc giỏ quà
                                        $itemTotal = isset($item['fruits'])
                                            ? $item['total']
                                            : $price * ($item['quantity'] ?? 1);

                                        $totalPrice += $itemTotal;

                                        // Lấy số lượng sản phẩm
                                        $quantity = isset($item['fruits']) ? 1 : $item['quantity'] ?? 0;
                                    @endphp
                                    @php
                                        // Xử lý đường dẫn hình ảnh
                                        $imagePath = isset($item['fruits'])
                                            ? (strpos($item['basket_image'], 'uploads/products/') === 0
                                                ? asset($item['basket_image']) // Nếu đường dẫn bắt đầu bằng 'uploads/products/', không thêm 'layouts/img/'
                                                : asset('layouts/img/' . $item['basket_image']))
                                            : (is_array($item) && isset($item['image'])
                                                ? (strpos($item['image'], 'uploads/products/') === 0
                                                    ? asset($item['image']) // Nếu đường dẫn bắt đầu bằng 'uploads/products/', không thêm 'layouts/img/'
                                                    : asset('layouts/img/' . $item['image']))
                                                : asset('layouts/img/default-image.jpg')); // Đảm bảo có hình ảnh mặc định
                                    @endphp

                                    <div class="inner-img-quantity">
                                        <img src="{{ $imagePath }}"
                                            alt="{{ isset($item['fruits']) ? 'Gift Basket Image' : 'Product lll' }}"
                                            class="img-fluid">

                                        {{-- Hiển thị số lượng sản phẩm --}}
                                        <span>x {{ $quantity }}</span>
                                    </div>

                                    {{-- Hiển thị tổng giá cho sản phẩm --}}
                                    <span class="font-weight-bold">{{ number_format($itemTotal) }}đ</span>

                                </div>
                            @endforeach
                            @php
                                if (isset($productData['price']) && isset($productData['quantity'])) {
                                    // Tính tổng giá cho sản phẩm mới
                                    $newItemTotal = $productData['price'] * $productData['quantity'];
                                    $totalPrice += $newItemTotal; // Cộng thêm vào tổng giá
                                } else {
                                    // Xử lý khi có giá trị null hoặc không hợp lệ
                                    Log::error('Product price or quantity is null or invalid', [
                                        'productData' => $productData,
                                    ]);
                                }
                            @endphp
                            <div class="inner-order">
                                <div class="inner-summary">
                                    <span>Tạm tính</span>
                                    <p id="total-price" data-price="{{ $totalPrice }}">
                                        {{ number_format($totalPrice) }}đ</p>
                                </div>
                                <div class="inner-summary">
                                    <span>Phí vận chuyển</span>
                                    <p>{{ number_format($shippingCost) }}đ</p>
                                </div>
                                <div class="inner-summary pb-2">
                                    <span>Giảm giá (%)</span>
                                    <p id="discount-percentage">{{ $discountPercentage ?? 0 }}đ</p>
                                </div>
                                <div class="inner-summary inner-total pt-2">
                                    <span class="font-weight-bold">Tổng cộng</span>
                                    <p id="total-remaining" class="font-weight-bold">
                                        {{ number_format($totalPrice + $shippingCost - ($totalPrice * ($discountPercentage ?? 0)) / 100) }}đ
                                    </p>
                                </div>
                            </div>

                            <div class="inner-order-button">
                                <a href="{{ route('cart.index') }}">Quay lại giỏ hàng</a>
                                <button type="submit" id="place-order">Đặt hàng</button>
                            </div>

                        </div>
                    @endif
                </form>
                {{-- Thêm form thanh toán VNPAY --}}
                <form action="{{ route('vnpay_payment') }}" method="POST" id="vnpay-form" style="display:none;">
                    @csrf
                    <input type="hidden" name="redirect" value="true">
                    <input type="hidden" name="name" id="vnpay_name">
                    <input type="hidden" name="email" id="vnpay_email">
                    <input type="hidden" name="phone" id="vnpay_phone">
                    <input type="hidden" name="address" id="vnpay_address">
                    <input type="hidden" name="province_id" id="vnpay_province_id">
                    <input type="hidden" name="district_id" id="vnpay_district_id">
                    <input type="hidden" name="ward_id" id="vnpay_ward_id">
                    <!-- <input type="hidden" name="note" id="note"> -->
                    <input type="hidden" name="price" id="vnpay_price"
                        value="{{ number_format($totalPrice + $shippingCost) ?? 0 }}">
                </form>
                {{-- Thêm form thanh toán MoMo --}}
                <form action="{{ route('momo') }}" method="POST" id="momo-form" style="display:none;">
                    @csrf
                    <input type="hidden" name="payUrl" value="true">
                    <input type="hidden" name="name" id="momo_name">
                    <input type="hidden" name="email" id="momo_email">
                    <input type="hidden" name="phone" id="momo_phone">
                    <!-- <input type="hidden" name="note" id="note"> -->
                    <input type="hidden" name="address" id="momo_address">
                    <input type="hidden" name="province_id" id="momo_province_id">
                    <input type="hidden" name="district_id" id="momo_district_id">
                    <input type="hidden" name="ward_id" id="momo_ward_id">
                    <input type="hidden" name="price" id="momo_price"
                        value="{{ number_format($totalPrice + $shippingCost) ?? 0 }}">
                </form>

            </div>
        </div>
    </section>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const provinceId = $('#province').val();
        console.log('provinceId', provinceId);

        $(document).ready(function() {
            // Lấy dữ liệu từ server thông qua data attributes
            let totalPrice = document.getElementById('total-price').getAttribute('data-price');
            let shippingCost = 0;
            totalPrice = parseFloat(totalPrice);
            totalPrice = totalPrice + shippingCost;
            let selectedPaymentMethod = null;

            // Xử lý áp dụng mã giảm giá
            $('#discount-form').on('submit', function(event) {
                event.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        console.log('response',response);
                        
                        let totalAfterDiscount = parseFloat(response.total_price)
                            .toLocaleString('vi-VN', {
                                style: 'currency',
                                currency: 'VND',
                            });

                        $('#discount-percentage').text(response.discount + '%');
                        $('#total-remaining').text(totalAfterDiscount);
                        $('#message')
                            .text(response.message)
                            .removeClass('alert-danger')
                            .addClass('alert alert-success')
                            .show();
                    },
                    error: function(xhr) {
                        $('#message')
                            .text(xhr.responseJSON?.message ||
                                'Mã giảm giá không hợp lệ hoặc đã hết hạn.')
                            .removeClass('alert-success')
                            .addClass('alert alert-danger')
                            .show();
                    },
                });
            });





            // Theo dõi lựa chọn phương thức thanh toán
            $('input[name="payment_method"]').on('change', function() {
                selectedPaymentMethod = $(this).val();
            });

            // Xử lý khi nhấn nút "Đặt hàng"
            $('#checkout-form').on('submit', function(event) {
                event.preventDefault(); // Ngăn gửi form mặc định

                if (!selectedPaymentMethod) {
                    alert("Vui lòng chọn phương thức thanh toán.");
                    return;
                }

                // Chuẩn bị thông tin cho các phương thức thanh toán
                const paymentFields = {
                    name: $('input[name="name"]').val(),
                    email: $('input[name="email"]').val(),
                    phone: $('input[name="phone"]').val(),
                    address: $('input[name="address"]').val(),
                    ward_id: $('#ward').val(),
                    district_id: $('#district').val(),
                    province_id: $('#province').val(),
                    price: totalPrice
                };


                // Xử lý thanh toán theo từng phương thức
                if (selectedPaymentMethod === 'momo') {
                    fillForm('#momo-form', paymentFields);
                } else if (selectedPaymentMethod === 'vnpay') {
                    fillForm('#vnpay-form', paymentFields);
                } else {
                    this.submit(); // Thanh toán COD hoặc khác
                }
            });

            // Hàm điền thông tin vào form thanh toán
            function fillForm(formSelector, data) {
                Object.keys(data).forEach(key => {
                    $(`${formSelector} [name="${key}"]`).val(data[key]);
                });
                $(formSelector).submit();
            }

            // Kiểm tra các trường thông tin có được nhập đầy đủ không
            const requiredFields = document.querySelectorAll('.user-info-group input');
            const paymentMethods = document.querySelectorAll('input[name="payment_method"]');

            function checkFormCompletion() {
                let allFieldsFilled = Array.from(requiredFields).every(input => input.value.trim() !== '');
                paymentMethods.forEach(input => {
                    input.disabled = !allFieldsFilled; // Bật/tắt thuộc tính disabled
                });
            }

            // Lắng nghe sự kiện nhập liệu trên các trường thông tin
            requiredFields.forEach(input => {
                input.addEventListener('input', checkFormCompletion);
            });

            // Kiểm tra khi tải trang lần đầu tiên
            checkFormCompletion();
        });
    </script>

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
@endsection
