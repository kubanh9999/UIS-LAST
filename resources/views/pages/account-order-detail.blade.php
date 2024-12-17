@extends('layouts.master')
@section('title', 'Quản lý tài khoản')
@section('content')

    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-light p-2 rounded">
                <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="#">Quản lý tài khoản</a></li>
                <li class="breadcrumb-item active" aria-current="page">Chi tiết đơn hàng</li>
            </ol>
        </nav>
    </div>

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
                                    <h4 class="fw-bold text-danger">{{ number_format($orders->total_amount, 0, ',', '.') }}đ
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
             
    </section>
   
    <script type="text/javascript">
        function printOrderDetails() {
            var content = document.querySelector('.order-details').outerHTML;
            var originalContent = document.body.innerHTML;

            document.body.innerHTML = content;
            window.print();
            document.body.innerHTML = originalContent;
            window.location.reload(); // Reload lại trang để tránh mất nội dung
        }
    </script>

@endsection
