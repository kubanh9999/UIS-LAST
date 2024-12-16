@extends('admin.layout')

@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Chỉnh sửa sản phẩm</h4>
                </div>
            </div>
            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="form-group">
                        <label>Tên sản phẩm</label>
                        <input type="text" name="name" required class="form-control" value="{{ $product->name }}">
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="category">Danh mục</label>
                        <select name="category_id" id="category" class="form-control" required>
                            <option value="">Chọn danh mục</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="form-group">
                        <label>Số lượng</label>
                        <input type="number" name="stock" required class="form-control" min="0" value="{{ $product->stock }}">
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="form-group">
                        <label>Giá</label>
                        <input type="number" name="price" required class="form-control" min="0" step="0.01" value="{{ $product->price }}">
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="form-group">
                        <label>Giảm giá</label>
                        <input type="number" name="discount" class="form-control" min="0" step="0.01" value="{{ $product->discount }}">
                    </div>
                </div>

                {{-- <div class="col-lg-12">
                    <div class="form-group">
                        <label>Ảnh con</label>
                        <input type="file" name="child_images[]" class="form-control" multiple>
                        <small class="form-text text-muted">Chọn ít nhất 3 ảnh (Ctrl + Click để chọn nhiều)</small>@if ($errors->has('child_images'))
                            <div class="alert alert-danger">
                                {{ $errors->first('child_images') }}
                            </div>
                        @endif
                    </div>
                </div> --}}

                <div class="col-lg-12">
                    <div class="form-group">
                        <label>Mô tả</label>
                        <textarea name="description" id="description" class="form-control" style="height: 300px;">{{ $product->description }}</textarea>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="form-group text-center">
                        <label>Ảnh sản phẩm chính</label>
                        <div class="image-upload">
                            <input type="file" name="product_image" class="form-control">
                            <div class="image-uploads">
                                <img src="{{ asset('assets/img/icons/upload.svg') }}" alt="img">
                                <h4>Kéo và thả một file để tải ảnh lên</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                          
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Hủy</a> <!-- Cập nhật link đến route -->
                <button type="submit" class="btn btn-success me-2">Đồng ý</button> <!-- Sử dụng button thay vì a -->
            </div>
                
            </div>
        </div>
    </div>
</form>


            <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.10.3/tinymce.min.js"></script>
            <script>
                tinymce.init({
                    selector: 'textarea#description',
                    plugins: [
                        'anchor', 'autolink', 'charmap', 'image', 'link', 'lists', 'media', 
                        'searchreplace', 'table', 'visualblocks', 'wordcount'
                    ],
                    toolbar: 'undo redo | bold italic underline | link image media | numlist bullist | removeformat',
                    tinycomments_mode: 'embedded',
                    tinycomments_author: 'Author name'
                });
            </script>
        </div>
    </div>
@endsection