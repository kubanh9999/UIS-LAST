@extends('admin.layout')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Chỉnh sửa mã giảm giá</h4>
                </div>
            </div>

            <div class="card">
                <form action="{{ route('admin.discount.update', $discount->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <!-- Category Name -->

                                <!-- Discount Code -->
                                <div class="col-lg-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Mã giảm giá (Code)</label>
                                        <input type="text" name="code" value="{{ old('code', $discount->code ?? '') }}" required class="form-control">
                                    </div>
                                </div>

                                <!-- Discount Percent -->
                                <div class="col-lg-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Phần trăm giảm giá (Discount Percent)</label>
                                        <input type="number" name="discount_percent" value="{{ old('discount_percent', $discount->discount_percent ?? 0) }}" required class="form-control">
                                    </div>
                                </div>
                                <!-- Quantity -->
                                <div class="col-lg-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Số lượng</label>
                                        <input type="number" name="quantity" value="{{ old('quantity', $discount->quantity ?? 0) }}" required class="form-control">
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="col-lg-12 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>Mô tả (Description)</label>
                                        <textarea name="description" class="form-control" rows="3">{{ old('description', $discount->description ?? '') }}</textarea>
                                    </div>
                                </div>

                                <!-- Valid From -->
                                <div class="col-lg-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Ngày bắt đầu (Valid From)</label>
                                        <input type="date" name="valid_form" value="{{ old('valid_form', $discount->valid_form ?? '') }}" required class="form-control">
                                    </div>
                                </div>

                                <!-- Valid End -->
                                <div class="col-lg-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Ngày kết thúc (Valid End)</label>
                                        <input type="date" name="valid_end" value="{{ old('valid_end', $discount->valid_end ?? '') }}" required class="form-control">
                                    </div>
                                </div>

                                <!-- Submit and Cancel Buttons -->
                              
                                <div class="col-lg-12">
                                    <div class="form-group d-flex justify-content-end">
                                        <a href="{{ route('admin.discount.index') }}" class="btn btn-secondary me-2">Hủy</a>
                                        <button type="submit" class="btn btn-success">Đồng ýý</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
