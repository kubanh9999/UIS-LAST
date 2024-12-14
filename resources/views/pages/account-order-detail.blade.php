@extends('layouts.master')
@section('title', 'Quản lý tài khoản')
@section('content')

    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="#">Quản lý tài khoản</a></li>
                <li class="breadcrumb-item active" aria-current="page">Chi tiết đơn hàng</li>
            </ol>
        </nav>
    </div>

    <section class="section-order-detail mb-2">
        <div class="container">
            <div class="swapper">
                <div class="order-details">
                    <div class="inner-head">
                        <h3>Hóa đơn</h3>
                        <div class="print">
                            <button onclick="printOrderDetails()">
                                <i class="fa-solid fa-print"></i>
                            </button>
                        </div>
                    </div>
                    <table class="inner-content">
                        <tbody>
                            <tr>
                                <th>Mã đơn hàng:</th>
                                <td>{{ $orders->token }}</td>
                            </tr>

                            <tr>
                                <th>Tên người mua:</th>
                                <td>{{ $orders->user ? $orders->user->name : 'Chưa có người dùng' }}</td>
                            </tr>
                            <tr>
                                <th>Số điện thoại:</th>
                                <td>{{ $orders->phone }}</td>
                            </tr>
                            <tr>
                                <th>Địa chỉ:</th>
                                <td>
                                    {{ $orders->street }},
                                    {{ $orders->ward->name }},
                                    {{ $orders->district->name }},
                                    {{ $orders->province->name }}
                                </td>
                            </tr>
                            <tr>
                                <th>Thanh toán:</th>
                                <td>{{ $orders->payment_method }}</td>
                            </tr>
                            <tr>
                                <th>Ngày đặt:</th>
                                <td>{{ \Carbon\Carbon::parse($orders->order_date)->timezone('Asia/Ho_Chi_Minh')->format('H:i:s - d/m/Y') }}
                                </td>
                            </tr>

                            @php $displayedGiftIds = []; @endphp
                            @foreach ($orders->orderDetails as $item)
                                @if ($item->gift_id && $item->product_id && !in_array($item->gift_id, $displayedGiftIds))
                                    <tr>
                                        <th>Tên sản phẩm:</th>
                                        <td>{{ $item->gift->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Hình ảnh:</th>
                                        <td>
                                            @if ($item->gift && $item->gift->image)
                                                @php
                                                    $imagePath = $item->gift->image;
                                                    if (strpos($imagePath, 'uploads/products') === false) {
                                                        $imagePath = 'layouts/img/' . $item->gift->image; // Nếu không chứa, thêm 'layouts/img'
                                                    }
                                                @endphp
                                                <img src="{{ asset($imagePath) }}" class="img-thumbnail"
                                                    style="width: 50px; height: 50px;">
                                            @else
                                                <span>Hình ảnh không có sẵn</span>
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Sản phẩm trong quà tặng:</th>
                                        <td colspan="4">
                                            <ul style="list-style: none; padding: 0;">
                                                @php $customGiftTotal = 0; @endphp
                                                @foreach ($orders->orderDetails->where('gift_id', $item->gift_id) as $giftItem)
                                                    @if ($giftItem->product)
                                                        <li>
                                                            @php
                                                                $imagePath = $giftItem->product->image;
                                                                if (strpos($imagePath, 'uploads/products') === false) {
                                                                    $imagePath =
                                                                        'layouts/img/' . $giftItem->product->image; // Nếu không chứa, thêm 'layouts/img'
                                                                }
                                                            @endphp
                                                            <img style="width: 40px;" src="{{ asset($imagePath) }}"
                                                                alt="">
                                                            {{ $giftItem->product->name }} x
                                                            {{ $giftItem->quantity . 'kg' }}
                                                            @php $customGiftTotal += $giftItem->price * $giftItem->quantity; @endphp
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </td>
                                    </tr>
                                    @php $displayedGiftIds[] = $item->gift_id; @endphp
                                @elseif ($item->gift_id && !$item->product_id)
                                    <tr>
                                        <th>Tên sản phẩm:</th>
                                        <td>{{ $item->gift->name }}</td>
                                    </tr>

                                    <tr>
                                        <th>Hình ảnh:</th>
                                        @php
                                            $imagePath = $item->gift->image;
                                            // Nếu đường dẫn ảnh chứa 'uploads/products', không cần thêm 'layouts/img'
                                            if (strpos($imagePath, 'uploads/products') === false) {
                                                $imagePath = 'layouts/img/' . $item->gift->image; // Nếu không chứa, thêm 'layouts/img'
                                            }
                                        @endphp
                                        <td><img src="{{ asset($imagePath) }}" class="img-thumbnail" style="width: 50px">
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Số lượng</th>
                                        <td>{{ $item->quantity }}</td>
                                    </tr>
                                @elseif ($item->product_id && !$item->gift_id)
                                    <tr>
                                        <th>Tên sản phẩm</th>
                                        <td>{{ $item->product->name }}</td>
                                    </tr>

                                    <tr>
                                        <th>Hình ảnh: </th>
                                        @php
                                            $imagePath = $item->product->image;
                                            // Nếu đường dẫn ảnh chứa 'uploads/products', không cần thêm 'layouts/img'
                                            if (strpos($imagePath, 'uploads/products') === false) {
                                                $imagePath = 'layouts/img/' . $item->product->image; // Nếu không chứa, thêm 'layouts/img'
                                            }
                                        @endphp
                                        <td>
                                            <img src="{{ asset($imagePath) }}" class="img-thumbnail" style="width: 50px;">
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Số lượng:</th>
                                        <td>{{ $item->quantity }}</td>
                                    </tr>
                                @endif
                            @endforeach
                            <tr>
                                <th>Phí vận chuyển</th>
                                <td>0đ</td>
                            </tr>
                            <tr>
                                <th>Tổng giá đơn hàng:</th>
                                <td >
                                    <strong>{{ number_format($orders->total_amount, 0, ',', '.') }}đ</strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <a href="/account/management" class="order-details-back-button mt-4">Quay lại danh sách đơn hàng</a>
                </div>
            </div>
        </div>
    </section>
    
    <script type="text/javascript">
        function printOrderDetails() {
            // Ẩn tất cả nội dung khác ngoại trừ chi tiết đơn hàng
            var content = document.querySelector('.order-details').outerHTML; // Chọn div chứa chi tiết đơn hàng
            var originalContent = document.body.innerHTML; // Lưu lại nội dung gốc của trang

            document.body.innerHTML = content; // Thay thế nội dung trang bằng chi tiết đơn hàng
            window.print(); // In trang hiện tại (bây giờ chỉ có chi tiết đơn hàng)
            document.body.innerHTML = originalContent; // Khôi phục lại nội dung gốc sau khi in
        }
    </script>
@endsection
