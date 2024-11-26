@extends('layouts.master')
@section('title', 'Chi tiết bài viết')
@section('content')

<style>
.img-center img {
    display: block;
    margin: 0 auto; 
    max-width: 100%;
    height: auto; 
}
</style>

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

<section class="post-detail mb-4">
    <div class="container bg-white p-4">
        <div class="row">
            <!-- Post Image Section -->
            <div class="post-info">
                <h2 class="post-title" style="text-align: center">{{ $post->title }}</h2>
                <ul class="post-meta">
                    <!-- <li class="meta">Tác giả: <span>{{ $post->author }}</span></li> -->
                    <li class="meta">Ngày đăng: <span>{{ $post->created_at->format('d/m/Y') }}</span></li>
              {{--       <li class="meta">Danh mục: <span>{{ $post->category->name }}</span></li> --}}
                </ul>
            </div>
           {{--  <div class="col-md-12">
                <div class="post-images">
                    <div class="main-image">
                        <img src="{{ asset('layouts/img/' . $post->image) }}">
                    </div>
                </div>
            </div> --}}

            <!-- Post Details Section -->
            <div class="col-md-12 img-center">
                <div id="description" class="text-container container">
                    <div class="post-body">
                        {!! $post->content !!}
                    </div>
            
                   {{--  <button id="toggle-button-content" onclick="toggleContent()">Xem thêm</button>
                    <div id="full-content" style="display: none;">
                        <p>{{ $post->content }}</p>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</section>

{{-- <section class="related-posts mb-4">
    <div class="container bg-white p-4">
        <h2 class="section-title mb-3">Bài viết liên quan</h2>
        <div class="related-posts-list row">
            @foreach ($relatedPosts as $relatedPost)
            <div class="col-md-4">
                <div class="post-card">
                    <img src="{{ asset('storage/' . $relatedPost->image) }}" alt="Blog Post 1">
                    <h5>{{ $relatedPost->title }}</h5>
                    <p>{{ Str::limit($relatedPost->content, 100) }}</p>
                    <a href="{{ route('post.show', $relatedPost->id) }}">Đọc thêm</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>   --}}

<script>
    function toggleContent() {
        const content = document.getElementById('full-content');
        const button = document.getElementById('toggle-button-content');
        
        // Toggle display of content
        if (content.style.display === 'none') {
            content.style.display = 'block';
            button.textContent = 'Thu gọn';
        } else {
            content.style.display = 'none';
            button.textContent = 'Xem thêm';
        }
    }
</script>
@endsection
