@extends('layouts.master')
@section('title', 'Trang chủ')
@section('content')

    @if (session('success'))
        <script>
            toastr.success('{{ session('success') }}');
        </script>
    @endif

    @if (session('error'))
        <script>
            toastr.error('{{ session('error') }}');
        </script>
    @endif

    <div id="overlay" style="display: none;"></div>
    <div id="welcome-banner" style="display: none;">
        <img src="https://thuyanhfruits.com/wp-content/uploads/2021/03/z2380330537317_f546ae4d0b63d3153b9269e1dc860f58-scaled.jpg"
            alt="Welcome Banner" id="banner-image" />
        <button id="close-banner" class="btn-close" aria-label="Close"></button>
    </div>

    <section class="section-first">
        <div class="container">
            <div class="swapper">
                <div class="inner-category">
                    <div class="inner-head">
                        <img src="assets/icons/list-ul.svg" alt="list ul">
                        <span>Danh mục sản phẩm</span>
                    </div>
                    <ul class="inner-list-item ">
                        @foreach ($categories as $category)
                            <li>
                                <a
                                    href="{{ route('products.byCategory', ['category' => $category->id]) }}">{{ $category->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="inner-slider">
                    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach ($mainBanners as $index => $banner)
                                <a href="{{ $banner->link }}" target="_blank" rel="noopener noreferrer"
                                    class="carousel-item {{ $index === 0 ? 'active' : '' }}" data-bs-interval="10000">
                                    <img src="{{ asset($banner->image_path) }}" alt="{{ $banner->alt_text }}"
                                        class="d-block w-100">
                                </a>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-second">
        <div class="container">
            <div class="swapper">
                <div class="inner-title">
                    <h3>Giỏ quà</h3>
                    <a href="#">Xem tất cả</a>
                </div>
                <div class="inner-content">
                    @foreach ($giftBaskets as $basket)
                        <div class="inner-box">
                            <a href="{{ route('product.giftDetail', $basket->id) }}">
                                @php
                                    $imagePath = $basket->image;
                                    if (strpos($imagePath, 'uploads/products') === false) {
                                        $imagePath = 'layouts/img/' . $basket->image; // Nếu không chứa, thêm 'layouts/img'
                                    }
                                @endphp
                                <img src="{{ asset($imagePath) }}" alt="{{ $basket->name }}">
                            </a>
                            <h5><a href="{{ route('product.giftDetail', $basket->id) }}">{{ $basket->name }}</a></h5>
                            <div class="inner-foot">
                                <p class="price">{{ number_format($basket->price_gift) }}đ</p>
                                <form action="{{ route('cart.add', ['id' => $basket->id]) }}" method="post"
                                    style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="product[id]" value="{{ $basket->id }}">
                                    <input type="hidden" name="product[name]" value="{{ $basket->name }}">
                                    <input type="hidden" name="product[image]" value="{{ $basket->image }}">
                                    <input type="hidden" name="product[price_gift]" value="{{ $basket->price_gift }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <a href="#" onclick="this.closest('form').submit();" class="btn-cart">Thêm giỏ
                                        hàng</a>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="section-three">
        <div class="container">
            <div class="swapper">
                <div class="inner-title">
                    <h3>Sản phẩm bán chạy</h3>

                    {{-- Load danh mục mobile --}}
                    <button class="dropdown-toggle load-category-mobile" type="button" id="dropdownLoadCategory"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownLoadCategory">
                        @if ($topProductsGrouped->isNotEmpty())
                            @foreach ($topProductsGrouped as $categoryName => $products)
                                <li><a class="dropdown-item" href="javascript:void(0);" class="category-link category-link-best"
                                        data-category="{{ $categoryName }}" data-section="sale">{{ $categoryName }}</a>
                                </li>
                            @endforeach
                        @else
                            <li><a class="dropdown-item" href="#">Không có danh mục</a></li>
                        @endif
                    </ul>

                    <ul class="load-category">
                        @if ($topProductsGrouped->isNotEmpty())
                            @foreach ($topProductsGrouped as $categoryName => $products)
                                <li>
                                    <a href="javascript:void(0);" class="category-link category-link-best" data-category="{{ $categoryName }}" data-section="sale">{{ $categoryName }}</a>
                                </li>
                            @endforeach
                        @else
                            <li><a href="">Chưa có danh mục</a></li>
                        @endif
                    </ul>
                </div>
                <div class="inner-content product-grid-best">
                    @foreach ($topProducts as $item)
                        <div class="inner-box">
                            <a href="{{ route('product.detail', $item->id) }}">
                                @php
                                        $imagePath = $item->image;
                                        if (strpos($imagePath, 'uploads/products') === false) {
                                            $imagePath = 'layouts/img/' . $imagePath;
                                        }
                                    @endphp
                                <img src="{{ asset($imagePath) }}" alt="{{ $item->name }}">
                            </a>
                            <h5><a href="{{ route('product.detail', $item->id) }}">{{ $item->name }}</a></h5>
                            <div class="inner-foot">
                                <div class="inner-price-sale">
                                    <p class="price">{{ number_format($item->price, 0) }}đ</p>
                                    <p class="sales">Đã bán: {{ number_format($item->sales, 1) }} kg</p>
                                </div>
                                <form action="{{ route('cart.add', ['id' => $item->id]) }}" method="post"
                                    style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="product[id]" value="{{ $item->id }}">
                                    <input type="hidden" name="product[name]" value="{{ $item->name }}">
                                    <input type="hidden" name="product[image]" value="{{ $item->image }}">
                                    <input type="hidden" name="product[price]" value="{{ $item->price }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <a href="#" onclick="this.closest('form').submit();" class="btn-cart">Thêm giỏ
                                        hàng
                                    </a>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="inner-link">
                    <a href="/product">Xem tất cả</a>
                </div>
            </div>
        </div>
    </section>

    <section class="section-four">
        <div class="container">
            <div class="inner-banner">
                @if ($secondaryBanners && $secondaryBanners->isNotEmpty())
                    <a href="{{ $secondaryBanners->first()->link }}" target="_blank">
                        <img src="{{ asset($secondaryBanners->first()->image_path) }}"
                            alt="{{ $secondaryBanners->first()->alt_text }}">
                    </a>
                @endif
            </div>
        </div>
    </section>

    <section class="section-five">
        <div class=" container">
            <div class="swapper">
                <div class="inner-title">
                    <h3>Sản phẩm mới</h3>

                    {{-- Load danh mục mobile --}}
                    <button class="dropdown-toggle load-category-mobile" type="button" id="dropdownLoadCategoryBest"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <ul class="dropdown-menu category-title category-new" aria-labelledby="dropdownLoadCategoryBest">
                        @if ($newProductsGrouped->isNotEmpty())
                            @foreach ($newProductsGrouped as $categoryName => $products)
                                <li><a class="dropdown-item" href="javascript:void(0);" class="category-link category-link-new"
                                        data-category="{{ $categoryName }}" data-section="new">{{ $categoryName }}</a>
                                </li>
                            @endforeach
                        @else
                            <li><a class="dropdown-item" href="#">Không có danh mục</a></li>
                        @endif
                    </ul>

                    <ul class="load-category category-title category-new">
                        @if ($newProductsGrouped->isNotEmpty())
                        @foreach ($newProductsGrouped as $categoryName => $products)
                                <li>
                                   <a href="javascript:void(0);" class="category-link category-link-new" data-category="{{ $categoryName }}" data-section="new">{{ $categoryName }}</a>
                                </li>
                            @endforeach
                        @else
                            <li><a href="">Chưa có danh mục</a></li>
                        @endif
                    </ul>
                </div>
                <div class="inner-content product-grid-new">
                    @foreach ($newProducts as $item)
                        <div class="inner-box">
                            <div class="badge">Mới</div>
                            <a href="{{ route('product.detail', $item->id) }}">
                                    @php
                                        $imagePath = $item->image;
                                        if (strpos($imagePath, 'uploads/products') === false) {
                                            $imagePath = 'layouts/img/' . $imagePath;
                                        }
                                    @endphp
                                <img src="{{ asset($imagePath) }}" alt="{{ $item->name }}">
                            </a>
                            <h5>
                                <a href="{{ route('product.detail', $item->id) }}">{{ $item->name }}</a>
                            </h5>
                            <div class="inner-foot">
                                <p class="price">{{ number_format($item->price, 0) }}đ</p>
                                <form action="{{ route('cart.add', ['id' => $item->id]) }}" method="post"
                                    style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="product[id]" value="{{ $item->id }}">
                                    <input type="hidden" name="product[name]" value="{{ $item->name }}">
                                    <input type="hidden" name="product[image]" value="{{ $item->image }}">
                                    <input type="hidden" name="product[price]" value="{{ $item->price }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <a href="#" onclick="this.closest('form').submit();" class="btn-cart">
                                        Thêm giỏ hàng
                                    </a>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="inner-link">
                    <a href="/product">Xem tất cả</a>
                </div>
            </div>
        </div>
    </section>

    {{-- <section class="section-six">
        <div class="container">
            <div class="inner-banner">
                <div class="banner-left">
                    <a href="#">
                        <img src="client/assets/img/1.jpg" alt="banner">
                    </a>
                </div>
                <div class="banner-center">
                    <a href="#">
                        <img src="client/assets/img/2.png" alt="banner">
                    </a>
                </div>
                <div class="banner-right">
                    <a href="#">
                        <img src="client/assets/img/3.png" alt="banner">
                    </a>
                </div>
            </div>
        </div>
    </section> --}}

    <section class="section-seven">
        <div class="container">
            <div class="swapper">
                <div class="inner-title">
                    <h3>Tin tức mới</h3>
                    <a href="#">Xem tất cả</a>
                </div>
                <div class="inner-content">
                    <div class="inner-left">
                        <a href="{{ route('post.show', ['id' => $latestPost->id]) }}">
                            @php
                                $imagePath = $latestPost->image;
                                // Nếu đường dẫn ảnh chứa 'uploads/posts', không cần thêm 'layouts/img'
                                if (strpos($imagePath, 'uploads/posts') === false) {
                                    $imagePath = 'layouts/img/' . $imagePath; // Nếu không chứa, thêm 'layouts/img'
                                }
                            @endphp
                            <img src="{{ asset($imagePath) }}" alt="img">
                        </a>
                        <a href="{{ route('post.show', ['id' => $latestPost->id]) }}">
                            <h4>{{ $latestPost->title }}</h4>
                        </a>
                        <div class="inner-media">
                      {{--  --}}
                            <small>{{ $latestPost->created_at }}</small>
                        </div>
                        <div class="inner-text">
                            <p>
                                <div style="
                                display: -webkit-box;
                                -webkit-line-clamp: 3;
                                -webkit-box-orient: vertical;
                                overflow: hidden;
                                text-overflow: ellipsis;">
                                @php
                                    // Loại bỏ các ký tự &nbsp; và thẻ <img>
                                    $clearBreakLineArrStr = \Illuminate\Support\Str::replace('&nbsp;', '', $latestPost->content);
                                    $clearImgArrStr = preg_replace("/<img([\w\W]+?)\/?>/", "", $clearBreakLineArrStr);
                                @endphp
                            
                                @foreach (explode("\n", $clearImgArrStr) as $key => $item)
                                    {!! $item !!}
                                    @if ($key === 3)
                                        @break
                                    @endif
                                @endforeach
                            </div>
                            </p>
                        </div>
                    </div>
                    <div class="inner-right">
                        @foreach ($nextPosts as $post)
                            <div class="inner-box">
                                <a href="{{ route('post.show', ['id' => $post->id]) }}">
                                    @php
                                        $imagePath = $post->image;
                                        if (strpos($imagePath, 'uploads/posts') === false) {
                                            $imagePath = 'layouts/img/' . $imagePath;
                                        }
                                    @endphp
                                    <img src="{{ asset($imagePath) }}" alt="img">
                                </a>
                                <div class="inner-text">
                                    <a href="{{ route('post.show', ['id' => $post->id]) }}">
                                        <h4>{{ $post->title }}</h4>
                                    </a>
                                    <div class="inner-media">
                                        {{-- <h6>{{ $post->author }}</h6> --}}
                                        <small>{{ $post->created_at }}</small>
                                    </div>
                                    <p> <a href="{{ route('post.show', ['id' => $post->id]) }}" style="
                                        color: black; 
                                        text-decoration: none; 
                                        font-size: 15px;
                                        display: -webkit-box; 
                                        -webkit-line-clamp: 2; 
                                        -webkit-box-orient: vertical; 
                                        overflow: hidden; 
                                        text-overflow: ellipsis;">
                                        @php
                                            // Loại bỏ các ký tự &nbsp; và thẻ <img>
                                            $clearBreakLineArrStr = \Illuminate\Support\Str::replace('&nbsp;', "", $post->content);
                                            $clearImgArrStr = preg_replace("/<img([\w\W]+?)\/?>/", "", $clearBreakLineArrStr);
                                    
                                            // Loại bỏ thẻ HTML không cần thiết
                                            $cleanContent = strip_tags($clearImgArrStr);
                                        @endphp
                                    
                                        {!! $cleanContent !!}
                                    </a></p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Xử lý danh mục sản phẩm mới
    $(document).on('click', '.category-link-new', function() {
       console.log('aa');
       
        var categoryName = $(this).data('category');
        console.log('categoryName',categoryName);
        
        var currentUrl = window.location.href.split('?')[0];

        $.ajax({
            url: '{{ route('products.category.name', ':categoryName') }}'
                .replace(':categoryName', categoryName),
            type: 'GET',
            success: function(response) {
                console.log(response);
                var html = '';

                if (response.length > 0) {
                    $.each(response, function(index, product) {
                        var imagePath = product.image.includes('uploads/products') 
                        ? product.image  // Nếu có, giữ nguyên đường dẫn
                        : 'layouts/img/' + product.image;  // Nếu không, thay thế bằng 'layouts/img/'
                        html += `
                          <div class="inner-box">
                            <div class="badge">Mới</div>
                            <a href="/product/${product.id}">
                              <img src="${imagePath}" alt="${product.name}" width="100%" height="200px">
                            </a>
                            <h5>
                                <a href="/product/${product.id}" >${product.name}</a>
                            </h5>
                            <div class="inner-foot">
                               <p class="price">${new Intl.NumberFormat('vi-VN').format(product.price)}đ </p>
                                <a href="#" class="btn-cart">Thêm giỏ hàng</a>
                            </div>
                        </div>
                        `;
                    });
                    
                } else {
                    html = '<p>Không có sản phẩm nào trong danh mục này.</p>';
                }

                $('.product-grid-new').html(html);
                window.history.pushState(
                    { category: categoryName },
                    '',
                    currentUrl + '?category=' + categoryName
                );
            },
            error: function() {
                alert('Có lỗi xảy ra khi tải sản phẩm.');
            }
        });
    });

    // Xử lý danh mục sản phẩm bán chạy
    $(document).on('click', '.category-link-best', function() {
        var categoryName = $(this).data('category');
        var currentUrl = window.location.href.split('?')[0];

        $.ajax({
            url: '{{ route('products.category.name', ':categoryName') }}'
                .replace(':categoryName', categoryName),
            type: 'GET',
            success: function(response) {
                var html = '';

                if (response.length > 0) {
                    $.each(response, function(index, product) {
                        var imagePath = product.image.includes('uploads/products') 
                        ? product.image  // Nếu có, giữ nguyên đường dẫn
                        : 'layouts/img/' + product.image;  // Nếu không, thay thế bằng 'layouts/img/'
                        html += `
                            <div class="inner-box">
                                <a href="/product/${product.id}">
                                    <img src="${imagePath}" alt="${product.name}" width="100%" height="200px">
                                </a>
                                <h5>
                                    <a href="/product/${product.id}">${product.name}</a>
                                </h5>
                                <div class="inner-foot">
                                    <div class="inner-price-sale">
                                        <p class="price">${new Intl.NumberFormat('vi-VN').format(product.price)}đ</p>
                                        <p class="sales">Đã bán: ${new Intl.NumberFormat('vi-VN').format(product.sales)}kg</p>
                                    </div>
                                    <a href="#" class="btn-cart">Thêm giỏ hàng</a>
                                </div>
                            </div>
                        `;
                    });
                } else {
                    html = '<p>Không có sản phẩm nào trong danh mục này.</p>';
                }

                $('.product-grid-best').html(html);
                window.history.pushState(
                    { category: categoryName },
                    '',
                    currentUrl + '?category=' + categoryName
                );
            },
            error: function() {
                alert('Có lỗi xảy ra khi tải sản phẩm.');
            }
        });
    });
</script>


@endsection
