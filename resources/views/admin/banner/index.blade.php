@extends('admin.layout')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>QUẢN LÝ BANNER</h4>
                <h6>Danh sách banner</h6>
            </div>
            @if(session('success'))
                <script>
                    Swal.fire({
                        title: 'Thành công!',
                        text: "{{ session('success') }}",
                        icon: 'success',
                        confirmButtonText: 'Đóng'
                    });
                </script>
            @endif
            <div class="page-btn">
                <a href="{{ route('admin.banners.create') }}" class="btn btn-success">
                    <i class="fa-solid fa-plus"></i> Thêm Banner
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <!-- Main Banners -->
                <h5>Main Banners</h5>
                <div class="table-responsive mb-4">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Hình ảnh</th>
                                <th>Tiêu đề</th>
                                <th>Đường dẫn</th>
                                <th>Vị trí</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mainBanners as $banner)
                                <tr>
                                    <td>{{ $banner->id }}</td>
                                    <td>
                                        <img src="{{ asset($banner->image_path) }}" alt="{{ $banner->alt_text }}" width="100">
                                    </td>
                                    <td>{{ $banner->alt_text }}</td>
                                    <td>{{ $banner->link }}</td>
                                    <td>{{ $banner->position }}</td>
                                    <td>
                                        <a href="{{ route('admin.banners.edit', $banner->id) }}" class="btn btn-sm btn-primary">Sửa</a>
                                        <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" style="display:inline-block;">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa banner này?')">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Secondary Banners -->
                <h5>Secondary Banners</h5>
                <div class="table-responsive mb-4">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Hình ảnh</th>
                                <th>Tiêu đề</th>
                                <th>Đường dẫn</th>
                                <th>Vị trí</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($secondaryBanners as $banner)
                                <tr>
                                    <td>{{ $banner->id }}</td>
                                    <td>
                                        <img src="{{ asset($banner->image_path) }}" alt="{{ $banner->alt_text }}" width="100">
                                    </td>
                                    <td>{{ $banner->alt_text }}</td>
                                    <td>{{ $banner->link }}</td>
                                    <td>{{ $banner->position }}</td>
                                    <td>
                                        <a href="{{ route('admin.banners.edit', $banner->id) }}" class="btn btn-sm btn-primary">Sửa</a>
                                        <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" style="display:inline-block;">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa banner này?')">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Third Banners -->
                <h5>Third Banners</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Hình ảnh</th>
                                <th>Tiêu đề</th>
                                <th>Đường dẫn</th>
                                <th>Vị trí</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($thirdBanners as $banner)
                                <tr>
                                    <td>{{ $banner->id }}</td>
                                    <td>
                                        <img src="{{ asset($banner->image_path) }}" alt="{{ $banner->alt_text }}" width="100">
                                    </td>
                                    <td>{{ $banner->alt_text }}</td>
                                    <td>{{ $banner->link }}</td>
                                    <td>{{ $banner->position }}</td>
                                    <td>
                                        <a href="{{ route('admin.banners.edit', $banner->id) }}" class="btn btn-sm btn-primary">Sửa</a>
                                        <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" style="display:inline-block;">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa banner này?')">Xóa</button>
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
