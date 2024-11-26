@extends('admin.layout')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>QUẢN LÝ BANNER</h4>
                <h6>Danh sách banner</h6>
            </div>
            <div class="page-btn">
                <a href="{{ route('admin.banners.create') }}" class="btn btn-success">
                    <i class="fa-solid fa-plus"></i> Thêm Banner
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Hình ảnh</th>
                                <th>Tiêu đề</th>
                                <th>Đường dẫn</th>
                                <th>Loại</th>
                                <th>Vị trí</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($banners as $banner)
                                <tr>
                                    <td>{{ $banner->id }}</td>
                                    <td>
                                        <img src="{{ asset($banner->image_path) }}" alt="{{ $banner->alt_text }}" width="100">
                                    </td>
                                    <td>{{ $banner->alt_text }}</td>
                                    <td>{{ $banner->link }}</td>
                                    <td>{{ $banner->type }}</td>
                                    <td>{{ $banner->position }}</td>
                                    <td>
                                        <a href="{{ route('admin.banners.edit', $banner->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fa-solid fa-pen"></i> Sửa
                                        </a>
                                        <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa banner này?')">
                                                <i class="fa-solid fa-trash"></i> Xóa
                                            </button>
                                        </form>                                        
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Thêm banner
    document.getElementById('addBannerBtn').addEventListener('click', function() {
        $('#addBannerModal').modal('show');
    });

    // Xóa banner
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('tr');
            const modal = document.getElementById('deleteBannerModal');

            // Hiển thị modal xác nhận
            $(modal).modal('show');

            // Xóa khi xác nhận
            modal.querySelector('.confirm-delete-btn').onclick = () => {
                row.remove();
                $(modal).modal('hide');
            };
        });
    });
</script>
@endpush
