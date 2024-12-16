@extends('layouts.master')
@section('title', 'Sản phẩm')
@section('content')

    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Sản phẩm</li>
            </ol>
        </nav>
    </div>

    <section class="section-product">
        <div class="container">
            <div class="inner-section">
                <div class="inner-left">
                    <div class="inner-box">
                        <div class="inner-head">
                            <h4>Danh mục sản phẩm</h4>
                        </div>
                        
                        <ul class="inner-list">
                            <li class="category-item">
                                <a href="{{ route('products.byCategory', array_merge(request()->except('category'), ['category' => 'all'])) }}">Tất cả sản phẩm</a>
                            </li>
                            @foreach ($categories as $category)
                                <li>
                                    <a
                                        href="{{ route('products.byCategory', array_merge(request()->except('category'), ['category' => $category->id])) }}">
                                        {{ $category->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="inner-box">
                        <div class="inner-head">
                            <h4>Mức giá</h4>
                        </div>
                        <form action="{{ request()->url() }}" method="GET" class="inner-form">
                            <label>
                                <input type="radio" name="price" value="under_99000"
                                    {{ request()->input('price') == 'under_99000' ? 'checked' : '' }}>
                                <p>Giá dưới 99.000đ</p>
                            </label>
                            <label>
                                <input type="radio" name="price" value="99000_201000"
                                    {{ request()->input('price') == '99000_201000' ? 'checked' : '' }}>
                                <p>99.000đ - 201.000đ</p>
                            </label>
                            <label>
                                <input type="radio" name="price" value="201000_301000"
                                    {{ request()->input('price') == '201000_301000' ? 'checked' : '' }}>
                                <p>201.000đ - 301.000đ</p>
                            </label>
                            <label>
                                <input type="radio" name="price" value="301000_501000"
                                    {{ request()->input('price') == '301000_501000' ? 'checked' : '' }}>
                                <p>301.000đ - 501.000đ</p>
                            </label>
                            <label>
                                <input type="radio" name="price" value="501000_1000000"
                                    {{ request()->input('price') == '501000_1000000' ? 'checked' : '' }}>
                                <p>501.000đ - 1.000.000đ</p>
                            </label>
                            <label>
                                <input type="radio" name="price" value="above_1000000"
                                    {{ request()->input('price') == 'above_1000000' ? 'checked' : '' }}>
                                <p>Giá trên 1.000.000đ</p>
                            </label>
                            <button type="submit" class="btn">Lọc</button>
                        </form>
                    </div>
                </div>

                <div class="inner-right">
                    <div class="inner-head">
                        <h3>Tất cả sản phẩm</h3>
                        <form action="{{ request()->url() }}" method="GET">
                            <select name="sort" class="sort-options" aria-label="Sort by" onchange="this.form.submit();">
                                <option value="default" {{ request()->input('sort') == 'default' ? 'selected' : '' }}>
                                    Mặc định</option>
                                <option value="asc" {{ request()->input('sort') == 'asc' ? 'selected' : '' }}>Giá
                                    tăng dần</option>
                                <option value="desc" {{ request()->input('sort') == 'desc' ? 'selected' : '' }}>Giá
                                    giảm dần</option>
                                <option value="newest" {{ request()->input('sort') == 'newest' ? 'selected' : '' }}>
                                    Mới
                                    nhất</option>
                                <option value="oldest" {{ request()->input('sort') == 'oldest' ? 'selected' : '' }}>Cũ
                                    nhất</option>
                            </select>
                        </form>
                    </div>
                    <div class="inner-content">
                        @foreach ($products as $product)
                            <div class="inner-box">
                                <div class="badge d-none">Mới</div>
                                <a href="{{ route('product.detail', $product->id) }}">
                                    @php
                                        $imagePath = public_path($product->image);
                                    @endphp

                                    @if (file_exists($imagePath))
                                        <img src="{{ asset($product->image) }}" alt="Ảnh sản phẩm">
                                    @else
                                        <img src="{{ asset('layouts/img/' . $product->image) }}" alt="Ảnh sản phẩm">
                                    @endif
                                </a>
                                <h5>
                                    <a href="{{ route('product.detail', $product->id) }}">{{ $product->name }}</a>
                                </h5>
                                <div class="inner-foot">
                                    <div class="inner-price-sale">
                                        <p class="price">{{ number_format($product->price, 0) }}đ</p>
                                        <p class="sales" style="{{ $product->sales > 0 ? '' : 'display: none;' }}">Đã
                                            bán: {{ number_format($product->sales, 1) }} kg</p>
                                    </div>
                                    <form action="{{ route('cart.add', ['id' => $product->id]) }}" method="post"
                                        style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="product[id]" value="{{ $product->id }}">
                                        <input type="hidden" name="product[name]" value="{{ $product->name }}">
                                        <input type="hidden" name="product[image]" value="{{ $product->image }}">
                                        <input type="hidden" name="product[price]" value="{{ $product->price }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <a href="#" onclick="this.closest('form').submit();" class="btn-cart">
                                            <i class="fa-solid fa-cart-shopping"></i> 
                                        </a>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>

                        <div class="inner-content mt-2">
                            @foreach ($productTypes as $productType)
                                <div class="inner-box">
                                    <div class="badge d-none">Mới</div>
                                    <a href="{{ route('product.giftDetail', $productType->id) }}">
                                        @php
                                            $imagePath = $productType->image;
                                            // Nếu đường dẫn ảnh chứa 'uploads/posts', không cần thêm 'layouts/img'
                                            if (strpos($imagePath, 'uploads/products') === false) {
                                                $imagePath = 'layouts/img/' . $imagePath; // Nếu không chứa, thêm 'layouts/img'
                                            }
                                        @endphp
                                        <img src="{{ asset($imagePath) }}" alt="{{ $productType->name }}">
                                    </a>
                                    <h5>
                                        <a href="{{ route('product.giftDetail', $productType->id) }}">
                                            {{ $productType->name }}
                                        </a>
                                    </h5>
                                    <div class="inner-foot">
                                        <p class="price">{{ number_format($productType->price_gift, 0) }}đ</p>
                                        <form action="{{ route('cart.add', ['id' => $productType->id]) }}" method="post"
                                            style="display: inline;">
                                            @csrf
                                            <input type="hidden" id="quantity-hidden" name="quantity" value="1">
                                            <input type="hidden" name="basket[id]" value="{{ $productType->id }}">
                                            <input type="hidden" name="basket[name]" value="{{ $productType->name }}">
                                            <input type="hidden" name="basket[image]" value="{{ $productType->image }}">
                                            <input type="hidden" name="basket[price_gift]" value="{{ $productType->price_gift }}">
                                            <a href="#" onclick="this.closest('form').submit();" class="btn-cart">
                                                <i class="fa-solid fa-cart-shopping"></i>
                                            </a>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    

                    <ul class="pagination justify-content-center mt-3">
                        <!-- Previous Page Link -->
                        @if ($products->onFirstPage())
                            <li class="page-item disabled">
                                <a class="page-link" href="#" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $products->previousPageUrl() }}" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        @endif
                        <!-- Pagination Elements -->
                        @for ($i = 1; $i <= $products->lastPage(); $i++)
                            @if ($i == $products->currentPage())
                                <li class="page-item active">
                                    <a class="page-link">{{ $i }}</a>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $products->url($i) }}">{{ $i }}</a>
                                </li>
                            @endif
                        @endfor
                        <!-- Next Page Link -->
                        @if ($products->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $products->nextPageUrl() }}" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <a class="page-link" href="#" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        @endif

                    </ul>
                </div>

            </div>
        </div>
    </section>
@endsection
