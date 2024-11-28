@extends('layouts.master')
@section('title', 'Sản phẩm')
@section('content')
    <section class="breadcrumb">
        <div class="container">
            <ul class="breadcrumb-list mb-0">
                <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                <li class="breadcrumb-separator">/</li>
                <li class="breadcrumb-item"><a href="#">Shop</a></li>
            </ul>
        </div>
    </section>

    <section class="collection-section">
        <div class="container">
            <div class="row">
                <!-- Sidebar Section -->
                <div class="col-md-4 col-lg-3 d-none d-md-none d-lg-block">
                    <aside class="collection-sidebar">
                        <div class="category-box bg-white p-3">
                            <h2>Danh mục sản phẩm</h2>
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
                        <div class="price-filter bg-white p-3 mb-3 mt-4">
                            <h4>Mức giá</h4>
                            <form action="{{ request()->url() }}" method="GET">
                                <div>
                                    <label><input type="radio" name="price" value="under_99000" {{ request()->input('price') == 'under_99000' ? 'checked' : '' }}> Giá dưới 99.000đ</label>
                                </div>
                                <div>
                                    <label><input type="radio" name="price" value="99000_201000" {{ request()->input('price') == '99000_201000' ? 'checked' : '' }}> 99.000đ - 201.000đ</label>
                                </div>
                                <div>
                                    <label><input type="radio" name="price" value="201000_301000" {{ request()->input('price') == '201000_301000' ? 'checked' : '' }}> 201.000đ - 301.000đ</label>
                                </div>
                                <div>
                                    <label><input type="radio" name="price" value="301000_501000" {{ request()->input('price') == '301000_501000' ? 'checked' : '' }}> 301.000đ - 501.000đ</label>
                                </div>
                                <div>
                                    <label><input type="radio" name="price" value="501000_1000000" {{ request()->input('price') == '501000_1000000' ? 'checked' : '' }}> 501.000đ - 1.000.000đ</label>
                                </div>
                                <div>
                                    <label><input type="radio" name="price" value="above_1000000" {{ request()->input('price') == 'above_1000000' ? 'checked' : '' }}> Giá trên 1.000.000đ</label>
                                </div>
                                <button type="submit" class="btn btn-primary mt-2">Lọc</button>
                            </form>
                        </div>
                        
                    </aside>
                </div>

                <!-- Main Content Section -->
                <div class="col-md-12 col-lg-9 p-0 px-md-2">
                    <div class="products-container bg-white p-3 p-md-4">
                        <div class="collection-header">
                            <h2 class="collection-title">Tất cả sản phẩm</h2>
                            <form action="{{ request()->url() }}" method="GET" class="d-inline">
                                <select name="sort" class="sort-options" aria-label="Sort by" onchange="this.form.submit();">
                                    <option value="default" {{ request()->input('sort') == 'default' ? 'selected' : '' }}>Mặc định</option>
                                    <option value="asc" {{ request()->input('sort') == 'asc' ? 'selected' : '' }}>Giá tăng dần</option>
                                    <option value="desc" {{ request()->input('sort') == 'desc' ? 'selected' : '' }}>Giá giảm dần</option>
                                    <option value="newest" {{ request()->input('sort') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                                    <option value="oldest" {{ request()->input('sort') == 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
                                </select>
                            </form>
                        </div>
                        

                        <!-- Products Area -->
                        <div class="product-grid">
                            @foreach ($products as $product)
                                <div class="product-card">
                                    {{-- Kiểm tra nếu sản phẩm mới (có thể bỏ hoặc giữ phần này) --}}
                                    {{-- @if ($product->is_new)
                                        <div class="new-badge">New</div>
                                    @endif --}}
                                    
                                    <a href="{{ route('product.detail', $product->id) }}">
                                        @php
                                            $imagePath = public_path($product->image);
                                        @endphp

                                        @if (file_exists($imagePath))
                                            <img src="{{ asset($product->image) }}" alt="Ảnh sản phẩm" width="100">
                                        @else
                                            <img src="{{ asset('layouts/img/'.$product->image) }}" alt="Ảnh sản phẩm" width="100">
                                        @endif
                                    </a>
                                    <h5 class="product-name">
                                        <a href="{{ route('product.detail', $product->id) }}">
                                            {{ $product->name }}
                                        </a>
                                    </h5>
                                    <div class="price">
                                        {{ number_format($product->price, 0) }} VND
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                         <!-- Kiểm tra nếu là giỏ quà -->
                            <div class="product-grid mt-2">
                                @foreach ($productTypes as $productType)
                                    <div class="product-card">
                                        <a href="{{ route('product.giftDetail', $productType->id) }}">
                                            <img src="{{ asset('layouts/img/' . $productType->image) }}" alt="{{ $productType->name }}" class="card-img-top">
                                        </a>
                                        <h5 class="product-name">
                                            <a href="{{ route('product.giftDetail', $productType->id) }}">
                                                {{ $productType->name }}
                                            </a>
                                        </h5>
                                        <div class="price">
                                            {{ number_format($productType->price_gift, 0) }} VND
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                      
                        
                       {{--  <div class="product-grid row">
                            @foreach ($allProducts as $product)
                                <div class="col-md-4 col-sm-6 col-12 product-card mb-4">
                                    <div class="card">
                                        <img src="{{ asset('layouts/img/' . $product->image) }}" alt="{{ $product->name }}" class="card-img-top">
                                        <div class="card-body">
                                            <h5 class="product-name card-title">
                                                @if (isset($product->price)) 
                                                    <!-- Sản phẩm thường -->
                                                    <a href="{{ route('product.detail', $product->id) }}" class="text-decoration-none">
                                                        {{ $product->name }}
                                                    </a>
                                                @else
                                                    <!-- Giỏ quà -->
                                                    <a href="{{ route('product.giftDetail', $product->id) }}" class="text-decoration-none">
                                                        {{ $product->name }}
                                                    </a>
                                                @endif
                                            </h5>
                                            <div class="price">
                                                @if (isset($product->price))
                                                    {{ number_format($product->price, 0) }} VND
                                                @else
                                                    {{ number_format($product->price_gift, 0) }} VND
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div> --}}
                        

                        <!-- Pagination -->
                        <nav aria-label="Page navigation" class="mt-4">
                            <ul class="pagination justify-content-center mb-0">
                                <!-- Previous Page Link -->
                                @if ($products->onFirstPage())
                                    <li class="page-item disabled">
                                        <a class="page-link" aria-label="Previous">
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
                                        <a class="page-link" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

                        