@extends('layouts.master')
@section('title', 'Chi tiết sản phẩm')

@section('content')


    {{-- Hiển thị thông báo thành công --}}
    @if (session('success'))
        <script>
            toastr.success('{{ session('success') }}');
        </script>
    @endif

    {{-- Hiển thị thông báo lỗi nếu có --}}
    @if (session('error'))
        <script>
            toastr.error('{{ session('error') }}');
        </script>
    @endif

    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Sản phẩm</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $basket->name }}</li>
            </ol>
        </nav>
    </div>

    <section class="section-product-detail">
        <div class="container">
            <div class="swapper">
                <div class="inner-section">
                    <div class="inner-left">
                        @php
                            $imagePath = $basket->image;
                            if (strpos($imagePath, 'uploads/products') === false) {
                                $imagePath = 'layouts/img/' . $basket->image; // Nếu không chứa, thêm 'layouts/img'
                            }
                        @endphp
                        <img src="{{ asset($imagePath) }}" alt="{{ $basket->name }}">
                    </div>
                    <div class="inner-right">
                        <form action="{{ route('cart.add', ['id' => $basket->id]) }}" method="post">
                            @csrf
                            <h3>{{ $basket->name }}</h3>
                            <ul class="status">
                                <li><b>Sku:</b>
                                    <span>{{ $sku }}</span>
                                </li>
                                <li><b>Tình trạng:</b>
                                    <span style="color: green;">Còn: {{ $basket->stock }} sản phẩm</span>
                                </li>
                            </ul>
                            <p class="price">{{ number_format($basket->price_gift, 0) }}đ</p>

                            <div class="quantity">
                                <b>Số lượng:</b>
                                <input type="number" name="quantity-display" id="quantity" value="1" readonly>
                                <input type="hidden" id="quantity-hidden" name="quantity" value="1">
                                <input type="hidden" name="basket[id]" value="{{ $basket->id }}">
                                <input type="hidden" name="basket[name]" value="{{ $basket->name }}">
                                <input type="hidden" name="basket[image]" value="{{ $basket->image }}">
                                <input type="hidden" name="basket[price_gift]" value="{{ $basket->price_gift }}">
                            </div>

                            <div class="custom-gift-btn">
                                <a href="{{ route('basket.selectFruits', $basket->id) }}">Tùy chọn giỏ quà</a>
                            </div>

                            <div class="purchase-options">
                                <button type="submit" name="action" class="btn-buy-now">
                                    <span>Mua Ngay</span>
                                    <p>Giao hàng tận tay quý khách</p>
                                </button>
                                <button type="submit" name="action" class="btn-add-cart">
                                    <span>Cho vào giỏ</span>
                                    <p>Thêm vào giỏ để chọn tiếp</p>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <ul class="nav nav-tabs mt-3" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#description">Mô tả sản
                            phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#comment">Đánh giá sản phẩm</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div id="description" class="text-container tab-pane active">
                        <p id="text-content">{!! $basket->description !!}</p>
                        <button class="toggle">Xem thêm</button>
                    </div>
                    <div id="comment" class="comment-section tab-pane fade"><br>
                        @if ($comments && count($comments) > 0)
                            @foreach ($comments as $cmt)
                                {{-- Chỉ hiển thị bình luận đã được duyệt hoặc của chính người dùng hiện tại --}}
                                @if ($cmt->status == 1 || $cmt->user_id == Auth::id())
                                    <div class="comment-box card mb-3 p-3">
                                        <div class="d-flex justify-content-between">
                                            <span class="comment-user font-weight-bold">{{ $cmt->user->name }}</span>
                                            <span
                                                class="comment-time text-muted">{{ $cmt->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="mb-0" @disabled($cmt->status != 1)>{{ $cmt->content }}</p>
                                        @if ($cmt->status != 1)
                                            <p class="text-muted">Bình luận đang được duyệt</p>
                                        @endif
                                        <div class="d-flex justify-content-end">
                                            @if (Auth::check())
                                                <button class="btn btn-link btn-like" data-id="{{ $cmt->id }}"
                                                    @disabled($cmt->status != 1)>Thích ({{ $cmt->likes }})</button>
                                                <button class="btn btn-link btn-reply" data-id="{{ $cmt->id }}"
                                                    @disabled($cmt->status != 1)>Trả lời</button>
                                            @endif
                                            @if ($cmt->user_id === Auth::id())
                                                <button class="btn btn-link text-danger btn-delete"
                                                    data-id="{{ $cmt->id }}" @disabled($cmt->status != 1)>Xóa</button>
                                            @endif
                                        </div>

                                        <!-- Form trả lời -->
                                        <div class="reply-form mt-2" style="display: none;">
                                            <textarea class="form-control mb-2" placeholder="Nhập câu trả lời của bạn" rows="2" @disabled($cmt->status != 1)></textarea>
                                            <button class="btn btn-primary btn-submit-reply" data-id="{{ $cmt->id }}"
                                                @disabled($cmt->status != 1)>Gửi</button>
                                        </div>

                                        <!-- Các câu trả lời -->
                                        <div class="replies mt-3">
                                            @if ($cmt->replies->isEmpty())
                                                <p class="text-muted">Chưa có câu trả lời nào.</p>
                                            @else
                                                <button class="btn btn-link btn-toggle-replies">Xem
                                                    {{ count($cmt->replies) }} câu trả lời</button>
                                                <div class="reply-list" style="display: none;">
                                                    @foreach ($cmt->replies as $reply)
                                                        {{-- Chỉ hiển thị trả lời đã được duyệt hoặc của chính người dùng hiện tại --}}
                                                        @if ($reply->status == 1 || $reply->user_id == Auth::id())
                                                            <div class="reply-box card mb-2 p-2">
                                                                <div class="d-flex justify-content-between">
                                                                    <span
                                                                        class="reply-user font-weight-bold">{{ $reply->user->name }}</span>
                                                                    <span
                                                                        class="reply-time text-muted">{{ $reply->created_at->diffForHumans() }}</span>
                                                                </div>
                                                                <p class="mb-0" @disabled($reply->status != 1)>
                                                                    {{ $reply->content }}</p>
                                                                @if ($reply->status != 1)
                                                                    <p class="text-muted">Bình luận đang được duyệt</p>
                                                                @endif
                                                                <div class="d-flex justify-content-end">
                                                                    @if (Auth::check())
                                                                        <button class="btn btn-link btn-like"
                                                                            data-id="{{ $reply->id }}"
                                                                            @disabled($reply->status != 1)>Thích
                                                                            ({{ $reply->likes }})
                                                                        </button>
                                                                        <button class="btn btn-link btn-reply"
                                                                            data-id="{{ $cmt->id }}"
                                                                            @disabled($reply->status != 1)>Trả
                                                                            lời</button>
                                                                    @endif
                                                                    @if ($reply->user_id === Auth::id())
                                                                        <button class="btn btn-link text-danger btn-delete"
                                                                            data-id="{{ $reply->id }}"
                                                                            @disabled($reply->status != 1)>Xóa</button>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @else
                            <p class="text-muted">Chưa có bình luận nào.</p>
                        @endif

                        <!-- Box thêm bình luận mới -->
                        <div class="comment-form mt-3">
                            <form action="{{ route('product.comment', $basket->id) }}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label for="commentText" class="form-label">Nội dung đánh giá</label>
                                    <textarea class="form-control" id="commentText" name="content" rows="4" placeholder="Nhập ý kiến của bạn"></textarea>
                                </div>
                                <button type="submit" class="btn-submit-comment ">Gửi đánh giá</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Lấy các phần tử nút và input
            const decreaseBtn = document.getElementById('decrease-btn');
            const increaseBtn = document.getElementById('increase-btn');
            const quantityDisplay = document.getElementById('quantity');
            const quantityHidden = document.getElementById('quantity-hidden');

            // Hàm giảm số lượng
            const decreaseQuantity = () => {
                let currentQuantity = parseInt(quantityDisplay.value);
                if (currentQuantity > 1) {
                    currentQuantity--;
                    quantityDisplay.value = currentQuantity;
                    quantityHidden.value = currentQuantity; // Cập nhật input ẩn
                }
                console.log("Giảm số lượng: ", currentQuantity);
            };

            // Hàm tăng số lượng
            const increaseQuantity = () => {
                let currentQuantity = parseInt(quantityDisplay.value);
                currentQuantity++;
                quantityDisplay.value = currentQuantity;
                quantityHidden.value = currentQuantity; // Cập nhật input ẩn
                console.log("Tăng số lượng: ", currentQuantity);
            };

            // Gắn sự kiện cho các nút
            decreaseBtn.addEventListener("click", decreaseQuantity);
            increaseBtn.addEventListener("click", increaseQuantity);
        });

        // Thay đổi trong xử lý trả lời bình luận
        document.querySelectorAll('.btn-reply').forEach(button => {
            button.addEventListener('click', (event) => {
                event.preventDefault();

                const commentBox = button.closest('.comment-box');
                const replyForm = commentBox.querySelector('.reply-form');

                // Hiện/ẩn form trả lời
                replyForm.style.display = replyForm.style.display === 'none' ? 'block' : 'none';

                const replyInput = replyForm.querySelector('textarea');
                replyInput.focus(); // Đặt focus vào textarea
            });
        });

        // Thay đổi trong xử lý lượt thích
        document.querySelectorAll('.btn-like').forEach(button => {
            button.addEventListener('click', (event) => {
                event.preventDefault();
                const commentId = button.getAttribute('data-id');
                const isLiked = button.classList.contains('liked'); // Kiểm tra nếu đã thích

                const form = document.createElement('form');
                form.method = 'POST';

                // Nếu đã thích, gửi yêu cầu bỏ thích, ngược lại gửi yêu cầu thích
                form.action = isLiked ? `/comments/${commentId}/unlike` : `/comments/${commentId}/like`;

                form.innerHTML = `
            <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
        `;
                document.body.appendChild(form);
                form.submit();

                // Cập nhật trạng thái thích
                button.classList.toggle('liked', !isLiked); // Thay đổi class liked
            });
        });

        // Phần xử lý gửi trả lời
        document.querySelectorAll('.btn-submit-reply').forEach(button => {
            button.addEventListener('click', (event) => {
                event.preventDefault();
                const commentId = button.getAttribute('data-id');
                const replyContent = button.previousElementSibling.value;

                // Kiểm tra nếu nội dung trả lời không rỗng
                if (replyContent.trim() === '') {
                    alert('Nội dung trả lời không được để trống!');
                    return;
                }

                // Ngăn chặn nhiều lần gửi
                button.disabled = true;

                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/comments/${commentId}/reply`;
                form.innerHTML = `
            <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
            <textarea name="content" style="display:none;">${replyContent}</textarea>
        `;
                document.body.appendChild(form);
                form.submit();
            });
        });

        // Phần xử lý xóa bình luận
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', (event) => {
                event.preventDefault();
                const commentId = button.getAttribute('data-id');

                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/comments/${commentId}`;
                form.innerHTML = `
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
        `;
                document.body.appendChild(form);
                form.submit();
            });
        });

        document.querySelectorAll('.btn-like').forEach(button => {
            button.addEventListener('click', (event) => {
                event.preventDefault();
                const commentId = button.getAttribute('data-id');

                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/comments/${commentId}/like`;
                form.innerHTML = `
            <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
        `;
                document.body.appendChild(form);
                form.submit();
            });
        });

        document.querySelectorAll('.btn-submit-reply').forEach(button => {
            button.addEventListener('click', (event) => {
                event.preventDefault();
                const commentId = button.getAttribute('data-id');
                const replyContent = button.previousElementSibling.value;

                // Kiểm tra nếu nội dung trả lời không rỗng
                if (replyContent.trim() === '') {
                    alert('Nội dung trả lời không được để trống!');
                    return;
                }

                // Ngăn chặn nhiều lần gửi
                button.disabled = true;

                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/comments/${commentId}/reply`;
                form.innerHTML = `
            <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
            <textarea name="content" style="display:none;">${replyContent}</textarea>
        `;
                document.body.appendChild(form);
                form.submit();
            });
        });


        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', (event) => {
                event.preventDefault();
                const commentId = button.getAttribute('data-id');

                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/comments/${commentId}`;
                form.innerHTML = `
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
        `;
                document.body.appendChild(form);
                form.submit();
            });
        });
    </script>

@endsection
