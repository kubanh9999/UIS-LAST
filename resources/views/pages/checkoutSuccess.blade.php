@extends('layouts.master') <!-- Sử dụng layout nếu bạn có -->

@section('title', 'Đặt Hàng Thành Công')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card text-center">
                    <div class="card-body">
                        <h1 class="card-title text-success"><i class="bi bi-check-circle-fill"></i> Đặt Hàng Thành Công!</h1>
                        <p class="card-text">Cảm ơn bạn đã mua sắm tại cửa hàng của chúng tôi. Đơn hàng của bạn đã được đặt thành công vui lòng kiểm tra email mua hàng để xác nhận đơn hàng.</p>
                        <p class="card-text">Mã đơn hàng của bạn là <strong>#{{ $orderId ?? 'XXXXXX' }}</strong></p>
                        <a href="{{ route('home.index') }}" class="btn btn-primary mt-3"><i class="bi bi-house-door-fill"></i> Quay lại Trang Chủ</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
