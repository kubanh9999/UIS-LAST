@extends('admin.layout')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>THÊM BANNER</h4>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="image_path">Hình ảnh</label>
                        <input type="file" name="image_path" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="position">Vị trí</label>
                        <input type="number" name="position" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="type">Loại</label>
                        <select name="type" class="form-control" required>
                            <option value="main">Main</option>
                            <option value="secondary">Secondary</option>
                            <option value="third">Third</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="alt_text">Mô tả</label>
                        <input type="text" name="alt_text" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="category_id">Danh mục</label>
                        <select name="category_id" class="form-control" id="category_id" required>
                            <option value="">Chọn danh mục</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" data-id="{{ $category->id }}" data-name="{{ $category->name }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Trường ẩn để lưu liên kết tự động -->
                    <input type="hidden" name="link" id="link" value="">

                    <button type="submit" class="btn btn-success">Thêm</button>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
    // Lắng nghe sự kiện thay đổi trên select danh mục
    document.querySelector('select[name="category_id"]').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const categoryId = selectedOption.getAttribute('data-id'); // Lấy ID danh mục
    const categoryName = selectedOption.getAttribute('data-name'); // Lấy tên danh mục (nếu cần)
    const linkInput = document.querySelector('input[name="link"]');

    // Tạo liên kết dựa trên route và ID của danh mục
    if (categoryId) {
        linkInput.value = `{{ url('products/categorys') }}/${categoryId}`;
    } else {
        linkInput.value = ''; // Xóa liên kết nếu không chọn danh mục
    }
});

</script>

@endsection
