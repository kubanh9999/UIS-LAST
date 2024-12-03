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
                        <label for="link_type">Loại liên kết</label>
                        <select name="link_type" id="link_type" class="form-control" required>
                            <option value="category" {{ $banner->link_type == 'category' ? 'selected' : '' }}>Liên kết danh mục</option>
                            <option value="custom" {{ $banner->link_type == 'custom' ? 'selected' : '' }}>Liên kết tùy ý</option>
                        </select>
                    </div>

                    <!-- Nhóm liên kết danh mục -->
                    <div class="form-group" id="category_link_group">
                        <label for="category_id">Đường link danh mục</label>
                        <select name="category_id" class="form-control" id="category_id">
                            <option value="">Chọn danh mục</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" data-id="{{ $category->id }}" {{ $banner->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>/-strong/-heart:>:o:-((:-h @endforeach
                        </select>
                    </div>
                    
                    <!-- Nhóm liên kết tùy ý -->
                    <div class="form-group d-none" id="custom_link_group">
                        <label for="custom_link">Liên kết tùy ý</label>
                        <input type="url" name="custom_link" id="custom_link" class="form-control" value="{{ $banner->link }}" placeholder="Nhập URL">
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
    document.addEventListener('DOMContentLoaded', function () {
        const linkType = document.getElementById('link_type'); // Trường chọn loại liên kết
        const categoryLinkGroup = document.getElementById('category_link_group'); // Group select danh mục
        const customLinkGroup = document.getElementById('custom_link_group'); // Group liên kết tùy ý
        const categorySelect = document.getElementById('category_id'); // Select danh mục
        const customLinkInput = document.getElementById('custom_link'); // Input liên kết tùy ý
        const linkInput = document.getElementById('link'); // Input hidden lưu giá trị link

        // Hiển thị đúng group khi thay đổi loại liên kết
        linkType.addEventListener('change', function () {
            if (this.value === 'category') {
                categoryLinkGroup.classList.remove('d-none'); // Hiển thị danh mục
                customLinkGroup.classList.add('d-none'); // Ẩn tùy ý
                linkInput.value = ''; // Reset giá trị link
            } else if (this.value === 'custom') {
                categoryLinkGroup.classList.add('d-none'); // Ẩn danh mục
                customLinkGroup.classList.remove('d-none'); // Hiển thị tùy ý
                linkInput.value = ''; // Reset giá trị link
            }
        });

        // Gán giá trị link khi chọn danh mục
        categorySelect.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const categoryId = selectedOption.getAttribute('data-id');
            if (categoryId) {
                linkInput.value = `{{ url('products/categorys') }}/${categoryId}`;
            } else {
                linkInput.value = '';
            }
        });

        // Gán giá trị link khi nhập URL tùy ý
        customLinkInput.addEventListener('input', function () {
            linkInput.value = this.value;
        });

        // Gọi lại sự kiện khi trang đã tải để hiển thị nhóm liên kết đúng
        linkType.dispatchEvent(new Event('change'));
    });