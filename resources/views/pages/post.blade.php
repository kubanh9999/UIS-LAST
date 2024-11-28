@extends('layouts.master')
@section('title', 'Bài viết')
@section('content')

<section class="breadcrumb">
    <div class="container">
        <ul class="breadcrumb-list mb-0">
            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
            <li class="breadcrumb-separator">/</li>
            <li class="breadcrumb-item"><a href="#">Blog</a></li>
        </ul>
    </div>
</section>

<section class="collection-section">
    <div class="container">
        <div class="row">
            <!-- Sidebar Section -->
            <div class="col-md-4 col-lg-3 d-none d-md-none d-lg-block">
                <aside class="collection-sidebar">
                    <!-- Categories -->
                    <div class="category-box bg-white p-3">
                        <h2>Danh mục</h2>
                        <ul class="category-list list-unstyled mb-0">
                            <li class="category-item"><a href="{{ route('posts.index') }}">Tất cả</a></li>
                            @foreach($categories as $category)
                                <li class="category-item">
                                    <a href="{{ route('posts.index', ['category' => $category->id]) }}">{{ $category->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </aside>
            </div>

            <!-- Main Content Section (Blog Posts) -->
            <div class="col-md-12 col-lg-9 p-0 px-md-2">
                <div class="blog-posts-container bg-white p-3 p-md-4">
                    <!-- Blog Posts Area -->
                    <div class="row">
                        @foreach($posts as $post)
                            <div class="col-md-6 mb-4">
                                <div class="card">
                                    <!-- Thêm lớp ảnh Bootstrap với chiều cao cố định -->
                                    <a href="{{ route('post.show', $post->id) }}">
                                        @php 
                                            $imagePath = $post->image;
                                            if(strpos($imagePath, 'uploads/posts') === false ){
                                                $imagePath = 'layouts/img/' . $imagePath;
                                            }
                                        @endphp
                                        <img src="{{ asset($imagePath) }}" 
                                        class="card-img-top" alt="{{ $post->title }}" style="height: 200px; object-fit: cover;"></a>
                                    
                                    <div class="card-body d-flex flex-column" style="height: 300px;">
                                        <h5 class="card-title">
                                            <a href="{{ route('post.show', $post->id) }}" class="text-dark" style="text-decoration: none; ">{{ $post->title }}</a>
                                        </h5>
                                        
                                        <p class="card-text" style="flex-grow: 1; font-size: ">
                                            @php
                               
                                
                                            $clearBreakLineArrStr = Str::replace('&nbsp;',"", $post->content);
                                            
                                            $clearImgArrStr = preg_replace("<img([\w\W]+?)/>", "", $clearBreakLineArrStr);
                    
                                            @endphp
                                            @foreach (explode("\n",
                                                   $clearImgArrStr
                                                ) as $key => $item)
                                                {!! $item !!}
                                                @if ($key === 2)
                                                    @break
                                                @endif
                                            @endforeach
                                            
                                        </p>
                                      
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    

                    <!-- Pagination -->
                    <nav aria-label="Page navigation" class="mt-4">
                        {{ $posts->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
