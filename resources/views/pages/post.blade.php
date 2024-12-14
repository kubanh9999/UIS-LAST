@extends('layouts.master')
@section('title', 'Bài viết')
@section('content')
<style>
    .card-text {
    font-size: 14px;
    display: -webkit-box;
    -webkit-line-clamp: 3; /* Giới hạn số dòng hiển thị */
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis; /* Hiển thị dấu '...' khi tràn */
}
</style>

    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">bài viết</li>
            </ol>
        </nav>
    </div>


<section class="collection-section py-4">
    <div class="container">
        <div class="row">
            <!-- Sidebar Section -->
            <div class="col-md-4 col-lg-3 d-none d-lg-block">
                <aside class="collection-sidebar">
                    <!-- Categories -->
                    <div class="category-box bg-white shadow-sm rounded p-4 mb-4">
                        <h2 class="h5 border-bottom pb-2 mb-3">Danh mục</h2>
                        <ul class="category-list list-unstyled mb-0">
                            <li class="category-item mb-2"><a href="{{ route('posts.index') }}" class="text-decoration-none text-dark">Tất cả</a></li>
                            @foreach($categories as $category)
                                <li class="category-item mb-2">
                                    <a href="{{ route('posts.index', ['category' => $category->id]) }}" class="text-decoration-none text-dark">{{ $category->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </aside>
            </div>

            <!-- Main Content Section (Blog Posts) -->
            <div class="col-md-12 col-lg-9">
                <div class="blog-posts-container bg-white shadow-sm rounded p-4">
                    <!-- Blog Posts Area -->
                    <div class="row">
                        @foreach($posts as $post)
                            <div class="col-md-6 mb-4">
                                <div class="card border-0 shadow-sm h-100">
                                    <a href="{{ route('post.show', $post->id) }}" class="d-block overflow-hidden rounded-top">
                                        @php 
                                            $imagePath = $post->image;
                                            if(strpos($imagePath, 'uploads/posts') === false){
                                                $imagePath = 'layouts/img/' . $imagePath;
                                            }
                                        @endphp
                                        <img src="{{ asset($imagePath) }}" 
                                             class="card-img-top" alt="{{ $post->title }}" style="height: 200px; object-fit: cover;">
                                    </a>
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title text-truncate">
                                            <a href="{{ route('post.show', $post->id) }}" class="text-dark text-decoration-none">{{ $post->title }}</a>
                                        </h5>
                                        <p class="card-text flex-grow-1 text-muted" 
                                           style="font-size: 14px; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                            @php
                                                $content = $post->content ?? '';
                                                $clearBreakLineArrStr = \Illuminate\Support\Str::replace('&nbsp;', '', $content);
                                                $clearImgArrStr = preg_replace("/<img([\w\W]+?)\/?\?>/", '', $clearBreakLineArrStr);
                                                $lines = preg_split('/<br\s*\/??>|\n/', trim($clearImgArrStr));
                                            @endphp
                                            @foreach ($lines as $key => $line)
                                                @if (!empty(trim($line)))
                                                    {!! $line !!}
                                                    @if ($key === 2)
                                                        @break
                                                    @endif
                                                @endif
                                            @endforeach
                                        </p>
{{--                                         <a href="{{ route('post.show', $post->id) }}" class="btn btn-primary btn-sm mt-auto align-self-start">Xem thêm</a>
 --}}                                    </div>
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
