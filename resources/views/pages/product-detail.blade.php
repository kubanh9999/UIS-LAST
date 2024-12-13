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
                <li class="breadcrumb-item active" aria-current="page">{{ $product_detail->name }}</li>
            </ol>
        </nav>
    </div>

    <section class="section-product-detail">
        <div class="container">
            <div class="swapper">
                <div class="inner-section">
                    <div class="inner-left">
                        @php
                            $imagePath = public_path($product_detail->image);
                        @endphp

                        @if (file_exists($imagePath))
                            <img src="{{ asset($product_detail->image) }}" alt="Ảnh sản phẩm">
                        @else
                            <img src="{{ asset('layouts/img/' . $product_detail->image) }}" alt="Ảnh sản phẩm">
                        @endif
                    </div>
                    <div class="inner-right">
                        <form action="{{ route('cart.add', ['id' => $product_detail->id]) }}" method="post">
                            @csrf
                            <h3>{{ $product_detail->name }}</h3>
                            <ul class="status">
                                <li><b>Sku:</b>
                                    <span>{{ $sku }}</span>
                                </li>
                                <li><b>Tình trạng:</b>
                                    <span>
                                        @if ($product_detail->stock > 0)
                                            <span style="color: green;">Còn {{ number_format($product_detail->stock, 1) }}
                                                kg</span>
                                        @else
                                            <span style="color: red;">Hết hàng</span>
                                        @endif
                                    </span>
                                </li>
                            </ul>
                            <p class="price">{{ number_format($product_detail->price, 0) }}đ</p>

                            <div class="quantity">
                                <b>Số lượng:</b>
                                <input type="number" name="quantity-display" id="quantity" value="1" min="1"
                                    class="quantity-input-sl">
                                <input type="hidden" id="quantity-hidden" name="quantity" value="1">
                                <input type="hidden" name="product_detail[id]" value="{{ $product_detail->id }}">
                                <input type="hidden" name="product_detail[name]" value="{{ $product_detail->name }}">
                                <input type="hidden" name="product_detail[image]" value="{{ $product_detail->image }}">
                                <input type="hidden" name="product_detail[price_gift]"
                                    value="{{ $product_detail->price_gift }}">
                            </div>

                            <div class="purchase-options">
                                @if ($product_detail->stock <= 0)
                                    <button disabled type="submit" name="action" class="btn-buy-now">
                                        <span>Mua Ngay</span>
                                        <p>Giao hàng tận tay quý khách</p>
                                    </button>
                                    <button disabled type="submit" name="action" class="btn-add-cart">
                                        <span>Cho vào giỏ</span>
                                        <p>Thêm vào giỏ để chọn tiếp</p>
                                    </button>
                                @else
                                    <button type="submit" name="action" class="btn-buy-now">
                                        <span>Mua Ngay</span>
                                        <p>Giao hàng tận tay quý khách</p>
                                    </button>
                                    <button type="submit" name="action" class="btn-add-cart">
                                        <span>Cho vào giỏ</span>
                                        <p>Thêm vào giỏ để chọn tiếp</p>
                                    </button>
                                @endif
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
                        <p id="text-content">{{ html_entity_decode(strip_tags($product_detail->description)) }}</p>
                        <button class="toggle">Xem thêm</button>
                    </div>
                    <div id="comment" class="comment-section tab-pane fade"><br>
                        @if ($approvedComments && count($approvedComments) > 0)
                            @foreach ($approvedComments as $cmt)
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
                            <form action="{{ route('product.comment', $product_detail->id) }}" method="post">
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

    <section class="section-product-related">
        <div class="container">
            <div class="inner-related">
                <h3>Sản phẩm tương tự</h3>
                <div class="inner-content slick-related">
                    @foreach ($relatedProducts as $relatedProduct)
                        <div class="inner-box">
                            <a href="{{ route('product.detail', $relatedProduct->id) }}">
                                @php
                                    $imagePath = $relatedProduct->image;
                                    // Nếu đường dẫn ảnh chứa 'uploads/products', không cần thêm 'layouts/img'
                                    if (strpos($imagePath, 'uploads/products') === false) {
                                        $imagePath = 'layouts/img/' . $relatedProduct->image; // Nếu không chứa, thêm 'layouts/img'
                                    }
                                @endphp
                                <img src="{{ asset($imagePath) }}" alt="{{ $relatedProduct->name }}">
                            </a>
                            <h5><a
                                    href="{{ route('product.detail', $relatedProduct->id) }}">{{ $relatedProduct->name }}</a>
                            </h5>
                            <div class="inner-foot">
                                <p class="price">{{ number_format($relatedProduct->price) }}đ</p>
                                <form action="{{ route('cart.add', ['id' => $relatedProduct->id]) }}" method="post"
                                    style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="product[id]" value="{{ $relatedProduct->id }}">
                                    <input type="hidden" name="product[name]" value="{{ $relatedProduct->name }}">
                                    <input type="hidden" name="product[image]" value="{{ $relatedProduct->image }}">
                                    <input type="hidden" name="product[price]" value="{{ $relatedProduct->price }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <a href="#" onclick="this.closest('form').submit();" class="btn-cart">Thêm giỏ
                                        hàng
                                    </a>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const quantityDisplay = document.getElementById('quantity');
            const quantityHidden = document.getElementById('quantity-hidden');

            // Cập nhật giá trị khi người dùng nhập số lượng
            const updateQuantity = () => {
                let currentQuantity = parseInt(quantityDisplay.value);
                if (currentQuantity < 1) {
                    quantityDisplay.value = 1; // Đảm bảo số lượng không nhỏ hơn 1
                    currentQuantity = 1;
                }
                quantityHidden.value = currentQuantity; // Cập nhật input ẩn
                console.log("Cập nhật số lượng: ", currentQuantity);
            };

            // Lắng nghe sự kiện thay đổi trên input
            quantityDisplay.addEventListener("input", updateQuantity);
        });

        // Xử lý ẩn hiện các câu trả lời
        document.querySelectorAll('.btn-toggle-replies').forEach(button => {
            button.addEventListener('click', (event) => {
                const replyList = button.nextElementSibling;
                replyList.style.display = replyList.style.display === 'none' ? 'block' : 'none';
                button.textContent = replyList.style.display === 'block' ? 'Ẩn các câu trả lời' :
                    `Xem ${replyList.children.length} câu trả lời`;
            });
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

        function decreaseQuantity() {
            var quantityInput = document.getElementById('quantity');
            var currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
                document.getElementById('quantity-hidden').value = quantityInput.value; // Cập nhật giá trị ẩn
            }
        }

        function increaseQuantity() {
            var quantityInput = document.getElementById('quantity');
            var currentValue = parseInt(quantityInput.value);
            quantityInput.value = currentValue + 1;
            document.getElementById('quantity-hidden').value = quantityInput.value; // Cập nhật giá trị ẩn
        }

        // Cập nhật giá trị ẩn khi người dùng thay đổi số lượng
        document.getElementById('quantity').addEventListener('input', function() {
            var newValue = parseInt(this.value);

            // Kiểm tra nếu giá trị là số và lớn hơn hoặc bằng 1
            if (!isNaN(newValue) && newValue >= 1) {
                document.getElementById('quantity-hidden').value = newValue; // Cập nhật giá trị ẩn
            } else {
                this.value = 1; // Đặt lại về 1 nếu giá trị không hợp lệ
                document.getElementById('quantity-hidden').value = 1; // Cập nhật giá trị ẩn
                alert("Số lượng không hợp lệ. Đặt lại thành 1."); // Thông báo người dùng
            }
        });

        // Hàm cập nhật giá trị vào trường ẩn quantity-hidden-purchase
        function updateQuantity() {
            var quantity = document.getElementById('quantity').value;

            // Kiểm tra nếu quantity là số và lớn hơn 0
            if (!isNaN(quantity) && quantity > 0) {
                document.getElementById('quantity-hidden-purchase').value = quantity;
            } else {
                document.getElementById('quantity-hidden-purchase').value = 1; // Đảm bảo không có giá trị không hợp lệ
            }
        }

        // Gắn sự kiện cập nhật số lượng khi người dùng thay đổi
        document.getElementById('quantity').addEventListener('change', updateQuantity);

        const toggleBtn = document.querySelector('.toggle');
        const textContent = document.querySelector('#text-content');

        // Kiểm tra nếu phần mô tả dài hơn giới hạn ban đầu
        if (textContent.scrollHeight > textContent.clientHeight) {
            toggleBtn.style.display = 'block'; // Hiển thị nút "Xem thêm" nếu nội dung dài
        }

        toggleBtn.addEventListener('click', function() {
            textContent.classList.toggle('expanded');
            if (textContent.classList.contains('expanded')) {
                toggleBtn.textContent = 'Thu gọn';
            } else {
                toggleBtn.textContent = 'Xem thêm';
            }
        });
    </script>

@endsection
