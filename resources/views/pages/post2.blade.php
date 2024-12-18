@extends('layouts.master')
@section('title', 'Bài viết')
@section('content')

    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tin tức</li>
            </ol>
        </nav>
    </div>


    <section class="section-posts">
        <div class="container">
            <div class="swapper">
                <div class="inner-category">
                    <div class="inner-content inner-content-left">
                        <h3 class="category-title">Danh mục tin tức</h3>
                        <ul class="category-list">
                            @foreach ($categories as $category)
                                <li class="category-item">
                                    <a href="{{ route('posts.index', ['category' => $category->id]) }}">{{ $category->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="inner-content inner-content-right mt-4">
                        @if($recentlyViewedPosts->count() > 0)
                            <h3>Tin tức đã xem gần đây</h3>
                            <div class="inner-recentlyViewedPosts">
                                @foreach($recentlyViewedPosts as $post)

                                    <a href="{{ route('post.show', $post->id) }}">
                                        @php
                                            $imagePath = $post->image;
                                            if (strpos($imagePath, 'uploads/posts') === false) {
                                                $imagePath = 'layouts/img/' . $imagePath;
                                            }
                                        @endphp
                                        <img src="{{ asset($imagePath) }}" alt="{{ $post->title }}">
                                        <h4>{{ $post->title }}</h4>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
                <div class="inner-posts">
                    @foreach ($posts as $post)
                        <div class="inner-content">

                            <a class="inner-img" href="{{ route('post.show', $post->id) }}">
                                @php
                                    $imagePath = $post->image;
                                    if (strpos($imagePath, 'uploads/posts') === false) {
                                        $imagePath = 'layouts/img/' . $imagePath;
                                    }
                                @endphp
                                <img src="{{ asset($imagePath) }}" alt="{{ $post->title }}">
                            </a>

                            <h5 class="inner-title">
                                <a href="{{ route('post.show', $post->id) }}">{{ $post->title }}</a>
                            </h5>

                            <div class="inner-media">
                                <small>{{ $post->created_at->format('d/m/Y')  }}</small>
                                <h6>Người đăng: {{ $post->author }}</h6>
                            </div>
                            <div class="inner-text">
                                <p class="text mb-0">
                                    @php
                                        $content = $post->content ?? '';
                                        // Loại bỏ khoảng trắng không cần thiết
                                        $clearBreakLineArrStr = \Illuminate\Support\Str::replace('&nbsp;', '', $content);
                                        // Loại bỏ thẻ <img>
                                        $clearImgArrStr = preg_replace('/<img[^>]*>/', '', $clearBreakLineArrStr);
                                        // Loại bỏ toàn bộ các thẻ HTML để xử lý dễ hơn
                                        $plainTextContent = strip_tags($clearImgArrStr, '<br>');
                                        // Tách nội dung theo thẻ <br> hoặc dấu xuống dòng
                                        $lines = preg_split('/<br\s*\/?>|\n/', trim($plainTextContent));
                                    @endphp

                                    @foreach ($lines as $key => $line)
                                        @if (!empty(trim($line)))
                                            {!! $line !!}
                                            @if ($key === 1)
                                                @break
                                            @endif
                                        @endif
                                    @endforeach
                                </p>
                            </div>
                        </div>
                    @endforeach

                    
                    <!-- Pagination -->
                    <nav aria-label="Page navigation" class="mt-3" style="margin: 0 auto;">
                        <ul class="pagination justify-content-center mb-0">
                            <!-- Previous Page Link -->
                            @if ($posts->onFirstPage())
                                <li class="page-item disabled">
                                    <a class="page-link" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $posts->previousPageUrl() }}" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                            @endif

                            <!-- Pagination Elements -->
                            @for ($i = 1; $i <= $posts->lastPage(); $i++)
                                @if ($i == $posts->currentPage())
                                    <li class="page-item active">
                                        <a class="page-link">{{ $i }}</a>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $posts->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endif
                            @endfor

                            <!-- Next Page Link -->
                            @if ($posts->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $posts->nextPageUrl() }}" aria-label="Next">
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
