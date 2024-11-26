@extends('layouts.master')
@section('title', 'Thanh toán')
@section('content')
<style>.selected-gift img {
    transition: transform 0.2s;
}

.selected-gift img:hover {
    transform: scale(1.1); /* Tăng kích thước hình ảnh khi hover */
}
.user-info-group {
    margin: 20px 0; /* Khoảng cách nhóm input */
}

.user-info-group .form-group {
    margin-bottom: 15px; /* Khoảng cách giữa các input */
}

</style>


<div class="checkout-container">
    <div class="container bg-white p-4">
        <h1 class="text-center">Thanh Toán</h1>
        <div id="message" class="message mt-3"></div>

        <!-- Form áp dụng mã giảm giá -->
        <!-- Form nhập mã giảm giá -->
<form id="discount-form" class="discount-form mb-4" action="{{ route('applyDiscount') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="discount_code">Nhập mã giảm giá:</label>
        <div class="input-group">
            <input type="text" name="discount_code" id="discount_code" class="form-control" placeholder="Nhập mã giảm giá" required>
            <div class="input-group-append">
                <button type="submit" class="btn btn-primary">Áp dụng</button>
            </div>
        </div>
    </div>
</form>

<!-- Form thanh toán chính -->
        <form id="checkout-form" action="{{ route('checkout.complete') }}" method="POST" class="mb-4" data-shipping-cost="{{ $shippingCost }}">
            @csrf
            <div class="row">
                <!-- Thông tin người nhận hàng -->
                <div class="checkout-left col-lg-7 p-3 border-right">
                    <h2 class="info-title">Thông tin nhận hàng</h2>

                    <div class="user-info-group">
                        @foreach (['email' => 'Email', 'name' => 'Họ và tên', 'phone' => 'Số điện thoại', 'address' => 'Địa chỉ'] as $field => $placeholder)
                            <div class="form-group" style="margin-bottom: 15px;">
                                <input type="{{ $field === 'email' ? 'email' : 'text' }}" name="{{ $field }}" class="form-control" placeholder="{{ $placeholder }}" required>
                                <small id="{{ $field }}-error" class="text-danger" style="display:none;">Vui lòng nhập {{ strtolower($placeholder) }}</small>
                            </div>
                        @endforeach
                    </div>


                    <h2 class="shipping-title mt-4">Vận chuyển</h2>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="shipping_method" id="shipping-home" value="home_delivery" required>
                        <label for="shipping-home" class="form-check-label">Giao hàng tận nơi</label>
                    </div>

                    <h2 class="payment-title mt-4">Thanh toán</h2>
                    @foreach (['cod' => 'Thanh toán khi nhận hàng', 'vnpay' => 'Thanh toán qua VNPAY', 'momo' => 'Thanh toán qua MoMo'] as $method => $label)
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="payment_method" id="payment-{{ $method }}" value="{{ $method }}" required>
                            <label for="payment-{{ $method }}" class="form-check-label">{{ $label }}</label>
                        </div>
                    @endforeach
                </div>

                <!-- Giỏ hàng và tổng kết thanh toán -->
                @if(isset($cart) && count($cart) > 0)
                    @php
                        $totalPrice = 0;
                        $shippingCost = 30000; // Phí vận chuyển
                    @endphp

                    <div class="checkout-right col-lg-5 px-4">
                        <h2 class="sidebar-title text-center">{{ count($cart) }} Sản phẩm trong giỏ hàng</h2>

                        @foreach($cart as $item)
                           @php
                                // Ưu tiên sử dụng price_gift nếu tồn tại
                                $price = $item['price_gift'] ?? $item['price'] ?? 0;

                                // Tính tổng giá cho từng sản phẩm hoặc giỏ quà
                                $itemTotal = isset($item['fruits']) 
                                                ? $item['total'] 
                                                : $price * ($item['quantity'] ?? 1);

                                $totalPrice += $itemTotal;

                                // Lấy số lượng sản phẩm
                                $quantity = isset($item['fruits']) 
                                                ? 1 
                                                : ($item['quantity'] ?? 0);
                            @endphp
                            @php
                                // Xử lý đường dẫn hình ảnh
                                $imagePath = isset($item['fruits']) 
                                    ? asset('layouts/img/' . $item['basket_image']) 
                                    : (is_array($item) && isset($item['image']) 
                                        ? asset('layouts/img/' . $item['image']) 
                                        : asset('layouts/img/default-image.jpg')); // Đảm bảo có hình ảnh mặc định
                            @endphp

                            <div class="info-order-product d-flex align-items-center mb-3 border p-2 rounded shadow-sm">
                              <img 
                                src="{{ $imagePath }}" 
                                alt="{{ isset($item['fruits']) ? 'Gift Basket Image' : 'Product lll' }}" 
                                class="img-fluid" 
                                style="width: 80px; height: 80px;">

                                {{-- Hiển thị số lượng sản phẩm --}}
                                <span class="ml-3 font-weight-bold">{{ $quantity }}</span>

                                {{-- Hiển thị tổng giá cho sản phẩm --}}
                                <span class="ml-auto total font-weight-bold">{{ number_format($itemTotal) }} VND</span>
                            </div>


                            
                        @endforeach
                      
                                
                        @php
                            if (isset($productData['price']) && isset($productData['quantity'])) {
                            // Tính tổng giá cho sản phẩm mới
                            $newItemTotal = $productData['price'] * $productData['quantity'];
                            $totalPrice += $newItemTotal; // Cộng thêm vào tổng giá
                        } else {
                            // Xử lý khi có giá trị null hoặc không hợp lệ
                            Log::error('Product price or quantity is null or invalid', ['productData' => $productData]);
                        }
                        @endphp
                    
   
                        <div class="order-summary mt-3">
                            <div class="d-flex justify-content-between">
                                <p class="mb-0">Tạm tính</p>
                                <span id="total-price" data-price="{{ $totalPrice }}">{{  number_format($totalPrice) }} VND</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="mb-0">Phí vận chuyển</p>
                                <span>{{ number_format($shippingCost) }} VND</span>
                            </div>
                        </div>

                        <div class="total-summary d-flex justify-content-between mt-4">
                            <p class="mb-0">Giảm giá (%)</p>
                            <span id="discount-percentage">{{ $discountPercentage ?? 0 }}</span>
                        </div>
                        
                        <div class="total-summary d-flex justify-content-between mt-4">
                            <p class="mb-0 font-weight-bold">Tổng cộng</p>
                            <span id="total-remaining" class="font-weight-bold">{{ number_format($totalPrice + $shippingCost - ($totalPrice * ($discountPercentage ?? 0) / 100)) }} VND</span>
                        </div>

                        <div class="action-buttons mt-4 d-flex justify-content-between">
                            <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">Quay lại giỏ hàng</a>
                            <button type="submit" class="btn btn-success" id="place-order">Đặt hàng</button>
                        </div>
                    </div>
                @endif
            </div>
        </form>



        {{-- Thêm form thanh toán VNPAY --}}
        <form action="{{ route('vnpay_payment') }}" method="POST" id="vnpay-form" style="display:none;">
            @csrf

            <input type="hidden" name="redirect" value="true">
            <input type="hidden" name="name" id="vnpay_name">
            <input type="hidden" name="email" id="vnpay_email">
            <input type="hidden" name="phone" id="vnpay_phone">
            <input type="hidden" name="address" id="vnpay_address">
            <!-- <input type="hidden" name="note" id="note"> -->
            <input type="hidden" name="price" id="vnpay_price" value="{{ number_format($totalPrice + $shippingCost) ?? 0 }}">
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
            <input type="hidden" name="price" id="momo_price" value="{{ number_format($totalPrice + $shippingCost) ?? 0}}">
        </form>


    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Lấy dữ liệu từ server thông qua data attributes
        let totalPrice = document.getElementById('total-price').getAttribute('data-price');
        let shippingCost = parseFloat($('#checkout-form').data('shipping-cost'));
        totalPrice = parseFloat(totalPrice);
        totalPrice = totalPrice + shippingCost;
        let selectedPaymentMethod = null;

        // Xử lý áp dụng mã giảm giá
        $('#discount-form').on('submit', function (event) {
            event.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function (response) {
                    let discountPercent = response.discount
                        ? Math.min(Math.max(response.discount, 1), 100)
                        : 0;

                    let discountAmount = (discountPercent / 100) * totalPrice;
                    let totalAfterDiscount = totalPrice - discountAmount;

                    $('#discount-percentage').text(discountPercent);
                    $('#total-remaining').text(totalAfterDiscount.toFixed(0) + " VND");
                    $('#message')
                        .text('Áp dụng mã thành công!')
                        .removeClass('alert-danger')
                        .addClass('alert alert-success')
                        .show();
                },
                error: function (xhr) {
                    $('#message')
                        .text('Mã giảm giá đã hết hạn hoặc không tồn tại!')
                        .removeClass('alert-success')
                        .addClass('alert alert-danger')
                        .show();
                    console.error(xhr.responseJSON?.message || "Lỗi không xác định.");
                }
            });
        });

        // Theo dõi lựa chọn phương thức thanh toán
        $('input[name="payment_method"]').on('change', function () {
            selectedPaymentMethod = $(this).val();
        });

        // Xử lý khi nhấn nút "Đặt hàng"
        $('#checkout-form').on('submit', function (event) {
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


@endsection
