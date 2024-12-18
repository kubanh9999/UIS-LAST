@extends('layouts.master')
@section('title', 'Tùy chọn giỏ quà')
@section('content')
<style>
  #search {
   border: 1px solid #74c26e;
   border-radius: 100px;
} 



/* #search:focus {
    outline: none; 
    border-color: #5fa457;
    box-shadow: 0 0 10px rgba(116, 194, 110, 0.5); 
} */

/* #search::placeholder {
    color: #a8d5b0; 
    font-style: italic;
} */

.mb-3 {
    margin-bottom: 1rem; 
}
</style>
    @if (session('error'))
        <script>
            toastr.error('{{ session('error') }}');
        </script>
    @endif

    @if (session('success'))
        <script>
            toastr.success('{{ session('success') }}');
        </script>
    @endif

    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Sản phẩm</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $basket->name }}</li>
            </ol>
        </nav>
    </div>

    <section class="section-custom-gift-basket ">
        <div class="container">
            <input type="text" id="search" placeholder="Tìm kiếm trái cây..." class="form-control mb-3">
            <form id="giftBasketForm" action="{{ route('cart.addGiftBasketToCart', $basket->id) }}" method="POST">
                @csrf
                
                <div class="swapper">
                    
                    <div class="inner-left">
                        
                        <div class="inner-head">
                            @php
                                $imagePath = $basket->image;
                                if (strpos($imagePath, 'uploads/products') === false) {
                                    $imagePath = 'layouts/img/' . $basket->image; // Nếu không chứa, thêm 'layouts/img'
                                }
                            @endphp
                            <img src="{{ asset($imagePath) }}" alt="{{ $basket->name }}">
                        </div>
                        <div class="inner-body">
                            <h3>{{ $basket->name }}</h3>
                            <div class="gift-basket-price">
                                <p class="mb-0">Tổng: <span id="totalPrice">0</span>đ</p>
                            </div>
                        </div>
                        <div class="inner-foot">
                            <a href="{{ route('home.index') }}" class="btn-comback">Quay lại giỏ quà</a>
                            <button type="submit" class="btn-giftcart">Thêm giỏ hàng</button>
                        </div>
                    </div>
                    <div class="inner-right gift-basket-right">
                        <h3 class="inner-title">Chọn sản phẩm:</h3>
                        @foreach ($fruits as $fruit)
                            <div class="product-item inner-product">
                                <input type="checkbox" name="fruits[{{ $fruit->id }}]" value="1"
                                    id="fruit_{{ $fruit->id }}" class="form-check-input"
                                    data-price="{{ $fruit->price }}">
                                <label for="fruit_{{ $fruit->id }}" class="d-flex align-items-center">
                                    @php
                                        $imagePath = $fruit->image;
                                        // Nếu đường dẫn ảnh chứa 'uploads/posts', không cần thêm 'layouts/img'
                                        if (strpos($imagePath, 'uploads/products') === false) {
                                            $imagePath = 'layouts/img/' . $fruit->image; // Nếu không chứa, thêm 'layouts/img'
                                        }
                                    @endphp
                                    <img src="{{ asset($imagePath) }}" alt="{{ $fruit->name }}" style="max-width: 50px;"
                                        class="me-2">
                                    <span><strong>{{ $fruit->name }}</strong></span>
                                </label>
                                <div class="d-flex align-items-center">
                                    <p class="dynamic-price mb-0" data-price="{{ $fruit->price }}">
                                        {{ number_format($fruit->price, 0) }}
                                    </p>đ
                                </div>
                                
                                <select name="quantities[{{ $fruit->id }}]" class="ms-auto" style="width: 130px;">
                                    <option value="100" selected>100g</option>
                                    <option value="200">200g</option>
                                    <option value="300">300g</option>
                                    <option value="400">400g</option>
                                    <option value="500">500g</option>
                                    <option value="1000">1kg</option>
                                </select>
                            </div>
                        @endforeach
                    </div>
                </div>

            </form>
        </div>
    </section>
    {{-- gift-basket class --}}

    <script>
        document.getElementById("search").addEventListener("input", function () {
            const searchTerm = this.value.toLowerCase(); // Lấy từ khóa tìm kiếm và chuyển thành chữ thường
    
            // Lấy tất cả các sản phẩm
            const productContainer = document.querySelector(".gift-basket-right");
            const products = Array.from(productContainer.querySelectorAll(".product-item"));
    
            // Lưu lại các ID của các trái cây đã được chọn trước khi tìm kiếm
            let checkedFruits = [];
            const checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
            checkboxes.forEach(checkbox => {
                checkedFruits.push(checkbox.id); // Lưu ID của checkbox đã chọn
            });
    
            // Sắp xếp lại các sản phẩm
            const filteredProducts = products.filter(product => {
                const label = product.querySelector('label');
                const fruitName = label ? label.textContent.toLowerCase() : '';
                return fruitName.includes(searchTerm); // Kiểm tra nếu tên sản phẩm có chứa từ khóa tìm kiếm
            });
    
            // Các sản phẩm không khớp tìm kiếm
            const nonFilteredProducts = products.filter(product => {
                const label = product.querySelector('label');
                const fruitName = label ? label.textContent.toLowerCase() : '';
                return !fruitName.includes(searchTerm);
            });
    
            // Di chuyển các sản phẩm tìm thấy lên đầu
            productContainer.innerHTML = ''; // Xóa nội dung hiện tại
    
            filteredProducts.forEach(product => productContainer.appendChild(product)); // Thêm sản phẩm tìm thấy lên đầu
            nonFilteredProducts.forEach(product => productContainer.appendChild(product)); // Thêm các sản phẩm không khớp vào sau
    
            // Cập nhật lại trạng thái checkbox
            filteredProducts.forEach(product => {
                const checkbox = product.querySelector('input[type="checkbox"]');
                if (checkedFruits.includes(checkbox.id)) {
                    checkbox.checked = true; // Đánh dấu lại checkbox đã được chọn trước đó
                }
            });
    
            // Gọi lại hàm tính tổng giá sau khi tìm kiếm
            calculateTotal();
        });
    
        document.addEventListener("DOMContentLoaded", function () {
    const checkboxes = document.querySelectorAll('input[type="checkbox"]'); // Lấy tất cả checkbox
    const totalPriceElement = document.getElementById("totalPrice"); // Tổng giá tiền
    let totalWeight = 0; // Tổng khối lượng

    // Hàm tính tổng giá và kiểm tra khối lượng
    function calculateTotal() {
        let totalPrice = 0; // Tổng tiền
        totalWeight = 0; // Reset tổng khối lượng

        checkboxes.forEach(function (checkbox) {
            if (checkbox.checked) {
                const price = parseFloat(checkbox.dataset.price); // Giá sản phẩm
                const quantity = parseInt(checkbox.closest('.product-item').querySelector('select').value); // Lượng đã chọn
                totalWeight += quantity; // Cộng dồn khối lượng

                // Tính giá dựa trên lượng (kg)
                const itemPrice = price * (quantity / 1000);
                totalPrice += itemPrice;

                // Cập nhật giá động cho từng sản phẩm
                const dynamicPriceElement = checkbox.closest('.product-item').querySelector('.dynamic-price');
                if (dynamicPriceElement) {
                    dynamicPriceElement.textContent = itemPrice.toLocaleString();
                }
            }
        });

        // Kiểm tra giới hạn khối lượng (3kg)
        if (totalWeight > 3000) {
            Swal.fire({
    icon: 'error',
    title: 'Lỗi',
    text: 'Bạn không thể chọn quá 3kg tổng cộng!',
    timer: 3000, // Đóng sau 3 giây
    showConfirmButton: false // Không hiển thị nút
});
            return false; // Dừng tính toán
        }

        // Cập nhật tổng giá trị hiển thị
        totalPriceElement.textContent = totalPrice.toLocaleString();
        return true;
    }

    // Sự kiện cho checkbox
    checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            if (!calculateTotal()) {
                checkbox.checked = false; // Bỏ chọn nếu vượt quá 3kg
            }
        });
    });

    // Sự kiện cho select số lượng
    const selects = document.querySelectorAll('select');
    selects.forEach(function (select) {
        select.addEventListener('change', function () {
            const checkbox = select.closest('.product-item').querySelector('input[type="checkbox"]');
            if (checkbox.checked && !calculateTotal()) {
                select.value = "100"; // Reset về giá trị mặc định nếu quá 3kg
                calculateTotal();
            }
        });
    });

    // Gọi hàm tính toán khi tải trang
    calculateTotal();
});

document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form"); // Lấy form
    const checkboxes = document.querySelectorAll('input[type="checkbox"]'); // Lấy tất cả checkbox
    const addToCartButton = document.querySelector(".btn-giftcart"); // Nút Thêm giỏ hàng

    // Sự kiện khi nhấn nút Thêm giỏ hàng
    addToCartButton.addEventListener("click", function (event) {
        const checkedCheckboxes = Array.from(checkboxes).filter(checkbox => checkbox.checked);

        if (checkedCheckboxes.length === 0) {
            Swal.fire({
    icon: 'error',
    title: 'Lỗi',
    text: 'Vui lòng chọn ít nhất một sản phẩm trước khi thêm vào giỏ hàng.',
    timer: 3000, // Đóng sau 3 giây
    showConfirmButton: false // Không hiển thị nút
});
            
            event.preventDefault(); // Ngăn không cho gửi form
        }
    });
});
    </script>
    
    
    @endsection
    