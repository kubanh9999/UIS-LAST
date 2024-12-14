@extends('layouts.master')
@section('title', 'Giỏ hàng')
@section('content')

    <style>
        .row {
            display: flex;
            flex-wrap: wrap;
            /* Để các sản phẩm tự động xuống hàng */
        }

        .product-card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .input-group {
            display: flex;
            align-items: center;
        }

        .input-group input {
            border: 1px solid#ffffff;
            border-radius: 4px 0 0 4px;
            /* Bo tròn góc cho bên trái */
            padding: 10px;
            /* Thêm khoảng cách bên trong */
        }

        .input-group .input-group-text {
            border: 1px solid #ffffff;
            border-left: none;
            /* Không có viền bên trái */
            border-radius: 0 4px 4px 0;
            /* Bo tròn góc cho bên phải */
            padding: 6px;
        }

        .delete-cart-item {
            color: red;
        }

        .continue .cart-not-item {
            font-size: small;
        }
    </style>

    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Giỏ hàng ({{ count(Session::get('cart', [])) }})</li>
            </ol>
        </nav>
    </div>

    <section class="section-cart">
        <div class="container">
            @if (empty($cart))
                <div class="swapper">
                    <p>Giỏ hàng trống vui lòng về 
                        <a href="{{ route('home.index') }}" style="font-weight: bold"> Trang chủ </a> mua hàng !
                    </p>
                </div>
            @else
                <form action="{{ route('checkout.process') }}" method="post">
                    @csrf
                    <div class="swapper">
                        <table class="inner-left">
                            <thead>
                                <tr class="cart-header ">
                                    <th scope="col">#</th>
                                    <th scope="col">Hình ảnh</th>
                                    <th scope="col">Tên sản phẩm</th>
                                    <th scope="col">Số lượng</th>
                                    <th scope="col">Giá</th>
                                    <th scope="col">Hành động</th>
                                </tr>
                            </thead>
                            <tbody id="cartItems">
                                @foreach ($cart as $key => $item)
                                    {{-- Hiển thị giỏ quà đặc biệt --}}
                                    @if (isset($item['fruits']) && is_array($item['fruits']))
                                        <tr class="cart-body">
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            @php
                                                $imagePath = $item['basket_image'];
                                                if (strpos($imagePath, 'uploads/products') === false) {
                                                    $imagePath = 'layouts/img/' . $item['basket_image']; // Nếu không chứa, thêm 'layouts/img'
                                                }
                                            @endphp
                                            <td  data-label="Hình ảnh"><img src="{{ asset($imagePath) }}" alt="Gift Basket"
                                                    style="width: 100px; height: auto; border-radius: 5px;"></td>
                                            <td data-label="Tên sản phẩm"> <strong>{{ $item['basket_name'] }}</strong></td>
                                            <td  data-label="Số lượng">
                                                <ul style="list-style: none; padding: 0;">
                                                    @foreach ($item['fruits'] as $fruit_id => $fruit_details)
                                                        @if (is_array($fruit_details))
                                                            @php
                                                                $imagePath = $fruit_details['image'];
                                                                // Nếu đường dẫn ảnh chứa 'uploads/posts', không cần thêm 'layouts/img'
                                                                if (strpos($imagePath, 'uploads/products') === false) {
                                                                    $imagePath =
                                                                        'layouts/img/' . $fruit_details['image']; // Nếu không chứa, thêm 'layouts/img'
                                                                }
                                                            @endphp
                                                            <li>
                                                                <img style="width: 40px; height: 40px;"
                                                                    src="{{ asset($imagePath) }}" alt="">
                                                                {{ $fruit_details['quantity'] }}Kg
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td  data-label="Giá"> <span>{{ number_format($item['total'] ?? 0) }} đ</span></td>
                                            <td  data-label="Hành động"> <a class="delete-cart-item" data-id="{{ $key }}"><i
                                                        class="fa-solid fa-trash"></i></a></td>
                                        </tr>
                                        {{-- Hiển thị giỏ quà thông thường --}}
                                    @elseif (isset($cart))
                                        <tr class="cart-body">
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td  data-label="Hình ảnh">
                                                @php
                                                    // Đường dẫn vật lý của file
                                                    $imagePath = public_path($item['image']);
                                                @endphp

                                                @if (file_exists($imagePath))
                                                    {{-- Nếu file tồn tại, hiển thị ảnh chính --}}
                                                    <img src="{{ asset($item['image']) }}" alt="Ảnh sản phẩm"
                                                        style="width: 100px; height: auto; border-radius: 5px;">
                                                @else
                                                    {{-- Nếu file không tồn tại, hiển thị ảnh dự phòng --}}
                                                    <img src="{{ asset('layouts/img/' . $item['image']) }}"
                                                        alt="Ảnh mặc định"
                                                        style="width: 100px; height: auto; border-radius: 5px;">
                                                @endif
                                            </td>

                                            <td  data-label="Tên sản phẩm"><strong>{{ $item['name'] }}</strong></td>
                                            <td  data-label="Số lượng"><input type="number" class="update-cart"
                                                    name="quantity[{{ $item['id'] }}]"
                                                    value="{{ $item['quantity'] ?? 1 }}" min="1"
                                                    data-id="{{ $item['id'] }}"></td>
                                            <td  data-label="Giá"><span>{{ number_format($item['price_gift'] ?? $item['price']) }}đ</span>
                                            </td>
                                            <td  data-label="Hành động"><a class="delete-cart-item" data-id="{{ $key }}"><i
                                                        class="fa-solid fa-trash"></i></a></td>
                                        </tr>
                                        {{-- Hiển thị sản phẩm thông thường --}}
                                    @elseif (!isset($item['fruits']) && !isset($item['basket_name']) && isset($item['name']))
                                        <tr class="cart-body">
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td  data-label="Hình ảnh"><img src="{{ asset('layouts/img/' . ($item['image'] ?? 'default.jpg')) }}"
                                                    alt="Product item"
                                                    style="width: 100px; height: auto; border-radius: 5px;">
                                            </td>
                                            <td  data-label="Tên sản phẩm">{{ $item['name'] ?? 'Sản phẩm không xác định' }}</td>
                                            <td  data-label="Số lượng">
                                                <div class="input-group">
                                                    <input type="number" name="quantity[{{ $key }}]"
                                                        data-id="{{ $key }}" class="update-cart"
                                                        value="{{ $item['quantity'] ?? 1 }}" min="0">
                                                    <span class="input-group-text">KG</span>
                                                </div>
                                            </td>
                                            <td  data-label="Giá"><span>{{ number_format($item['price'] ?? $item['price_gift']) }} đ</span>
                                            </td>
                                            <td  data-label="Hành động"><a class="delete-cart-item" data-id="{{ $key }}"><i
                                                        class="fa-solid fa-trash"></i></a></td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                        <div class="inner-right">
                            <div class="inner-total">
                                <h3 class="text-left mb-0">Tổng tiền</h3>
                                <span class="text-right">{{ number_format($total) }}đ</span>
                            </div>
                            <div class="checkout">
                                <button type="submit" >Tiến hành thanh toán</button>
                            </div>
                            <div class="continue">
                                <a href="{{ route('home.index') }}" class="btn btn-continue">Tiếp tục mua hàng</a>
                            </div>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </section>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Xóa sản phẩm khỏi giỏ hàng
            document.querySelectorAll('.delete-cart-item').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    Swal.fire({
                        title: 'Xóa sản phẩm?',
                        text: 'Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Có, xóa!',
                        cancelButtonText: 'Không'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/cart/delete/${id}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]').getAttribute(
                                            'content')
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        this.closest('tr').remove();
                                        document.getElementById('totalPrice')
                                            .textContent = data.totalPrice + 'VND';
                                        document.getElementById('cart-count')
                                            .textContent = data.cartItemCount || 0;
                                        location.reload();
                                    }
                                })
                                .catch(error => console.error('Lỗi:', error));
                        }
                    });
                });
            });

            // Cập nhật số lượng sản phẩm trong giỏ hàng
            document.querySelectorAll('.update-cart').forEach(input => {
                input.addEventListener('change', function() {
                    const id = this.getAttribute('data-id');
                    const quantity = parseInt(this.value, 10); // Chuyển đổi thành số nguyên

                    if (quantity < 0) {
                        alert('Số lượng không thể nhỏ hơn 0');
                        return;
                    }

                    // Nếu số lượng bằng 0, gọi hàm xóa sản phẩm
                    if (quantity === 0) {
                        deleteCartItem(id);
                    } else {
                        updateCartItem(id, quantity);
                        location.reload();
                    }
                });
            });

            // Xóa toàn bộ sản phẩm trong giỏ hàng
            document.getElementById('clearCart').addEventListener('click', () => {
                Swal.fire({
                    title: 'Xóa toàn bộ giỏ hàng?',
                    text: 'Bạn có chắc chắn muốn xóa toàn bộ giỏ hàng?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Có, xóa!',
                    cancelButtonText: 'Không'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch('/cart/clear', {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').getAttribute('content')
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    document.getElementById('cartItems').innerHTML = '';
                                    document.getElementById('totalPrice').textContent = 'VND';
                                    document.getElementById('cart-count').textContent = 0;
                                }
                            })
                            .catch(error => console.error('Lỗi:', error));
                    }
                });
            });

            // Hàm xóa sản phẩm khỏi giỏ hàng
            function deleteCartItem(id) {
                Swal.fire({
                    title: 'Xóa sản phẩm?',
                    text: 'Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Có, xóa!',
                    cancelButtonText: 'Không'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/cart/delete/${id}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content')
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    document.querySelector(`[data-id="${id}"]`).closest('tr').remove();
                                    document.getElementById('totalPrice').textContent = data
                                        .totalPrice + 'VND';
                                    document.getElementById('cart-count').textContent = data
                                        .cartItemCount || 0;
                                }
                            })
                            .catch(error => console.error('Lỗi:', error));
                    } else {
                        // Nếu người dùng không muốn xóa, đặt lại giá trị của input
                        document.querySelector(`input[data-id="${id}"]`).value = 1; // Giá trị mặc định
                    }
                });
            }

            // Hàm cập nhật sản phẩm trong giỏ hàng
            document.querySelectorAll('.update-cart').forEach(input => {
                input.addEventListener('input', (event) => {
                    const quantity = event.target.value; // Lấy giá trị số lượng mới
                    const id = event.target.dataset.id; // Lấy ID sản phẩm từ data-id

                    // Cập nhật giỏ hàng với số lượng mới
                    updateCartItem(id, quantity);
                });
            });

            // Hàm cập nhật giỏ hàng (cập nhật số lượng và tính lại tổng tiền)
            function updateCartItem(id, quantity) {
                fetch(`/cart/update/${id}`, {
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content'),
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            quantity: quantity
                        }) // Số lượng cần cập nhật
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const formattedTotalPrice = formatCurrency(data
                                .totalPrice); // Đảm bảo sử dụng đúng giá trị tổng tiền

                            // Cập nhật tổng tiền và số lượng sản phẩm trong giỏ
                            document.getElementById('totalPrice').textContent = formattedTotalPrice + ' VND';
                            document.getElementById('cart-count').textContent = data.cartItemCount || 0;
                        } else {
                            alert('Cập nhật giỏ hàng thất bại: ' + (data.message || 'Không xác định'));
                        }
                    })
                    .catch(error => console.error('Lỗi:', error));
            }
            // Hàm định dạng số tiền
            function formatCurrency(amount) {
                return amount.toLocaleString('vi-VN'); // Định dạng tiền tệ VND
            }
            // Hàm định dạng số tiền
            function formatCurrency(amount) {
                return amount.toLocaleString('vi-VN'); // Định dạng tiền tệ VND
            }
        });
        document.addEventListener('DOMContentLoaded', () => {
            const checkboxes = document.querySelectorAll('.product-checkbox');
            const giftContainer = document.querySelector('.gift');

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    // Nếu checkbox được chọn
                    if (this.checked) {
                        // Xóa các checkbox khác
                        checkboxes.forEach(otherCheckbox => {
                            if (otherCheckbox !== this) {
                                otherCheckbox.checked = false;
                            }
                        });

                        // Cập nhật nội dung của giftContainer
                        const productId = this.getAttribute('data-id');
                        const productName = this.getAttribute('data-name');
                        const productImg = this.getAttribute('data-img');

                        // Hiển thị sản phẩm đã chọn
                        giftContainer.innerHTML = `
                        <div class="selected-gift text-center">
                            <img src="${productImg}" alt="${productName}" class="img-fluid" style="width: 100px;">
                            <br>
                            <span>${productName}</span>
                        </div>
                    `;
                    } else {
                        // Nếu checkbox không được chọn, xóa nội dung giftContainer
                        giftContainer.innerHTML = '';
                    }
                });
            });
        });
    </script>
@endsection
