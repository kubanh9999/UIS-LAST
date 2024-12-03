@extends('layouts.master')
@section('title', 'Chi tiết bài viết')
@section('content')

<main class="main-content">

    <!-- Breadcrumb Section -->
    <section class="breadcrumb">
        <div class="container">
            <ul class="breadcrumb-list mb-0">
                <li class="breadcrumb-item"><a href="{{ route('posts.index') }}">Trang chủ</a></li>
                <li class="breadcrumb-separator">/</li>
                <li class="breadcrumb-item"><a href="{{ route('posts.index') }}">Blog</a></li>
                <li class="breadcrumb-separator">/</li>
                <li class="breadcrumb-item"><a href="#">{{ $post->title }}</a></li>
            </ul>
        </div>
    </section>

    <!-- Post Detail Section -->
    <section class="post-detail mb-4">
        <div class="container bg-white p-4">
            <div class="row">
                <!-- Post Info Section -->
                <div class="col-md-12 post-info">
                    <h2 class="post-title text-center">{{ $post->title }}</h2>
                    <ul class="post-meta">
                        <li class="meta">Ngày đăng: <span>{{ $post->created_at->format('d/m/Y') }}</span></li>
                        <li class="meta">Danh mục: <span>{{ $post->categoryid }}</span></li>
                    </ul>
                </div>

                <!-- Post Image Section -->
                {{-- <div class="col-md-12">
                    <div class="post-images">
                        <div class="main-image">
                            <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image">
                        </div>
                    </div>
                </div>
 --}}
                <!-- Post Content Section -->
                <div class="col-md-12 img-center">
                    <div id="description" class="text-container container">
                        <div class="post-body">
                            {!! $post->content !!}
                        </div>
                
                        {{-- <button id="toggle-button-content" onclick="toggleContent()">Xem thêm</button>
                        <div id="full-content" style="display: none;">
                            <p>{{ $post->content }}</p>
                        </div> --}}
                    </div>
                </div>
    <style>
        .img-center img {
        display: block;     /* Đặt ảnh thành phần tử block */
        margin: 0 auto;     /* Căn giữa ảnh */
        max-width: 100%;     /* Đảm bảo ảnh không vượt quá chiều rộng của container */
        height: auto;        /* Đảm bảo tỷ lệ ảnh không bị méo */
    }
    </style>

            </div>
        </div>
    </section>

</main>

@endsection
