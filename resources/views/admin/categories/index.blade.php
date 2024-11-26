@extends('admin.layout')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>DANH MỤC SẢN PHẨM</h4>
                    <h6>View/Search product Category</h6>
                </div>
                <div class="page-btn">
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-success">
                        <i class="fa-solid fa-plus"></i>THÊM DANH MỤC
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table datanew">
                            <thead>
                                <tr>
                                    <th>
                                        <label class="checkboxs">
                                            <input type="checkbox" id="select-all">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </th>
                                    <th>Tên danh mục</th>
                                    <th>Ngày tạo</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($category as $item)
                                <tr id="category-{{ $item->id }}">
                                    <td>
                                        <label class="checkboxs">
                                            <input type="checkbox">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <!-- Editable category name -->
                                        <span class="category-name" data-id="{{ $item->id }}" contenteditable="true">
                                            {{ $item->name }}
                                        </span>
                                    </td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>
                                        <!-- Edit Button (Optional if using inline editing) -->
                                        <a class="me-3" href="{{ route('admin.categories.edit', $item->id) }}">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <!-- Delete Button -->
                                        <button type="button" class="btn btn-sm delete-category-btn" data-id="{{ $item->id }}" data-toggle="modal" data-target="#deleteCategoryModal">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
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

    <!-- Modal xác nhận xóa -->
    <div class="modal fade" id="deleteCategoryModal" tabindex="-1" role="dialog" aria-labelledby="deleteCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteCategoryModalLabel">
                        <i class="fas fa-exclamation-triangle"></i> Xác nhận xóa danh mục
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <p class="font-weight-bold">Bạn có chắc chắn muốn xóa danh mục này?</p>
                    <p class="text-danger">Tất cả các sản phẩm thuộc danh mục này cũng sẽ bị xóa!</p>
                    <div class="alert alert-warning" role="alert">
                        <strong>Chú ý:</strong> Hành động này không thể hoàn tác!
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <form id="deleteForm" action="" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times"></i> Hủy
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash-alt"></i> Xóa
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    // Script để cập nhật action của form xóa với id danh mục
    document.querySelectorAll('.delete-category-btn').forEach(button => {
        button.addEventListener('click', function() {
            var categoryId = this.getAttribute('data-id');
            var actionUrl = '/admin/categories/' + categoryId;
            document.getElementById('deleteForm').setAttribute('action', actionUrl);
        });
    });

    // Script để cập nhật tên danh mục trực tiếp
    $(document).ready(function() {
        $('.category-name').on('blur', function() {
            var categoryName = $(this).text(); // Lấy tên danh mục sau khi chỉnh sửa
            var categoryId = $(this).data('id'); // Lấy ID danh mục

            // Gửi yêu cầu cập nhật danh mục qua AJAX
            $.ajax({
                url: '/admin/categories/update/full/' + categoryId, // Đường dẫn route
                method: 'PUT',
                data: {
                    name: categoryName,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // Hiển thị thông báo thành công
                    Swal.fire({
                        title: 'Cập nhật thành công!',
                        text: 'Danh mục đã được cập nhật.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                },
                error: function(error) {
                    // Hiển thị thông báo lỗi
                    Swal.fire({
                        title: 'Cập nhật thất bại!',
                        text: 'Đã xảy ra lỗi, vui lòng thử lại.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    });
</script>
@endpush
