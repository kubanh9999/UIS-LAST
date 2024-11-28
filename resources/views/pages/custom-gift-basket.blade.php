@extends('layouts.master')
@section('title', 'Tùy chọn giỏ quà')
@section('content')
<style>
    .product-item {
    display: flex; /* Hoặc bạn có thể cần điều chỉnh tùy thuộc vào cấu trúc HTML của bạn */
}
</style>
    <main class="main-content">

        <section class="breadcrumb">
            <div class="container">
                <ul class="breadcrumb-list mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Trang chủ</a></li>
                    <li class="breadcrumb-separator">/</li>
                    <li class="breadcrumb-item"><a href="#">Shop</a></li>
                    <li class="breadcrumb-separator">/</li>
                    <li class="breadcrumb-item"><a href="#">{{ $basket->name }}</a></li>
                </ul>
            </div>
        </section>
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
        {{-- gift-basket class --}}
        <section class=" mb-4">

            <div class="container bg-white p-4">
                <input type="text" id="search" placeholder="Tìm kiếm trái cây..." class="form-control mb-3">
                <form id="giftBasketForm" action="{{ route('cart.addGiftBasketToCart', $basket->id) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="gift-basket-left col-md-5">
                            <div class="gift-basket-images">
                                <img src="{{ asset('layouts/img/' . $basket->image) }}" alt="{{ $basket->name }}">
                            </div>
                            <h4 class="gift-basket-name">{{ $basket->name }}</h4>
                            <div class="gift-basket-price">Tổng: <span id="totalPrice">0</span> VND</div>
                            <div class="acction-container mt-5">
                               
                                <a href="{{ route('home.index') }}" class="btn btn-danger mx-2">Quay lại giỏ quà</a>
                                <button type="submit" class="btn btn-primary mx-2">Thêm giỏ hàng</button>
                            </div>

                        </div>
                      
                        <div class="gift-basket-right col-md-7">
                            <h5>Chọn trái cây:</h5>
                          
                        
                            @foreach ($fruits as $fruit)
                            <div class="product-item d-flex align-items-center mb-3">
                                <input type="checkbox" name="fruits[{{ $fruit->id }}]" value="1"
                                    id="fruit_{{ $fruit->id }}" class="form-check-input"
                                    data-price="{{ $fruit->price }}">
                                <label for="fruit_{{ $fruit->id }}" class="form-label d-flex align-items-center">
                                    @php
                                        $imagePath = $fruit->image;
                                        // Nếu đường dẫn ảnh chứa 'uploads/posts', không cần thêm 'layouts/img'
                                        if (strpos($imagePath, 'uploads/products') === false) {
                                            $imagePath = 'layouts/img/' . $fruit->image; // Nếu không chứa, thêm 'layouts/img'
                                        }
                                    @endphp
                                    <img src="{{ asset($imagePath) }}" alt="{{ $fruit->name }}"
                                        style="max-width: 50px;" class="me-2">
                                        <span><strong>{{ $fruit->name }}</strong> - <span class="dynamic-price"
                                            data-price="{{ $fruit->price }}">
                                            {{ number_format($fruit->price, 0) }}
                                        </span> VND</span>
                                </label>
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

    </main>

    <script>
   document.getElementById("search").addEventListener("input", function () {
    const searchTerm = this.value; // Lấy từ khóa tìm kiếm

    fetch(`/search-fruits?query=${encodeURIComponent(searchTerm)}`)
        .then(response => response.json())
        .then(data => {
            const productContainer = document.querySelector(".gift-basket-right"); // Lấy container hiển thị sản phẩm
            productContainer.innerHTML = ""; // Xóa nội dung cũ

            // Duyệt qua danh sách kết quả và render HTML
            data.forEach(fruit => {
                productContainer.innerHTML += `
                    <div class="product-item d-flex align-items-center mb-3">
                        <input type="checkbox" name="fruits[${fruit.id}]" value="1" id="fruit_${fruit.id}" class="form-check-input" data-price="${fruit.price}">
                        <label for="fruit_${fruit.id}" class="form-label d-flex align-items-center">
                            <img src="${fruit.image}" alt="${fruit.name}" style="max-width: 50px;" class="me-2">
                            <span>
                                <strong>${fruit.name}</strong> - <span class="dynamic-price" data-price="${fruit.price}">${fruit.price_formatted}</span> VND
                            </span>
                        </label>
                        <select name="quantities[${fruit.id}]" class="ms-auto" style="width: 130px;">
                            <option value="100" selected>100g</option>
                            <option value="200">200g</option>
                            <option value="300">300g</option>
                            <option value="500">500g</option>
                        </select>
                    </div>
                `;
            });
        })
        .catch(error => console.error("Error:", error)); // Xử lý lỗi
});



        document.getElementById('giftBasketForm').addEventListener('submit', function(event) {
            // Lấy tất cả các checkbox trong form
            const checkboxes = document.querySelectorAll('input[name^="fruits"]:checked');

            // Kiểm tra nếu không có checkbox nào được chọn
            if (checkboxes.length === 0) {
                event.preventDefault(); // Ngăn không cho form submit
                Swal.fire({
    title: 'Chưa chọn trái cây!',
    text: 'Vui lòng chọn ít nhất một loại trái cây trước khi thêm vào giỏ hàng.',
    icon: 'warning',
    showClass: {
        popup: 'animate__animated animate__fadeInDown'
    },
    hideClass: {
        popup: 'animate__animated animate__fadeOutUp'
    }
});
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
    const fruitCheckboxes = document.querySelectorAll('input[name^="fruits"]');
    const quantitySelectors = document.querySelectorAll('select[name^="quantities"]');
    const totalPriceElement = document.getElementById('totalPrice');
    const dynamicPrices = document.querySelectorAll('.dynamic-price');

    function calculateTotalPrice() {
        let total = 0;

        fruitCheckboxes.forEach((checkbox, index) => {
            const quantitySelector = quantitySelectors[index];
            const dynamicPriceElement = dynamicPrices[index];

            if (checkbox.checked) {
                const fruitPricePerKg = parseInt(checkbox.getAttribute('data-price')); // Giá cho 1kg
                const quantityInGrams = parseInt(quantitySelector.value); // Trọng lượng tính bằng gram
                const priceForQuantity = (fruitPricePerKg / 1000) * quantityInGrams; // Giá tương ứng với số lượng

                // Cập nhật giá hiển thị trong dynamic-price
                dynamicPriceElement.textContent = priceForQuantity.toLocaleString('vi-VN');

                // Tính tổng tiền
                total += priceForQuantity;
            } else {
                // Reset giá về giá trị ban đầu khi bỏ chọn checkbox
                dynamicPriceElement.textContent = parseInt(checkbox.getAttribute('data-price')).toLocaleString('vi-VN');
            }
        });

        // Cập nhật tổng tiền
        totalPriceElement.textContent = total.toLocaleString('vi-VN');
    }

    // Lắng nghe sự kiện thay đổi trên checkbox và số lượng
    fruitCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', calculateTotalPrice);
    });

    quantitySelectors.forEach(selector => {
        selector.addEventListener('change', calculateTotalPrice);
    });

    // Tính tổng tiền khi trang tải lần đầu
    calculateTotalPrice();
});
    </script>

@endsection
