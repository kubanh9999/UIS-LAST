@extends('admin.layout')

@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Chi tiết sản phẩm</h4>
                    <h6>Xem chi tiết của một sản phẩm</h6>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Tên sản phẩm</label>
                                <input type="text" class="form-control" value="{{ $product->name }}" readonly>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Danh mục</label>
                                <select class="form-control" disabled>
                                    <option value="{{ $product->category_id }}">{{ $product->category->name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Giá</label>
                                <input type="text" class="form-control" value="{{ $product->price }}" readonly>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Giảm giá</label>
                                <input type="text" class="form-control" value="{{ $product->discount ?? '0' }}" readonly>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Tồn kho</label>
                                <input type="text" class="form-control" value="{{ $product->stock }}" readonly>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Mô tả</label>
                                <textarea class="form-control" readonly>{{ $product->description }}</textarea>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <label>Hình ảnh sản phẩm</label>
                            <div class="image-preview">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="Hình ảnh sản phẩm" class="img-fluid"></div>
                        </div>

                        <div class="col-lg-12">
                            <label>Hình ảnh con</label>
                            <div class="row">
                                @if ($product->productImages && $product->productImages->isNotEmpty())
                                    @foreach($product->productImages as $childImage)
                                        <div class="col-4">
                                            <div class="image-preview">
                                                <img src="{{ asset('storage/' . $childImage->image) }}" alt="Hình ảnh con" class="img-fluid">
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-12">
                                        <p>Không có hình ảnh con nào.</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Quay lại danh sách sản phẩm</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection