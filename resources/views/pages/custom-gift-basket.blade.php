@extends('layouts.master')
@section('title', 'Tùy chọn giỏ quà')
@section('content')
<style>
    .product-item {
    display: flex; /* Hoặc bạn có thể cần điều chỉnh tùy thuộc vào cấu trúc HTML của bạn */
}
#search {
    width: 650px;
    display: flex;
    margin-left: 490px;
}
</style>


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
             {{--    <input type="text" id="search" placeholder="Tìm kiếm trái cây..." class="form-control mb-3"> --}}
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



<script>
  
    document.addEventListener("DOMContentLoaded", function() {
        const checkboxes = document.querySelectorAll('input[type="checkbox"]'); // Chọn tất cả các checkbox
        const totalPriceElement = document.getElementById("totalPrice"); // Lấy phần tử hiển thị tổng giá
        let totalPrice = 0; // Khởi tạo biến tổng giá

        // Hàm tính tổng giá
        function calculateTotal() {
        let totalPrice = 0; // Khởi tạo giá trị tổng là 0
        checkboxes.forEach(function (checkbox) {
            if (checkbox.checked) {
                const price = parseFloat(checkbox.dataset.price); // Lấy giá của sản phẩm từ thuộc tính data-price
                const quantity = checkbox.closest('.product-item').querySelector('select').value; // Lấy số lượng từ select
                const itemPrice = price * (parseInt(quantity) / 1000); // Tính giá dựa trên số lượng (kg)
                totalPrice += itemPrice; // Cộng vào tổng giá

                // Cập nhật giá hiển thị của sản phẩm
                const dynamicPriceElement = checkbox.closest('.product-item').querySelector('.dynamic-price');
                if (dynamicPriceElement) {
                    dynamicPriceElement.textContent = itemPrice.toLocaleString(); // Cập nhật giá động
                }
                
            }
        });
        totalPriceElement.textContent = totalPrice.toLocaleString(); // Cập nhật tổng giá vào DOM
    }

        // Lắng nghe sự kiện thay đổi checkbox hoặc select
        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', calculateTotal);
        });

        // Lắng nghe sự kiện thay đổi lượng trong select
        const selects = document.querySelectorAll('select');
        selects.forEach(function(select) {
            select.addEventListener('change', calculateTotal);
        });

        // Gọi hàm tính tổng khi tải trang
        calculateTotal();
    });

</script>


@endsection
