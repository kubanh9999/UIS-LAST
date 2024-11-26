@extends('layouts.master')
@section('title', 'Quản lý tài khoản')
@section('content')
    <style>
        .order-details-container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 7px
        }

        .order-header {
            text-align: center;
            font-size: 22px;
            font-weight: 600;
            margin: 0;
            color: #333;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .order-info {
            margin-bottom: 20px;
        }

        .order-info div {
            margin-bottom: 10px;
        }

        .order-info span {
            font-weight: bold;
        }

        .order-items table {
            width: 100%;
            border-collapse: collapse;
        }

        .order-items th,
        .order-items td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        .order-items th {
            background-color: #f7f7f7;
        }

        .total {
            text-align: right;
            font-weight: bold;
            margin-top: 20px;
        }

        .vanchuyen {
            position: relative;
            text-align: right;
            margin-top: 20px;
        }

        .img-thumbnail {
            width: 50px;
        }

        .btn-fruits {
            background: #319f25;
            color: #fff;
        }
    </style>

    <div class="order-details-container">
        <h2 class="order-header">Chi Tiết Đơn Hàng</h2>

        <div class="order-info">
            <div><span>Đơn hàng:</span> DH{{ $orders->id }}</div>
            <div><span>Đặt hàng ngày:</span> {{ \Carbon\Carbon::parse($orders->order_date)->format('d/m/Y') }}</div>
            <div><span>Người nhận:</span> {{ $orders->name }}</div>
            <div><span>Điện thoại:</span> {{ $orders->phone }} </div>
            <div><span>Địa chỉ:</span> {{ $orders->address }}</div>
            <div><span>Hình thức thanh toán:</span> {{ $orders->payment_method }}</div>
            <div><span>Tình trạng đơn hàng:</span>
                @if ($orders->status == -1)
                    <span class="text-danger">Đơn hàng đã hủy</span>
                @elseif ($orders->status == 0)
                    <span class="text-warning">Đang được xử lý</span>
                @elseif ($orders->status == 1)
                    <span class="text-primary">Đang vận chuyển</span>
                @elseif ($orders->status == 2)
                    <span class="text-success">Đã giao thành công</span>
                @else
                    <span class="text-secondary">Chưa xác định</span>
                @endif
            </div>
        </div>
        <div class="order-items">
            <table>
                <thead>
                    <tr>
                        <th>Ảnh</th>
                        <th>Sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @php $displayedGiftIds = []; @endphp

                    @foreach ($orders->orderDetails as $item)
                        @if ($item->gift_id && $item->product_id && !in_array($item->gift_id, $displayedGiftIds))
                            <tr class="tr-center">
                                <td>
                                    @if ($item->gift && $item->gift->image)
                                        <img src="{{ asset('layouts/img/' . $item->gift->image) }}" class="img-thumbnail">
                                    @else
                                        <span>Hình ảnh không có sẵn</span>
                                    @endif
                                </td>
                                <td>{{ $item->gift->name }}</td>
                                <td>
                                    <ul style="list-style: none; padding: 0;">
                                        @php $customGiftTotal = 0; @endphp
                                        @foreach ($orders->orderDetails->where('gift_id', $item->gift_id) as $giftItem)
                                            @if ($giftItem->product)
                                                <li>
                                                    <img style="width: 40px;"
                                                        src="{{ asset('layouts/img/' . $giftItem->product->image) }}"
                                                        alt="">
                                                </li>
                                                @php $customGiftTotal += $giftItem->price * $giftItem->quantity; @endphp
                                            @endif
                                        @endforeach
                                    </ul>
                                </td>
                                <td>-</td>
                                <td>{{ number_format($customGiftTotal / 1000) }} VNĐ</td>
                            </tr>
                            @php $displayedGiftIds[] = $item->gift_id; @endphp
                        @elseif ($item->gift_id && !$item->product_id)
                            <tr class="tr-center">
                                <td><img src="{{ asset('layouts/img/' . $item->gift->image) }}" class="img-thumbnail"></td>
                                <td>{{ $item->gift->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->price) }} VNĐ</td>
                                <td>{{ number_format($item->total_price) }} VNĐ</td>
                            </tr>
                        @elseif ($item->product_id && !$item->gift_id)
                            <tr class="tr-center">
                                <td><img src="{{ asset('layouts/img/' . $item->product->image) }}" class="img-thumbnail">
                                </td>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->price) }} VNĐ</td>
                                <td>{{ number_format($item->total_price) }} VNĐ</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="vanchuyen">Phí vận chuyển: 30,000đ</div>
        <div class="total">Tổng Cộng: {{ number_format($orders->total_amount) }}đ</div>
        <div> <a href="/account/management" class="btn btn-fruits">Quay lại danh sách đơn hàng</a></div>
    </div>

@endsection
