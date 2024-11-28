@extends('layouts.master')
@section('title', 'Trang chủ')
@section('content')

<style>
.recommended {
    display: flex; /* Sử dụng flexbox để sắp xếp sản phẩm theo hàng */
    overflow-x: auto; /* Cho phép cuộn ngang */
    padding: 10px 0; /* Thêm padding cho không gian */
    white-space: nowrap; /* Ngăn không cho văn bản xuống dòng */
    scroll-behavior: smooth; /* Thêm hiệu ứng cuộn mượt mà */
}

.product-card {
    display: inline-block; /* Hiển thị sản phẩm theo dạng khối */
    width: 200px; /* Đặt chiều rộng cho mỗi sản phẩm */
    margin-right: 10px; /* Thêm khoảng cách giữa các sản phẩm */
    flex-shrink: 0; /* Ngăn sản phẩm bị co lại */
}
.toast-error {
        background-color: #f44336 !important; /* Màu đỏ */
        color: white !important;
    }
    
    /* Đặt màu cho thông báo thành công */
    .toast-success {
        background-color: #4CAF50 !important; /* Màu xanh */
        color: white !important;
    }

    /* Tùy chỉnh thêm cho kích thước và kiểu chữ của thông báo */
    .toast {
        font-size: 16px;
        border-radius: 8px;
    }

</style>
@if (session('success'))
    <script>
        toastr.success('{{ session('success') }}');  // Hiển thị thông báo thành công
    </script>
@endif

@if (session('error'))
    <script>
        toastr.error('{{ session('error') }}');  // Hiển thị thông báo lỗi nếu có
    </script>
