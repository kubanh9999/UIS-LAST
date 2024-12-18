@extends('admin.layout')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>QUẢN LÝ BÌNH LUẬN</h4>
                    <h6>View/Search Comments</h6>
                </div>
            </div>
            <script>
                @if(session('success'))
                    Swal.fire({
                        title: 'Thành công!',
                        text: "{{ session('success') }}",
                        icon: 'success',
                        confirmButtonText: 'Đóng'
                    });
                @endif
            </script>
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
                                    <th>ID</th>
                                    <th>Tên Người Dùng</th>
                                    <th>Nội Dung</th>
                                    <th>Số lượng trả lời</th> <!-- Thêm cột cho số lượng reply -->
                                    <th>Trạng Thái</th>
                                    <th>Ngày</th>
                                    <th>Sản phẩm</th>
                                    <th>Hành động</th> 
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($comments as $item)
                                <tr>
                                    <td>
                                        <label class="checkboxs">
                                            <input type="checkbox">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </td>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->user->name ?? 'Người dùng cũ'  }}</td>
                                    <td>{{ $item->content }}</td>
                                    <td>{{ $item->replies_count }}</td>
                                    <td>
                                        @if ($item->status == 0)
                                            Chưa duyệt
                                        @elseif($item->status == 1)
                                            Đã duyệt
                                        @elseif($item->status == 2)
                                            Đã ẩn
                                        @endif
                                    </td>                                     
                                    <td>{{ $item->created_at->format('Y-m-d') }}</td>
                                    <td>{{ $item->product->name ?? null }}</td>
                                    <td>
                                        <a href="javascript:void(0);" onclick="confirmDelete({{ $item->id }})" class="btn  btn-sm"> <i class="fas fa-trash-alt"></i></a>
                                        <form id="delete-form-{{ $item->id }}" action="{{ route('admin.comments.delete', $item->id) }}" method="POST" style="display:none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        
                                        @if($item->status == 0)
                                            <a href="#" onclick="approveComment({{ $item->id }})" class="btn btn-success btn-sm">Duyệt</a>
                                        @endif
                                        
                                        @if($item->status == 1) <!-- Hiện nút ẩn nếu bình luận đã duyệt -->
                                            <a href="javascript:void(0);" onclick="confirmHide({{ $item->id }})" class="btn  btn-sm"><i class="fa-solid fa-eye-slash"></i></a>
                                            <form id="hide-form-{{ $item->id }}" action="{{ route('admin.comments.hide', $item->id) }}" method="POST" style="display:none;">
                                                @csrf
                                                @method('PUT')
                                            </form>
                                        @endif
                                    
                                        @if($item->status == 2) <!-- Hiện nút hiện lại nếu bình luận đã ẩn -->
                                            <a href="javascript:void(0);" onclick="unhideComment({{ $item->id }})" class="btn  btn-sm"><i class="fa-solid fa-eye"></i></a>
                                            <form id="unhide-form-{{ $item->id }}" action="{{ route('admin.comments.unhide', $item->id) }}" method="POST" style="display:none;">
                                                @csrf
                                                @method('POST') 
                                            </form>
                                        @endif
                                        <a href="{{ route('admin.comments.detail', $item->id) }}" class="btn  btn-sm"><i class="fa-solid fa-circle-info"></i></a>
                                    </td>                                    
                                </tr>    
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="pagination-wrapper">
                        {{ $comments->withQueryString()->links('pagination::bootstrap-4') }}
                    </div>                    
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    function confirmDelete(commentId) {
        if (confirm("Bạn có chắc muốn xóa bình luận này không?")) {
            const form = document.getElementById(`delete-form-${commentId}`);
            form.submit();
        }
    }

    function approveComment(commentId) {
        if (confirm("Bạn có chắc muốn duyệt bình luận này không?")) {
            window.location.href = `/admin/comments/approve/${commentId}`;
        }
    }

    function confirmHide(commentId) {
        if (confirm("Bạn có chắc muốn ẩn bình luận này không?")) {
            const form = document.getElementById(`hide-form-${commentId}`);
            form.submit(); 
        }
    }

    function unhideComment(commentId) {
        if (confirm("Bạn có chắc muốn hiện lại bình luận này không?")) {
            document.getElementById(`unhide-form-${commentId}`).submit(); // Gửi form hiện lại bình luận
        }
    }
</script>
