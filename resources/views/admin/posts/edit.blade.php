@extends('admin.layout')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>CHỈNH SỬA BÀI VIẾT</h4>
                </div>
            </div>
            @if(session('success'))
            <script>
                console.log("Success message:", "{{ session('success') }}");  // In thông báo ra console
                Swal.fire({
                    title: 'Thành công!',
                    text: "{{ session('success') }}",  // Dữ liệu thông báo từ session
                    icon: 'success',
                    confirmButtonText: 'Đóng'
                });
            </script>
        @endif
        
            <div class="card">
                <form action="{{ route('admin.post.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <!-- Tiêu đề bài viết -->
                                <div class="col-lg-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="title">Tiêu đề</label>
                                        <input type="text" id="title" name="title" value="{{ old('title', $post->title ?? '') }}" required class="form-control">
                                    </div>
                                </div>

                                <!-- Ảnh bài viết -->
                                <div class="col-lg-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="image">Ảnh</label>
                                        <input type="file" id="image" name="image" class="form-control">
                                        @if ($post->image)
                                            <img src="{{ asset('layouts/img/' . $post->image) }}" alt="Ảnh bài viết" width="100" class="mt-2">
                                        @endif
                                    </div>
                                </div>

                                <!-- Danh mục bài viết -->
                                <div class="col-lg-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="category_id">Danh mục</label>
                                        <select name="category_id" id="category_id" class="form-control">
                                            <option value="">Chọn danh mục</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Mô tả bài viết -->
                                <div class="col-lg-12 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>Nội dung</label>
                                        <textarea name="content" id="editor" rows="10" class="form-control">{{ old('content', $post->content ?? '') }}</textarea>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="author">Tác giả</label>
                                        <input type="text" id="author" name="author" value="{{ old('title', $post->author ?? '') }}" required class="form-control">
                                    </div>
                                </div>

                                <!-- Ngày tạo -->
                                <div class="col-lg-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="created_at">Ngày tạo</label>
                                        <input type="date" id="created_at" name="created_at" value="{{ old('created_at', $post->created_at->format('Y-m-d') ?? '') }}" required class="form-control">
                                    </div>
                                </div>
                                {{-- <div class="col-lg-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Trạng thái</label>
                                        <select name="status" required class="form-control">
                                            <option value="1" {{ $post->status == 1 ? 'selected' : '' }}>Hiển thị</option>
                                            <option value="0" {{ $post->status == 0 ? 'selected' : '' }}>Ẩn</option>
                                        </select>
                                    </div>
                                </div> --}}
                                <!-- Submit and Cancel Buttons -->
                                <div class="col-lg-12">
                                    <button type="submit" class="btn btn-success me-2">Cập nhật</button>
                                    <a href="{{ route('admin.post.index') }}" class="btn btn-warning">Hủy bỏ</a>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
