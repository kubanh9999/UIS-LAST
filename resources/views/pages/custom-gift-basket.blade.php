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
                                @php
                                    $imagePath = $basket->image;
                                    if (strpos($imagePath, 'uploads/products') === false) {
                                        $imagePath = 'layouts/img/' . $basket->image; // Nếu không chứa, thêm 'layouts/img'
                                    }
                                @endphp
                                <img src="{{ asset($imagePath) }}" alt="{{ $basket->name }}">
                            </div>
                            <h4 class="gift-basket-name">{{ $basket->name }}</h4>
                            <div class="gift-basket-price">Tổng: <span id="totalPrice">0</span> VND</div>
                            <div class="acction-container mt-5">
                               
                                <a href="{{ route('home.index') }}" class="btn btn-danger mx-2">Quay lại giỏ quà</a>
                                <button type="submit" class="btn btn-success mx-2">Thêm giỏ hàng</button>
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

    // Lưu trạng thái vào LocalStorage trước khi tìm kiếm
    saveStateToLocalStorage();

    // Gửi yêu cầu tìm kiếm tới server
    fetch(`/search-fruits?query=${encodeURIComponent(searchTerm)}`)
        .then(response => response.json())
        .then(data => {
            const productContainer = document.querySelector(".gift-basket-right");
            productContainer.innerHTML = ""; // Xóa nội dung cũ

            // Duyệt qua danh sách sản phẩm trả về
            data.forEach(fruit => {
                productContainer.innerHTML += `
                    <div class="product-item d-flex align-items-center mb-3">
                        <input type="checkbox" name="fruits[${fruit.id}]" value="1"
                            id="fruit_${fruit.id}" class="form-check-input"
                            data-price="${fruit.price}">
                        <label for="fruit_${fruit.id}" class="form-label d-flex align-items-center">
                            <img src="${fruit.image}" alt="${fruit.name}" style="max-width: 50px;" class="me-2">
                            <span><strong>${fruit.name}</strong> - <span class="dynamic-price"
                                data-id="fruit_${fruit.id}" data-price="${fruit.price}">
                                ${fruit.price_formatted}
                            </span></span>
                        </label>
                        <select name="quantities[${fruit.id}]" class="ms-auto" style="width: 130px;">
                            <option value="100" selected>100g</option>
                            <option value="200">200g</option>
                            <option value="300">300g</option>
                            <option value="400">400g</option>
                            <option value="500">500g</option>
                            <option value="1000">1kg</option>
                        </select>
                    </div>
                `;
            });

            // Khôi phục trạng thái từ LocalStorage
            restoreStateFromLocalStorage();

            // Gắn lại sự kiện cho checkbox và selector mới
            attachEventHandlers();
        })
        .catch(error => console.error("Error:", error)); // Xử lý lỗi
});

function attachEventHandlers() {
    const fruitCheckboxes = document.querySelectorAll('input[name^="fruits"]');
    const quantitySelectors = document.querySelectorAll('select[name^="quantities"]');
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
        document.getElementById('totalPrice').textContent = total.toLocaleString('vi-VN');
    }

    fruitCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            saveStateToLocalStorage(); // Lưu trạng thái vào LocalStorage khi thay đổi
            calculateTotalPrice();
        });
    });

    quantitySelectors.forEach(selector => {
        selector.addEventListener('change', () => {
            saveStateToLocalStorage(); // Lưu trạng thái khi thay đổi trọng lượng
            calculateTotalPrice();
        });
    });

    // Tính lại tổng khi DOM cập nhật
    calculateTotalPrice();
}

// Hàm lưu toàn bộ trạng thái vào LocalStorage
function saveStateToLocalStorage() {
    const state = [];
    document.querySelectorAll('.product-item').forEach(item => {
        const checkbox = item.querySelector('input[name^="fruits"]');
        const quantitySelector = item.querySelector('select[name^="quantities"]');
        const dynamicPriceElement = item.querySelector('.dynamic-price');
        const imgElement = item.querySelector('img');

        if (checkbox) {
            state.push({
                id: checkbox.id,
                checked: checkbox.checked,
                price: dynamicPriceElement.textContent, // Giá hiển thị hiện tại
                quantity: quantitySelector.value, // Trọng lượng (gram)
                image: imgElement.src // URL ảnh sản phẩm
            });
        }
    });

    localStorage.setItem('productState', JSON.stringify(state));
}

// Hàm khôi phục trạng thái từ LocalStorage
function restoreStateFromLocalStorage() {
    const state = JSON.parse(localStorage.getItem('productState')) || [];
    state.forEach(savedItem => {
        const checkbox = document.getElementById(savedItem.id);
        const quantitySelector = document.querySelector(`select[name="quantities[${savedItem.id.split('_')[1]}]"]`);
        const dynamicPriceElement = document.querySelector(`.dynamic-price[data-id="${savedItem.id}"]`);
        const imgElement = checkbox?.closest('.product-item')?.querySelector('img');

        if (checkbox) {
            checkbox.checked = savedItem.checked; // Khôi phục trạng thái checkbox
        }
        if (quantitySelector) {
            quantitySelector.value = savedItem.quantity; // Khôi phục trọng lượng
        }
        if (dynamicPriceElement) {
            dynamicPriceElement.textContent = savedItem.price; // Khôi phục giá
        }
        if (imgElement) {
            imgElement.src = savedItem.image; // Khôi phục ảnh
        }
    });
}

// Gắn sự kiện lần đầu
document.addEventListener("DOMContentLoaded", function () {
    restoreStateFromLocalStorage(); // Khôi phục trạng thái khi tải trang
    attachEventHandlers();
});


    </script>

@endsection
