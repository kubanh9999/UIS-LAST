@extends('layouts.master')
@section('title', 'Quản lý tài khoản')
@section('content')

    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('account.management')}}">Quản lý tài khoản</a></li>
                <li class="breadcrumb-item active" aria-current="page">Chi tiết đơn hàng</li>
            </ol>
        </nav>
    </div>

    <div class="section-order-detail">
        <div class="container">
            <div class="swapper">
                <div class="inner-header">
                    <div class="inner-left">
                        <h4 class="inner-shop">Cửa hàng kinh doanh trái cây Uis Fruits</h4>
                        <ul>
                            <li>Điện thoại: <span>0378966102</span></li>
                            <li>Địa chỉ:
                                <span> Công viên phần mềm Quang Trung, phường Tân Chánh Hiệp, 
                                     Quận 12, thành phố Hồ Chí Minh </span>
                            </li>
                        </ul>
                    </div>
                    <div class="inner-right">
                        <ul>
                            <li>Mã đơn hàng: <span>{{ $orders->token }}</span></li>
                            <li>Ngày:
                                <span>{{ \Carbon\Carbon::parse($orders->order_date)->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <h3 class="inner-hoadon">Hóa đơn</h3>

                <div class="inner-body">
                    <div class="inner-info-user">
                        <ul>
                            <li>Tên khách hàng:
                                <span>{{ $orders->user ? $orders->user->name : 'Chưa có người dùng' }}</span>
                            </li>
                            <li>Địa chỉ giao hàng:
                                <span>
                                    {{ $orders->street }},{{ $orders->ward->name }},{{ $orders->district->name }},{{ $orders->province->name }}</span>
                            </li>
                        </ul>
                        <ul>
                            <li>Điện thoại: {{ $orders->phone }}</li>
                            <li>Hình thức thanh toán:
                                <span> {{ $orders->payment_method }}</span>
                            </li>
                        </ul>
                    </div>

                    <div class="inner-product-detail">
                        <table>
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Sản phẩm</th>
                                    <th>Số lượng</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $stt = 1;
                                    $displayedGiftIds = []; // Khởi tạo danh sách gift_id đã hiển thị
                                @endphp

                                @foreach ($orders->orderDetails as $item)
                                    <tr>
                                        <!-- Điều kiện 1: Sản phẩm thuộc quà tặng và chưa hiển thị gift_id này -->
                                        @if ($item->gift_id && $item->product_id && !in_array($item->gift_id, $displayedGiftIds))
                                            <td>{{ $stt++ }}</td>
                                            <td>
                                                @if ($item->gift && $item->gift->image)
                                                    @php
                                                        $imagePath = $item->gift->image;
                                                        // Nếu đường dẫn không chứa "uploads/products", thêm "layouts/img/"
                                                        if (strpos($imagePath, 'uploads/products') === false) {
                                                            $imagePath = 'layouts/img/' . $item->gift->image;
                                                        }
                                                    @endphp
                                                    <img src="{{ asset($imagePath) }}" class="img-thumbnail"
                                                        style="width: 50px; height: 50px;">
                                                @else
                                                    <span>Hình ảnh không có sẵn</span>
                                                @endif

                                                <span class="ml-2">{{ $item->gift->name }}</span>
                                            </td>

                                            <td>
                                                <ul class="product-in-gift">
                                                    @php $customGiftTotal = 0; @endphp
                                                    @foreach ($orders->orderDetails->where('gift_id', $item->gift_id) as $giftItem)
                                                        @if ($giftItem->product)
                                                            <li>

                                                                @php
                                                                    $imagePath = $giftItem->product->image;
                                                                    if (
                                                                        strpos($imagePath, 'uploads/products') ===
                                                                        false
                                                                    ) {
                                                                        $imagePath =
                                                                            'layouts/img/' .
                                                                            $giftItem->product->image;
                                                                    }
                                                                @endphp
                                                                <img src="{{ asset($imagePath) }}" width="50px" height="50px">
                                                                
                                                                <div class="inner-gift-quantity-name">
                                                                    <p class="mb-0">x {{ $giftItem->quantity . 'kg' }}</p>
                                                                    <p class="mb-0">{{ $giftItem->product->name }}</p>
                                                                </div>

                                                                @php $customGiftTotal += $giftItem->price * $giftItem->quantity; @endphp
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </td>

                                            <td>{{ number_format($customGiftTotal, 0, ',', '.') }}đ</td>

                                            @php $displayedGiftIds[] = $item->gift_id; @endphp

                                            <!-- Điều kiện 2: Quà tặng không chứa sản phẩm -->
                                        @elseif ($item->gift_id && !$item->product_id)
                                            <td>{{ $stt++ }}</td>

                                            <td>
                                                @php
                                                    $imagePath = $item->gift->image;
                                                    if (strpos($imagePath, 'uploads/products') === false) {
                                                        $imagePath = 'layouts/img/' . $item->gift->image;
                                                    }
                                                @endphp
                                                <img src="{{ asset($imagePath) }}" class="img-thumbnail" width="50px">
                                                <span class="ml-2">{{ $item->gift->name }}</span>
                                            </td>

                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ number_format($item->price, 0, ',', '.') }}đ</td>

                                            <!-- Điều kiện 3: Sản phẩm không thuộc quà tặng -->
                                        @elseif ($item->product_id && !$item->gift_id)
                                            <td>{{ $stt++ }}</td>


                                            <td>
                                                @php
                                                    $imagePath = $item->product->image;
                                                    if (strpos($imagePath, 'uploads/products') === false) {
                                                        $imagePath = 'layouts/img/' . $item->product->image;
                                                    }
                                                @endphp
                                                <img src="{{ asset($imagePath) }}" class="img-thumbnail"
                                                    style="width: 50px;">

                                                <span class="ml-2">{{ $item->product->name }}</p>
                                            </td>

                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ number_format($item->price, 0, ',', '.') }}đ</td>

                                        @endif
                                    </tr>
                                @endforeach
                        
                                <tr class="total-hd">
                                    @if ($discount === null)
                                        <td colspan="4" class="text-end">
                                            <strong>Tổng cộng:</strong> {{ number_format($orders->total_amount, 0, ',', '.') }}đ
                                        </td>
                                    @else
                                        <td colspan="4" class="text-end">
                                            <div class="giamgia-order-detail" style="margin-right: 50px;">
                                                Giảm giá: {{ number_format($discount->discount_percent, 0, ',', '.') }}%
                                            </div>
                                            <br>
                                            <strong>Tổng cộng:</strong> {{ number_format($orders->total_amount, 0, ',', '.') }}đ
                                        </td>
                                    @endif
                                </tr>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="contai-btn">
                    <a href="{{ route('account.management')}}">Quay lại</a>
                    <button onclick="printOrderDetails()">
                        <i class="fa-solid fa-print"></i> In hóa đơn
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- <section class="section-order-detail mb-2">
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
                                <td>
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

    <section class="section-order-detail mb-5">
        <div class="container">
            <div class="card shadow p-4 bg-white rounded">
                <div class="container">
                    <div class="swapper shadow p-4 bg-white rounded">
                        <div class="inner-head left" style="float: right;"> <button onclick="printOrderDetails()"
                                class="btn" style="color: #74c26e;"> <i class="fa-solid fa-print me-2"></i> In hóa đơn
                            </button> </div>
                        <div class="clearfix"></div>
                        <div class="order-details">
                            <h3 class="fw-bold " style="color: #74c26e;text-align: center">HÓA ĐƠN</h3>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Mã đơn hàng:</strong> {{ $orders->token }}
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <strong>Ngày đặt:</strong>
                                    {{ \Carbon\Carbon::parse($orders->order_date)->format('H:i:s - d/m/Y') }}
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Tên người mua:</strong>
                                    {{ $orders->user ? $orders->user->name : 'Chưa có người dùng' }}
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <strong>Thanh toán:</strong> {{ $orders->payment_method }}
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Số điện thoại:</strong> {{ $orders->phone }}
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <strong>Phí vận chuyển:</strong> 0đ
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <strong>Địa chỉ:</strong>
                                    {{ $orders->street }},
                                    {{ $orders->ward->name }},
                                    {{ $orders->district->name }},
                                    {{ $orders->province->name }}
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <strong>Tổng giá đơn hàng:</strong>
                                    <h4 class="fw-bold text-danger">
                                        {{ number_format($orders->total_amount, 0, ',', '.') }}đ
                                    </h4>
                                </div>
                            </div>

                            <h5 class="fw-bold mb-3">Chi tiết sản phẩm</h5>
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">Sản phẩm</th>
                                        <th class="text-center">Số lượng</th>
                                        <th class="text-center">Giá</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders->orderDetails as $item)
                                        <tr>
                                            <td>
                                                @if ($item->gift_id && !$item->product_id)
                                                    <img src="{{ asset('uploads/products/' . $item->gift->image) }}"
                                                        alt="{{ $item->gift->name }}" class="img-thumbnail"
                                                        style="width: 60px;">
                                                    Quà tặng: <span class="fw-bold">{{ $item->gift->name }}</span>
                                                @elseif ($item->product_id)
                                                    <img src="{{ asset('uploads/products/' . $item->product->image) }}"
                                                        alt="{{ $item->product->name }}" class="img-thumbnail"
                                                        style="width: 60px;">
                                                    Sản phẩm: <span class="fw-bold">{{ $item->product->name }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center">{{ $item->quantity }} kg</td>
                                            <td class="text-center">{{ number_format($item->price, 0, ',', '.') }}đ</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>


                        </div>
                    </div>
                    <a href="/account/management" class="btn btn-dark mt-4">
                        <i class="fa-solid fa-arrow-left me-2"></i> Quay lại danh sách đơn hàng
                    </a>
                </div>

    </section> --}}

    <script type="text/javascript">
        function printOrderDetails() {
            // Ẩn tất cả nội dung khác ngoại trừ chi tiết đơn hàng
            var content = document.querySelector('.section-order-detail').outerHTML; // Chọn div chứa chi tiết đơn hàng
            var originalContent = document.body.innerHTML; // Lưu lại nội dung gốc của trang

            document.body.innerHTML = content; // Thay thế nội dung trang bằng chi tiết đơn hàng
            window.print(); // In trang hiện tại (bây giờ chỉ có chi tiết đơn hàng)
            document.body.innerHTML = originalContent; // Khôi phục lại nội dung gốc sau khi in
        }
    </script>
@endsection
