@extends('layouts.master')
@section('title', 'Chi tiết bài viết')
@section('content')



    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('posts.index') }}">Tin tức</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $post->title }}</li>
            </ol>
        </nav>
    </div>

    <section class="section-post-detail">
        <div class="container">
            <div class="swapper">
                <div class="inner-left">
                    @if ($relatedPosts->count() > 0)
                        <div class="similar-posts">
                            <h3>Bài viết tương tự</h3>
                            <div class="relatedPosts">
                                @foreach ($relatedPosts as $relatedPosts)
                                    <a href="{{ route('post.show', $relatedPosts->id) }}">
                                        @php
                                            $imagePath = $relatedPosts->image;
                                            if (strpos($imagePath, 'uploads/posts') === false) {
                                                $imagePath = 'layouts/img/' . $imagePath;
                                            }
                                        @endphp
                                        <img src="{{ asset($imagePath) }}" alt="{{ $relatedPosts->title }}">
                                        <h4>{{ $relatedPosts->title }}</h4>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
                <div class="inner-right">
                    <h3 class="post-title">{{ $post->title }}</h3>
                    <div class="inner-media">
                        <h6>Người đăng: {{ $post->author }}</h6>
                        <small>Ngày đăng: {{ $post->created_at->format('d/m/Y') }}</small>
                    </div>

                    <div class="inner-text">
                        <p>
                            {!! $post->content !!}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
