@extends('layouts.master')
@section('title', 'Chi tiết sản phẩm')
<style>
     /* Đặt màu cho thông báo lỗi */
     .toast-error {
        background-color: #f44336 !important; /* Màu đỏ */
        color: white !important;
    }
    
    /* Đặt màu cho thông báo thành công */
    .toast-success {
        background-color: #4CAF50 !important; /* Màu xanh */
        color: white !important;
    }

    /* Tùy chỉnh thêm cho kích thước và kiểu chữ của thông báo */
    .toast {
        font-size: 16px;
        border-radius: 8px;
    }
</style>
@section('content')

    <section class="breadcrumb">
        <div class="container">
            <ul class="breadcrumb-list mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Trang chủ</a></li>
                <li class="breadcrumb-separator">/</li>
                <li class="breadcrumb-item"><a href="#">Shop</a></li>
                <li class="breadcrumb-separator">/</li>
                <li class="breadcrumb-item"><a href="#">{{ $basket->name }}</a></li>
            </ul>
        </div>
    </section>

    <section class="product-detail mb-4">
        <div class="container bg-white p-4">
            @if (session('success'))
            <script>
                toastr.success('{{ session('success') }}');  // Hiển thị thông báo thành công
            </script>
        @endif
        
        @if (session('error'))
            <script>
                toastr.error('{{ session('error') }}');  // Hiển thị thông báo lỗi nếu có
            </script>
        @endif
            <div class="row">
                <!-- Product Image Section -->
                <div class="col-md-5">
                    <div class="product-images">
                        <div class="main-image">
                            @php
                                $imagePath = $basket->image;
                                if (strpos($imagePath, 'uploads/products') === false) {
                                    $imagePath = 'layouts/img/' . $basket->image; // Nếu không chứa, thêm 'layouts/img'
                                }
                            @endphp
                            <img src="{{ asset($imagePath) }}" alt="{{ $basket->name }}">
                        </div>
                    </div>
                </div>

                <!-- Product Details Section -->
                <div class="col-md-7">
                    <form action="{{ route('cart.add', ['id' => $basket->id]) }}" method="post" class="product-info">
                        <h2 class="product-title">{{ $basket->name }}</h2>
                        <ul class="product-status">
                            <li class="status">SKU: <span>I00000</span></li>
                            <li class="status">Danh mục: <span>Trái cây</span></li>
                            <li class="status">Tình trạng: <span>Còn: {{$basket->stock}} sản phẩm</span></li>
                        </ul>
                        <div class="product-price">
                            <div class="price">
                                {{ number_format($basket->price_gift, 0) }} VND
                            </div>
                        </div>

                        <div class="quantity-form" action="#">
                            <h4>Số lượng:</h4>
                            <div class="group-quantity">
                                <button type="button" id="decrease-btn" class="btn btn-success">-</button>
                                <input type="text" name="quantity-display" id="quantity" value="1" readonly>
                                <button type="button" id="increase-btn" class="btn btn-success">+</button>
                            </div>

                            @csrf
                            <input type="hidden" id="quantity-hidden" name="quantity" value="1">
                            <input type="hidden" name="basket[id]" value="{{ $basket->id }}">
                            <input type="hidden" name="basket[name]" value="{{ $basket->name }}">
                            <input type="hidden" name="basket[image]" value="{{ $basket->image }}">
                            <input type="hidden" name="basket[price_gift]" value="{{ $basket->price_gift }}">
                        </div>

                        <div class="custom-gift-btn">
                            <a href="{{ route('basket.selectFruits', $basket->id) }}">Tùy chọn giỏ quà</a>
                        </div>
                        <div class="purchase-options mt-2">
                            <button type="submit" name="action" value="buy_now" class="btn-buy-now">
                                <span><img src="img/i-muangay.svg" alt=""> Mua ngay</span>
                                <p class="mb-0">Giao hàng tận tay quý khách</p>
                            </button>
                            <button type="submit" name="action" value="add_to_cart" class="btn-add-to-cart">
                                <span>Cho vào giỏ</span>
                                <p class="mb-0">Thêm vào giỏ để chọn tiếp</p>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="product-detail-bottom mt-5 col-md-12">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#description">Mô tả sản
                                phẩm</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#comment">Đánh giá sản phẩm</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div id="description" class="text-container container tab-pane active">
                            <p id="text-content">{!! $basket->description !!}</p>
                            <button class="toggle">Xem thêm</button>
                        </div>
                        <div id="comment" class="comment-section container tab-pane fade"><br>
                            <h4 class="mb-3">Đánh giá sản phẩm</h4>
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
                                            <p class="mb-0">{{ $cmt->content }}</p>
                                            <div class="d-flex justify-content-end">
                                                @if (Auth::check())
                                                    <button class="btn btn-link btn-like"
                                                        data-id="{{ $cmt->id }}">Thích
                                                        ({{ $cmt->likes }})
                                                    </button>
                                                    <button class="btn btn-link btn-reply"
                                                        data-id="{{ $cmt->id }}">Trả lời</button>
                                                @endif
                                                @if ($cmt->user_id === Auth::id())
                                                    <button class="btn btn-link text-danger btn-delete"
                                                        data-id="{{ $cmt->id }}">Xóa</button>
                                                @endif
                                            </div>

                                            <!-- Form trả lời -->
                                            <div class="reply-form mt-2" style="display: none;">
                                                <textarea class="form-control mb-2" placeholder="Nhập câu trả lời của bạn" rows="2"></textarea>
                                                <button class="btn btn-primary btn-submit-reply"
                                                    data-id="{{ $cmt->id }}">Gửi</button>
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
                                                                    <p class="mb-0">{{ $reply->content }}</p>
                                                                    <div class="d-flex justify-content-end">
                                                                        @if (Auth::check())
                                                                            <button class="btn btn-link btn-like"
                                                                                data-id="{{ $reply->id }}">Thích
                                                                                ({{ $reply->likes }})
                                                                            </button>
                                                                            <button class="btn btn-link btn-reply"
                                                                                data-id="{{ $cmt->id }}">Trả
                                                                                lời</button>
                                                                        @endif
                                                                        @if ($reply->user_id === Auth::id())
                                                                            <button
                                                                                class="btn btn-link text-danger btn-delete"
                                                                                data-id="{{ $reply->id }}">Xóa</button>
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
                            <div class="comment-form mt-5">
                                <h4 class="mb-3">Để lại đánh giá của bạn</h4>
                                <form action="{{ route('product.comment', $basket->id) }}" method="post">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="commentText" class="form-label">Nội dung đánh giá</label>
                                        <textarea class="form-control" id="commentText" name="content" rows="4" placeholder="Nhập ý kiến của bạn"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
                                </form>
                            </div>
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
    </script>

    <script>
        // Hàm tăng số lượng

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
