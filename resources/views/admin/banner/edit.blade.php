@extends('admin.layout')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>SỬA BANNER</h4>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="image_path">Hình ảnh (Tải lên mới nếu cần)</label>
                        <input type="file" name="image_path" class="form-control">
                        <small>Ảnh hiện tại:</small>
                        <img src="{{ asset($banner->image_path) }}" alt="{{ $banner->alt_text }}" width="100">
                    </div>
                    <div class="form-group">
                        <label for="position">Vị trí</label>
                        <input type="number" name="position" class="form-control" value="{{ $banner->position }}" required>
                    </div>
                    <div class="form-group">
                        <label for="type">Loại</label>
                        <input type="text" name="type" class="form-control" value="{{ $banner->type }}" required>
                    </div>
                    <div class="form-group">
                        <label for="alt_text">Tên chiến dịch</label>
                        <input type="text" name="alt_text" class="form-control" value="{{ $banner->alt_text }}">
                    </div>
                    <div class="form-group">
                        <label for="category_id">Danh mục</label>
                        <select name="category_id" class="form-control" id="category_id" required>
                            <option value="">Chọn danh mục</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" data-id="{{ $category->id }}" data-name="{{ $category->name }}"
                                    {{ $banner->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Trường ẩn để lưu liên kết tự động -->
                    <input type="hidden" name="link" id="link" value="{{ $banner->link }}">
                    
                    <button type="submit" class="btn btn-success">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
document.querySelector('select[name="category_id"]').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const categoryId = selectedOption.getAttribute('data-id'); // Lấy ID danh mục
    const categoryName = selectedOption.getAttribute('data-name'); // Lấy tên danh mục (nếu cần)
    const linkInput = document.querySelector('input[name="link"]');

    // Tạo liên kết dựa trên route và ID của danh mục
    if (categoryId) {
        // Sử dụng window.location.origin để tạo URL động
        linkInput.value = `${window.location.origin}/products/category/${categoryId}`;
    } else {
        linkInput.value = ''; // Xóa liên kết nếu không chọn danh mục
    }
});

</script>

@endsection
