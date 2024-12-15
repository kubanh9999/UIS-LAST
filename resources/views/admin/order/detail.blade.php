@extends('admin.layout')
@section('content')
<style>
    .page-wrapper {
        background-color: #f9f9f9;
        padding: 20px;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        background: #fff;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
        padding: 20px;
    }

    .section-title {
        font-size: 18px;
        font-weight: bold;
        color: #444;
        margin-bottom: 10px;
        border-bottom: 2px solid #eee;
        padding-bottom: 5px;
    }

    .card {
        background: #fafafa;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .card img {
        border-radius: 4px;
        width: 50px;
        height: auto;
        margin-right: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .product-list ul {
        list-style-type: none;
        padding-left: 0;
    }

    .product-list ul li {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .table-summary {
        width: 100%;
        border-collapse: collapse;
    }

    .table-summary td {
        padding: 10px 15px;
    }

    .table-summary td:first-child {
        font-weight: bold;
        width: 50%;
        color: #555;
    }

    .table-summary td:last-child {
        text-align: right;
        color: #333;
    }

    .total-row {
        font-size: 16px;
        font-weight: bold;
        border-top: 2px solid #eee;
        padding-top: 10px;
    }

    .status {
        font-weight: bold;
        padding: 5px 10px;
        border-radius: 4px;
        display: inline-block;
    }

    .status-danger {
        background-color: #ffe2e6;
        color: #d32f2f;
    }

    .status-warning {
        background-color: #fff4e5;
        color: #ff9800;
    }

    .status-primary {
        background-color: #e3f2fd;
        color: #1976d2;
    }

    .status-success {
        background-color: #e8f5e9;
        color: #388e3c;
    }

    .status-secondary {
        background-color: #eeeeee;
        color: #616161;
    }
    .back{
        float: right;
    }
</style>
<br><br><br>

<div class="page-wrapper">
    <div class="container">
        <div class="order-details">
            <!-- Thông tin chung -->
           <a class="back" href="{{route('admin.orders.index')}}">Quay lại</a>
           <br><br>
            <div class="card">
            <h3 class="section-title">Thông tin đơn hàng</h3>
                <table class="table-summary">
                    <tr>
                        <td>Mã đơn hàng:</td>
                        <td>{{ $order->token }}</td>
                    </tr>
                    <tr>
                        <td>Người mua:</td>
                        <td>{{ $order->user ? $order->user->name : 'Khách vãng lai' }}</td>
                    </tr>
                    <tr>
                        <td>Số điện thoại:</td>
                        <td>{{ $order->phone }}</td>
                    </tr>
                    <tr>
                        <td>Địa chỉ:</td>
                        <td> {{ $order->province->name  }}
                            {{ $order->district->name  }}, 
                            {{ $order->ward->name  }}, 
                            {{ $order->street }}, </td>
                    </tr>
                    <tr>
                        <td>Trạng thái:</td>
                        <td>
                            @if ($order->status == -1)
                                <span class="status status-danger">Đã hủy</span>
                            @elseif ($order->status == 0)
                                <span class="status status-warning">Đang xử lý</span>
                            @elseif ($order->status == 1)
                                <span class="status status-primary">Đang vận chuyển</span>
                            @elseif ($order->status == 2)
                                <span class="status status-success">Đã giao</span>
                            @else
                                <span class="status status-secondary">Chưa xác định</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>

            <!-- Sản phẩm bình thường -->
            <h3 class="section-title">Sản phẩm</h3>
            <div class="card">
                @foreach ($order->orderDetails as $item)
                    @if ($item->product_id && !$item->gift_id)
                        <div class="product-list">
                            <ul>
                                <li>
                                    @php
                                        $imagePath = $item->product->image;
                                        if (strpos($imagePath, 'uploads/products') === false) {
                                            $imagePath = 'layouts/img/' . $item->product->image; // Nếu không chứa, thêm 'layouts/img'
                                        }
                                    @endphp
                                    <img src="{{ asset($imagePath) }}">
                                    <span>{{ $item->product->name }} | x {{ $item->quantity }}</span>
                                </li>
                            </ul>
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Giỏ quà -->
            @php
            $hasGift = $order->orderDetails->contains('gift_id', '!=', null);
            @endphp

            @if ($hasGift)
                <h3 class="section-title">Giỏ quà</h3>
                @php $displayedGiftIds = []; @endphp
                @foreach ($order->orderDetails as $item)
                    @if ($item->gift_id && !in_array($item->gift_id, $displayedGiftIds))
                        <div class="card">
                            <strong></strong> {{ $item->gift->name }} | Số lượng: x {{ $item->quantity }}
                            <br>
                                @php
                                    $imagePath = $item->gift->image;
                                    if (strpos($imagePath, 'uploads/products') === false) {
                                        $imagePath = 'layouts/img/' . $item->gift->image; // Nếu không chứa, thêm 'layouts/img'
                                    }
                                @endphp
                            <img src="{{ asset($imagePath) }}" alt="Hình ảnh giỏ quà" style="width: 100px;">
                            <br>
                            <div class="product-list">
                                @php
                                    $giftItems = $order->orderDetails->where('gift_id', $item->gift_id);
                                    $isCustomGift = $giftItems->contains('product_id', '!=', null);
                                @endphp

                                <!-- Kiểm tra giỏ quà trống -->
                                @if (!$isCustomGift)
                                    <p><em></em></p>
                                @else
                                    <strong>Sản phẩm trong giỏ quà:</strong>
                                    <br>
                                    <br>
                                    <ul>
                                        @foreach ($giftItems as $giftItem)
                                            @if ($giftItem->product)
                                                <li>
                                                    @php
                                                        $imagePath = $giftItem->product->image;
                                                        if (strpos($imagePath, 'uploads/products') === false) {
                                                            $imagePath = 'layouts/img/' . $giftItem->product->image; // Nếu không chứa, thêm 'layouts/img'
                                                        }
                                                    @endphp
                                                    <img src="{{ asset($imagePath) }}" 
                                                        alt="{{ $giftItem->product->name }}" style="width: 40px;">
                                                    <span>{{ $giftItem->product->name }} x {{ $giftItem->quantity }}kg</span>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                        @php $displayedGiftIds[] = $item->gift_id; @endphp
                    @endif
                @endforeach
            @endif



            <!-- Tổng kết -->
            <h3 class="section-title">Tổng kết</h3>
            <div class="card">
                <table class="table-summary">
                    <tr>
                        <td>Tổng tiền hàng:</td>
                        <td>{{ number_format($order->total_amount - 30000) }} VNĐ</td>
                    </tr>
                    <tr>
                        <td>Phí vận chuyển:</td>
                        <td>30,000 VNĐ</td>
                    </tr>
                    <tr class="total-row">
                        <td>Tổng cộng:</td>
                        <td>{{ number_format($order->total_amount) }} VNĐ</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