@endif
    <section class="category-carousel mb-4">
        <div class="container p-0">
            <div class="d-flex justify-content-between gap-4">
                <!-- Categories Section -->
                <div class="category-swaper d-md-block d-none">
                    <div class="category-menu">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            style="fill: rgb(255, 255, 255); margin: 0px 5px;">
                            <path d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"></path>
                        </svg>
                        <span>Danh mục</span>
                    </div>
                    <ul class="category-list list-unstyled mb-0">
                        <!-- Tất cả sản phẩm -->
                        <li class="category-item">
                            <a href="{{ route('products.byCategory', ['category' => 'all']) }}">Tất cả sản phẩm</a>
                        </li>
                    
                        <!-- Danh sách các danh mục -->
                        @foreach ($categories as $category)
                            <li class="category-item">
                                <a href="{{ route('products.byCategory', ['category' => $category->id]) }}">{{ $category->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <!-- Carousel -->
                <div class="carousel-slider p-0">
                    <div id="categoryCarousel" class="carousel slide" data-bs-ride="carousel">
                        <!-- Indicators -->
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#categoryCarousel" data-bs-slide-to="0"
                                class="active"></button>
                            <button type="button" data-bs-target="#categoryCarousel" data-bs-slide-to="1"></button>
                        </div>

                        <!-- Slides -->
                        <div class="carousel-inner">
                            @foreach($mainBanners as $index => $banner)
                                <a href="{{ $banner->link }}" rel="noopener noreferrer">
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                        <img src="{{ asset($banner->image_path) }}" alt="{{ $banner->alt_text }}" width="100">
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        

                        <!-- Controls -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#categoryCarousel"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#categoryCarousel"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>
                    <div class="services">
                        <div class="service-item">
                            <div class="service-content">
                                <h2 class="service-title">Hỗ trợ 24/7</h2>
                                <span class="service-text">Liên hệ chúng tôi 24h</span>
                            </div>
                            <div class="service-icon">
                                <img src="{{ asset('layouts/img/service_1.svg') }}" alt="Service 1">
                            </div>
                        </div>
                        <div class="service-item">
                            <div class="service-content">
                                <h2 class="service-title">Thanh toán</h2>
                                <span class="service-text">Bảo mật thanh toán</span>
                            </div>
                            <div class="service-icon">
                                <img src="{{ asset('layouts/img/service_1.svg') }}" alt="Service 2">
                            </div>
                        </div>
                        <div class="service-item">
                            <div class="service-content">
                                <h2 class="service-title">Giao hàng</h2>
                                <span class="service-text">Giao hàng tận nơi</span>
                            </div>
                            <div class="service-icon">
                                <img src="{{ asset('layouts/img/service_1.svg') }}" alt="Service 3">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <div id="overlay" style="display: none;"></div>
        <div id="welcome-banner" style="display: none;">
        <img src="https://thuyanhfruits.com/wp-content/uploads/2021/03/z2380330537317_f546ae4d0b63d3153b9269e1dc860f58-scaled.jpg" alt="Welcome Banner" id="banner-image" />
        <button id="close-banner" class="btn-close" aria-label="Close"></button>
    </div>

    
    <section class="gift-basket-selection mb-4" >

    <div class="container p-3 p-md-4 bg-white">
    <h2 class="section-title"> Giỏ Quà</h2>
    <div class="product-grid">
        @foreach ($giftBaskets as $basket)
            <div class="product-card">
                <a href="{{ route('product.giftDetail', $basket->id) }}">
                    <img src="{{ asset('layouts/img/' . $basket->image) }}" alt="{{ $basket->name }}">
                </a>
                <h5>
                    <a href="{{ route('product.giftDetail', $basket->id) }}">{{ $basket->name }}</a>
                  
                </h5>
                <div class="price">
                    {{ number_format($basket->price_gift) }} VND
                </div>
                <div class="add-to-cart">
                    <i class="fa-solid fa-basket-shopping"></i>
                    <form action="{{ route('cart.add', ['id' => $basket->id]) }}" method="post" style="display: inline;">
                        @csrf
                        <input type="hidden" name="product[id]" value="{{ $basket->id }}">
                        <input type="hidden" name="product[name]" value="{{ $basket->name }}">
                        <input type="hidden" name="product[image]" value="{{ $basket->image }}">
                        <input type="hidden" name="product[price_gift]" value="{{ $basket->price_gift }}">
                        <input type="hidden" name="quantity" value="1">
                        <a href="#" onclick="this.closest('form').submit();" class="cart-text" style="display: inline-flex; align-items: center;">
                            <span style="margin-left: 5px;">Thêm giỏ hàng</span>
                        </a>
                    </form>
                </div>       
                    
            </div>
        @endforeach
    </div>
</div>

    </section>
    @if (Auth::check())
    <!-- <section class="recommended-products mb-4">
        <div class="bg-white container position-relative p-3 p-md-4">
            <h2 class="section-title mb-3">Chỉ dành cho bạn</h2>

            <div class="recommended product-grid" id="recommendedProducts">
                @if($recommendedProducts->isNotEmpty())
                    @foreach ($recommendedProducts as $item)
                        <div class="product-card">
                            <div class="new-badge">New</div>
                            <a href="{{ route('product.detail', $item->id) }}">
                                <img src="{{ $item->image }}" alt="{{ $item->name }}">
                            </a>
                            <h5>{{ $item->name }}</h5>
                            <div class="price">
                                {{ number_format($item->discount, 2) }}<span class="old-price">{{ number_format($item->price, 2) }}</span>
                            </div>
                            <div class="add-to-cart">
                                <i class="fa-solid fa-basket-shopping"></i>
                                <form action="{{ route('cart.add', ['id' => $item->id]) }}" method="post" style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="product[id]" value="{{ $item->id }}">
                                    <input type="hidden" name="product[name]" value="{{ $item->name }}">
                                    <input type="hidden" name="product[image]" value="{{ $item->image }}">
                                    <input type="hidden" name="product[price]" value="{{ $item->price }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <a href="#" onclick="this.closest('form').submit();" class="cart-text" style="display: inline-flex; align-items: center;">
                                        <span style="margin-left: 5px;">Thêm giỏ hàng</span>
                                    </a>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p>Hiện không có sản phẩm nào được đề xuất.</p>
                @endif
            </div>
        </div>
    </section> -->
@endif





<section class="best-sellers mb-4">
    <div class="products-news container p-3 p-md-4 bg-white">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="section-title">Sản phẩm bán chạy</h2>
            <ul class="category-title mb-0">
                @if ($topProductsGrouped->isNotEmpty())
                @foreach ($topProductsGrouped as $categoryName => $products)
                    <li>
                        <a href="javascript:void(0);" class="category-link" data-category="{{ $categoryName }}" data-target="best-sellers">{{ $categoryName }}</a>
                    </li>
                @endforeach
                @else
                <li><a href="">Chưa có danh mục</a></li>
                @endif
            </ul>
            <div class="category-title-mb">
                <i class="fa-solid fa-bars"></i>
            </div>
        </div>

        <div class="product-grid" id="best-sellers">
            @foreach ($topProducts as $item)
            <div class="product-card">
                <a href="{{ route('product.detail', $item->id) }}">
                    <img src="{{ asset('layouts/img/' . $item->image) }}" alt="{{ $item->name }}">
                </a>
                <h5 class="product-name">
                    <a href="{{ route('product.detail', $item->id) }}">{{ $item->name }}</a>
                </h5>
                <div class="price">
                    {{ number_format($item->price, 0) }} VND
                </div>
                <div class="add-to-cart">
                    <i class="fa-solid fa-basket-shopping"></i>
                    <form action="{{ route('cart.add', ['id' => $item->id]) }}" method="post" style="display: inline;">
                        @csrf
                        <input type="hidden" name="product[id]" value="{{ $item->id }}">
                        <input type="hidden" name="product[name]" value="{{ $item->name }}">
                        <input type="hidden" name="product[image]" value="{{ $item->image }}">
                        <input type="hidden" name="product[price]" value="{{ $item->price }}">
                        <input type="hidden" name="quantity" value="1">
                        <a href="#" onclick="this.closest('form').submit();" class="cart-text" style="display: inline-flex; align-items: center;">
                            <span style="margin-left: 5px;">Thêm giỏ hàng</span>
                        </a>
                    </form>
                </div>
            </div>
            @endforeach
        </div>

        <div class="view-all">
            <a class="btn" href="/product">Xem tất cả <i class="fa-solid fa-chevron-right"></i></a>
        </div>
    </div>
</section>
    

    <section class="banner-section-1 mb-4">
        <div class="box container p-0 flashing-banner" style="position: relative;">
            @if($secondaryBanners && $secondaryBanners->isNotEmpty())
                <!-- Liên kết từ cơ sở dữ liệu -->
                <a href="{{ $secondaryBanners->first()->link }}" style="display: block;">
                    <img src="{{ asset($secondaryBanners->first()->image_path) }}" alt="{{ $secondaryBanners->first()->alt_text }}" style="width: 100%; height: auto;">
                </a>
                <!-- Nút xem ngay -->
                
            @endif
        </div>
    </section>
    

    <section class="new-arrivals mb-4">
        <div class="products-news container p-3 p-md-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="section-title">Sản phẩm mới</h2>
                <ul class="category-title mb-0">
                    @if ($newProductsGrouped->isNotEmpty())
                    @foreach ($newProductsGrouped as $categoryName => $products)
                        <li>
                            <a href="javascript:void(0);" class="category-link" data-category="{{ $categoryName }}" data-target="new-arrivals">{{ $categoryName }}</a>
                        </li>
                    @endforeach
                    @else
                    <li><a href="">Chưa có danh mục</a></li>
                    @endif
                </ul>
                <div class="category-title-mb">
                    <i class="fa-solid fa-bars"></i>
                </div>
            </div>
    
            <div class="product-grid" id="new-arrivals">
                @foreach ($newProducts as $item)
                <div class="product-card">
                    <div class="new-badge">New</div>
                    <a href="{{ route('product.detail', $item->id) }}">
                        <img src="{{ asset('layouts/img/' . $item->image) }}" alt="{{ $item->name }}">
                    </a>
                    <h5 class="product-name">
                        <a href="{{ route('product.detail', $item->id) }}">{{ $item->name }}</a>
                    </h5>
                    <div class="price">
                        {{ number_format($item->price, 0) }} VND
                    </div>
                    <div class="add-to-cart">
                        <i class="fa-solid fa-basket-shopping"></i>
                        <form action="{{ route('cart.add', ['id' => $item->id]) }}" method="post" style="display: inline;">
                            @csrf
                            <input type="hidden" name="product[id]" value="{{ $item->id }}">
                            <input type="hidden" name="product[name]" value="{{ $item->name }}">
                            <input type="hidden" name="product[image]" value="{{ $item->image }}">
                            <input type="hidden" name="product[price]" value="{{ $item->price }}">
                            <input type="hidden" name="quantity" value="1">
                            <a href="#" onclick="this.closest('form').submit();" class="cart-text" style="display: inline-flex; align-items: center;">
                                <span style="margin-left: 5px;">Thêm giỏ hàng</span>
                            </a>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
    
            <div class="view-all">
                <a class="btn" href="/product">Xem tất cả <i class="fa-solid fa-chevron-right"></i></a>
            </div>
        </div>
    </section>
    

    <section class="banner-section-2 mb-4">
        <div class="container p-0">
            <div class="row">
                @if($tertiaryBanner && $tertiaryBanner->isNotEmpty())
                    @foreach($tertiaryBanner as $index => $banner)
                        @if($index == 0)
                            <div class="col-md-3 d-md-block d-none">
                                <a href="{{ $banner->link ?? '#' }}" target="_self">
                                    <img src="{{ asset($banner->image_path) }}" alt="{{ $banner->alt_text }}" class="banner-image">
                                </a>
                            </div>
                        @elseif($index == 1)
                            <div class="col-md-6 d-block">
                                <a href="{{ $banner->link ?? '#' }}" target="_self">
                                    <img src="{{ asset($banner->image_path) }}" alt="{{ $banner->alt_text }}" class="banner-image">
                                </a>
                            </div>
                        @elseif($index == 2)
                            <div class="col-md-3 d-md-block d-none">
                                <a href="{{ $banner->link ?? '#' }}" target="_self">
                                    <img src="{{ asset($banner->image_path) }}" alt="{{ $banner->alt_text }}" class="banner-image">
                                </a>
                            </div>
                        @endif
                    @endforeach
                @else
                    <p>No banners found.</p> <!-- Display message if no banners are available -->
                @endif
            </div>
        </div>
    </section>
    

    <section class="latest-news">
        <div class="container p-3 p-md-4 bg-white">
            <div class="news-header">
                <h2 class="section-title">Tin tức mới nhất</h2>
                <a class="btn" href="#">Xem tất cả <i class="fa-solid fa-chevron-right"></i></a>
            </div>
            <div class="row py-3">
                <!-- Featured News -->
                <div class="col-md-5" style="text-decoration: none;">
                    <div class="featured-news"  >
                        <div class="news-image w-100">
                            <a href="{{route('post.show', ['id' => $latestPost->id])}}">
                                 <img src="{{ asset('layouts/img/' . $latestPost->image) }}">
                            </a>
                        </div>
                        <div class="news-details" style="  text-decoration: none;">
                            <div style="width: 550px; max-width: 100%;  padding: 10px;">
                                <a href="{{route('post.show', ['id' => $latestPost->id])}}" class="bold">
                                <h3 class="news-title">{{ $latestPost->title }}</h3>
                                </a>
                            </div>
                            <div>
                                <p class="news-summary">
                                    <a href="{{ route('post.show', ['id' => $latestPost->id]) }}" style="color: black; text-decoration: none; font-size: 15px;">
                                        @php
                                       
                                        
                                        $clearBreakLineArrStr = Str::replace('&nbsp;',"", $latestPost->content);
                                        
                                        $clearImgArrStr = preg_replace("<img([\w\W]+?)/>", "", $clearBreakLineArrStr);
 
                                        @endphp
                                        @foreach (explode("\n",
                                               $clearImgArrStr
                                            ) as $key => $item)
                                            {!! $item !!}
                                            @if ($key === 3)
                                                @break
                                            @endif
                                        @endforeach
                                        
                                    </a>
                                </p>
                            </div>
                           
                        </div>
                    </div>
                </div>

                <!-- Additional News -->
                <div class="col-md-7">
                    <div class="additional-news">
                 @foreach($nextPosts  as $post)
    <!-- News Item -->
    <div class="news-item">
        <div class="news-image">
            <a href="{{route('post.show', ['id' => $post->id])}}">
                <img src="{{ asset('layouts/img/' . $post->image) }}"
                    alt="">
            </a>
        </div>
        <div class="news-details" style="  text-decoration: none;">
            <div style="width: 550px; max-width: 100%;  padding: 10px;">
                <a href="{{route('post.show', ['id' => $post->id])}}" class="bold">
                <h3 class="news-title">{{ $post->title }}</h3>
                </a>
            </div>
           
            <div style="width: 550px; max-width: 100%; padding: 10px; color: black;">
            <p class="news-summary" >
                    <a href="{{ route('post.show', ['id' => $post->id]) }}" style="color: black; text-decoration: none; font-size:15px" >
                        @php
                                       
                                        
                        $clearBreakLineArrStr = Str::replace('&nbsp;',"", $post->content);
                        
                        $clearImgArrStr = preg_replace("<img([\w\W]+?)/>", "", $clearBreakLineArrStr);

                        @endphp
                        @foreach (explode("\n",
                               $clearImgArrStr
                            ) as $key => $item)
                            {!! $item !!}
                            @if ($key === 1)
                                @break
                            @endif
                        @endforeach
                        
                    </a>
                </p>
            </div>
        </div>
    </div>
@endforeach
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
   $(document).on('click', '.category-link', function() {
    var categoryName = $(this).data('category'); // Lấy tên danh mục từ data attribute
    var targetSection = $(this).data('target'); // Lấy phần cần cập nhật (best-sellers hoặc new-arrivals)
    var currentUrl = window.location.href.split('?')[0]; // URL hiện tại không có query string

    // Gửi yêu cầu AJAX tới server
    $.ajax({
        url: '{{ route("products.category.name", ":categoryName") }}'.replace(':categoryName', categoryName),
        type: 'GET',
        success: function(response) {
            console.log('categories: ', categoryName);

            // Tạo danh sách sản phẩm mới
            var html = '';
            $.each(response, function(index, product) {
                html += `
                    <div class="product-card">
                        <div class="new-badge">New</div>
                        <a href="/product/${product.id}">
                            <img src="/layouts/img/${product.image}" alt="${product.name}">
                        </a>
                        <h5 class="product-name">
                            <a href="/product/${product.id}">${product.name}</a>
                        </h5>
                        <div class="price">
                            ${new Intl.NumberFormat('vi-VN').format(product.price)} VND
                        </div>
                        <div class="add-to-cart">
                            <i class="fa-solid fa-basket-shopping"></i>
                            <form action="/cart/add/${product.id}" method="post" style="display: inline;">
                                <input type="hidden" name="product[id]" value="${product.id}">
                                <input type="hidden" name="product[name]" value="${product.name}">
                                <input type="hidden" name="product[image]" value="${product.image}">
                                <input type="hidden" name="product[price]" value="${product.price}">
                                <input type="hidden" name="quantity" value="1">
                                <a href="#" onclick="this.closest('form').submit();" class="cart-text" style="display: inline-flex; align-items: center;">
                                    <span style="margin-left: 5px;">Thêm giỏ hàng</span>
                                </a>
                            </form>
                        </div>
                    </div>
                `;
            });

            // Hiển thị danh sách sản phẩm mới cho đúng phần
            $("#" + targetSection).html(html);
        },
        error: function() {
            alert('Đã có lỗi xảy ra khi tải danh mục sản phẩm.');
        }
    });
});

</script>
<style>

    .ellipsis-text {
        display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 3; /* Số dòng tối đa */
    overflow: hidden;
    text-overflow: ellipsis;
    word-wrap: break-word;
}
.bold{
    color: black; /* Đổi màu chữ thành màu đen */
    font-weight: bold; /* In đậm */
    text-decoration: none; /* Bỏ gạch chân */

}
</style>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
