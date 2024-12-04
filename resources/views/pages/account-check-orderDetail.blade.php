@extends('layouts.master')
@section('title', 'Quản lý tài khoản')
@section('content')
    <style>
        /* Container và tiêu đề */
        .order-details-container {
            max-width: 90%;
            margin: auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .order-detail-title {
            font-size: 26px;
            font-weight: bold;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        /* Tóm tắt đơn hàng */
        .order-summary {
            background-color: #f7f9fc;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .order-summary-title {
            font-size: 20px;
            font-weight: bold;
            color: #333;
        }

        .order-summary table {
            width: 100%;
        }

        .order-summary td {
            padding: 10px;
            font-size: 16px;
            color: #555;
        }

        /* Table */
        .order-details-table-responsive {
            margin-top: 20px;
        }

        .order-details-table {
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
        }

        .order-details-table thead th {
            background-color: #319f25;
            color: #fff;
            text-align: center;
            padding: 12px;
        }

        .order-details-table tbody tr {
            transition: background-color 0.3s;
        }

        .order-details-table tbody tr:hover {
            background-color: #f0f8ff;
        }

        .order-details-table img {
            width: 100px;
            border-radius: 4px;
        }

        /* Nút quay lại */
        .order-details-back-button {
            display: block;
            margin: 30px auto;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            background-color: #6c757d;
            border: none;
            border-radius: 6px;
            text-align: center;
        }

        .col-md-4.order-details {
            margin-top: 20px;
        }

        .tr-center td {
            text-align: center;
        }
    </style>

    <div class="order-details-container mt-5 w-500">
       
   {{--  <div class="detai" style="background: #319f25; height: 30px;">
        <h2 class="order-detail-title">Chi tiết đơn hàng # {{ $orders->id }}</h2>
    </div> --}}

        <div class="row text-center justify-content-center" >
            <div class="col-8 order-details">
                <div class="order-summary">
                           
                    <table class="table table-borderless">
                        <h3>Hóa đơn</h3>
                        <div class="print" style="float: right ;color: #319f25 ;width: 30px">
                            <button onclick="printOrderDetails()" style="background: #319f25; width: 30px;border: 1px solid #319f25">
                                <i class="fa-solid fa-print" style="color: #fff"></i> 
                            </button>
                        </div>
                        <table class="table table-borderless">
                            <tbody>
                                <!-- Thông tin đơn hàng -->
                                <tr>
                                    <td><strong>Mã đơn hàng:</strong></td>
                                    <td class="text-right">{{ $orders->token }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tên người mua:</strong></td>
                                    <td class="text-right">{{ $orders->user ? $orders->user->name : 'Chưa có người dùng' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Số điện thoại:</strong></td>
                                    <td class="text-right">{{ $orders->phone }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Địa chỉ:</strong></td>
                                    
                                    <td class="text-right">
                                        {{ $orders->province->name  }}
                                        {{ $orders->district->name  }}, 
                                        {{ $orders->ward->name  }}, 
                                        {{ $orders->street }}, 
                                        
                                    
                                       
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Thanh toán:</strong></td>
                                    <td class="text-right">{{ $orders->payment_method }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Ngày đặt hàng:</strong></td>
                                    <td class="text-right">{{ \Carbon\Carbon::parse($orders->order_date)->format('d/m/Y') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Trạng thái:</strong></td>
                                    <td class="text-right">
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
                                    </td>
                                </tr>



                                <!-- Chi tiết các sản phẩm/gift -->
                                <tr>
                                    @php $displayedGiftIds = []; @endphp
                                    @foreach ($orders->orderDetails as $item)
                                        @if ($item->gift_id && $item->product_id && !in_array($item->gift_id, $displayedGiftIds))
                                            {{--  <tr class="tr-center">
                                        <td colspan="5"><strong>Quà tặng: {{ $item->gift->name }}</strong></td>
                                    </tr> --}}
                                <tr>
                                    <td><strong>Tên sản phẩm :</strong></td>
                                    <td colspan="4">{{ $item->gift->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Hình ảnh:</strong></td>
                                    <td colspan="4">
                                        @if ($item->gift && $item->gift->image)
                                        @php
                                            $imagePath = $item->gift->image;
                                            if (strpos($imagePath, 'uploads/products') === false) {
                                                $imagePath = 'layouts/img/' . $item->gift->image; // Nếu không chứa, thêm 'layouts/img'
                                            }
                                        @endphp
                                            <img src="{{ asset($imagePath) }}"
                                                class="img-thumbnail" style="width: 50px; height: 50px;">
                                        @else
                                            <span>Hình ảnh không có sẵn</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Sản phẩm trong quà tặng:</strong></td>
                                    <td colspan="4">
                                        <ul style="list-style: none; padding: 0;">
                                            @php $customGiftTotal = 0; @endphp
                                            @foreach ($orders->orderDetails->where('gift_id', $item->gift_id) as $giftItem)
                                                @if ($giftItem->product)
                                                    <li>
                                                        @php
                                                            $imagePath = $giftItem->product->image;
                                                            if (strpos($imagePath, 'uploads/products') === false) {
                                                                $imagePath = 'layouts/img/' . $giftItem->product->image; // Nếu không chứa, thêm 'layouts/img'
                                                            }
                                                        @endphp
                                                        <img style="width: 40px;"
                                                            src="{{ asset($imagePath) }}"
                                                            alt="">
                                                        {{ $giftItem->product->name }} x {{ $giftItem->quantity .'g' }}
                                                        @php $customGiftTotal += $giftItem->price * $giftItem->quantity; @endphp
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                                {{-- <tr>
                                        <td><strong>Tổng tiền quà tặng:</strong></td>
                                        <td colspan="4">{{ number_format($customGiftTotal) }} VNĐ</td>
                                    </tr> --}}
                                @php $displayedGiftIds[] = $item->gift_id; @endphp
                            @elseif ($item->gift_id && !$item->product_id)
                            <tr>
                                <td><strong>Tên sản phẩm:</strong></td>
                                <td>{{ $item->gift->name }}</td>
                              
                            </tr>
                            <tr class="">
                                <td><strong>Hình ảnh sản phẩm:</strong></td>
                                 @php
                                    $imagePath = $item->gift->image;
                                    // Nếu đường dẫn ảnh chứa 'uploads/products', không cần thêm 'layouts/img'
                                    if (strpos($imagePath, 'uploads/products') === false) {
                                        $imagePath = 'layouts/img/' . $item->gift->image; // Nếu không chứa, thêm 'layouts/img'
                                    }
                                @endphp
                                <td><img src="{{ asset($imagePath) }}" class="img-thumbnail" style="width: 50px"></td>
                                
                            </tr>
                            <tr>
                                <td><strong>Số lượng</strong></td>
                                <td>{{ $item->quantity }}</td>
                              
                            </tr>
                            @elseif ($item->product_id && !$item->gift_id)
                                <tr>
                                    <td><strong>Tên sản phẩm:</strong></td>
                                    <td>{{ $item->product->name }}</td>

                                </tr>
                                <tr>
                                    <td><strong>Hình ảnh:</strong></td>
                                    @php
                                        $imagePath = $item->product->image;
                                        // Nếu đường dẫn ảnh chứa 'uploads/products', không cần thêm 'layouts/img'
                                        if (strpos($imagePath, 'uploads/products') === false) {
                                            $imagePath = 'layouts/img/' . $item->product->image; // Nếu không chứa, thêm 'layouts/img'
                                        }
                                    @endphp
                                    <td>
                                        <img src="{{ asset($imagePath) }}"
                                            class="img-thumbnail" style="width: 50px;"></td>
                                    </tr>

                                <tr>
                                    <td><strong>Số lượng:</strong></td>
                                    <td>{{ $item->quantity }}</td>

                                </tr>
                                @endif
                                @endforeach

                                </tr>
                                <tr>
                                    <td><strong>Tổng giá đơn hàng:</strong></td>
                                    <td class="text-right"><strong>{{ number_format($orders->total_amount - 30000) }} VNĐ</strong>
                                    </td>
                                </tr>
                               
                                <tr>
                                    <td><strong>Phí vận chuyển:</strong></td>
                                    <td class="text-right">30,000 VNĐ</td>
                                </tr>
                                <tr>
                                    <td><strong>Tổng tiền hàng:</strong></td>
                                    <td class="text-right">{{ number_format($orders->total_amount) }} VNĐ</td>
                                </tr>
                            </tbody>

                        </table>

                    </table>

                </div>
            </div>

            {{-- <div class="col-md-8">
            <div class="order-details-table-responsive">
                <table class="table order-details-table">
                    <thead>
                        <tr>
                            <th scope="col">Hình ảnh</th>
                            <th scope="col">Tên sản phẩm</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Thành tiền</th>
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
                                                        <img style="width: 40px;" src="{{ asset('layouts/img/' . $giftItem->product->image) }}" alt="">
                                                    </li>
                                                    @php $customGiftTotal += $giftItem->price * $giftItem->quantity; @endphp
                                                @endif
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>-</td>
                                    <td>{{ number_format($customGiftTotal) }} VNĐ</td>
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
                                    <td><img src="{{ asset('layouts/img/' . $item->product->image) }}" class="img-thumbnail"></td>
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
        </div> --}}
        </div>

        <a href="/account/management" class="order-details-back-button">Quay lại danh sách đơn hàng</a>
    </div>
    <script type="text/javascript">
        function printOrderDetails() {
            // Ẩn tất cả nội dung khác ngoại trừ chi tiết đơn hàng
            var content = document.querySelector('.order-details').outerHTML;  // Chọn div chứa chi tiết đơn hàng
            var originalContent = document.body.innerHTML;  // Lưu lại nội dung gốc của trang
            
            document.body.innerHTML = content;  // Thay thế nội dung trang bằng chi tiết đơn hàng
            window.print();  // In trang hiện tại (bây giờ chỉ có chi tiết đơn hàng)
            document.body.innerHTML = originalContent;  // Khôi phục lại nội dung gốc sau khi in
        }
    </script>
@endsection
