@extends('admin.layout')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Thêm Bài Viết Mới</h4>
                <h6>Tạo bài viết với thông tin chi tiết</h6>
            </div>
        </div>
        <form action="{{ route('admin.post.store') }}" method="post" enctype="multipart/form-data">
            @csrf <!-- CSRF token để bảo mật -->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <!-- Tiêu đề bài viết -->
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Tiêu đề</label>
                                <input type="text" name="title" required class="form-control" placeholder="Nhập tiêu đề bài viết">
                            </div>
                        </div>

                        <!-- Danh mục bài viết -->
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Danh mục</label>
                                <select name="category_id" required class="form-control">
                                    <option value="">Chọn danh mục</option>
                                    <!-- Lặp qua tất cả các danh mục và hiển thị chúng trong dropdown -->
                                    @foreach($category as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Nội dung bài viết -->
                        <div class="col-lg-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label>Nội dung</label>
                                <textarea name="content" id="editor" rows="10" class="form-control"></textarea>
                            </div>
                        </div>

                        <!-- Ảnh đại diện -->
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Ảnh đại diện</label>
                                <input type="file" name="image" accept="image/*" class="form-control">
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Tác giả</label>
                                <input type="text" name="author" required class="form-control" placeholder="Nhập tên tác giả">
                            </div>
                        </div>

                        <!-- Trạng thái -->
                       {{--  <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Trạng thái</label>
                                <select name="status" required class="form-control">
                                    <option value="1">Hiển thị</option>
                                    <option value="0">Ẩn</option>
                                </select>
                            </div>
                        </div>
 --}}
                        <!-- Ngày đăng -->
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Ngày đăng</label>
                                <input type="date" name="publish_date" class="form-control">
                            </div>
                        </div>

                        <!-- Nút hành động -->
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-success me-2">Tạo bài viết</button>
                            <a href="{{ route('admin.post.index') }}" class="btn btn-warning">Hủy bỏ</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Nạp CKEditor -->
<script src="https://cdn.ckeditor.com/4.20.2/standard/ckeditor.js"></script>

<script>
  window.onload = function() {
    // Khởi tạo CKEditor cho phần tử textarea với id "editor"
    CKEDITOR.replace('editor', {
        filebrowserUploadUrl: "{{ route('admin.posts.upload') }}",
        filebrowserUploadMethod: 'form'
    });
  };
</script>

@endsection
