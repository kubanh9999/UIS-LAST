@extends('admin.layout')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Product Add Category</h4>
                    <h6>Create new product Category</h6>
                </div>
            </div>
            <form action="{{ route('admin.discount.store') }}" method="post">
                @csrf <!-- Thêm CSRF token để bảo mật -->
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <!-- Category Name -->
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>mã giảm giá</label>
                                    <input type="text" name="code" required class="form-control"> <!-- Thêm class và required -->
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Phần trăm giảm giá</label>
                                    <input type="number" name="discount_percent" required class="form-control" max="100" min="0" id="discountPercentInput"> <!-- Dùng input type number để hạn chế nhập -->
                                </div>
                                
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>mô tả</label>
                                    <input type="text" name="description" required class="form-control"> <!-- Thêm class và required -->
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Ngày bắt đầu</label>
                                    <input type="date" name="valid_form" required class="form-control">

                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Ngày kết thúc</label>
                                    <input type="date" name="valid_end" required class="form-control">
                                </div>
                            </div>
                            <!-- Submit and Cancel Buttons -->
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-success me-2">Submit</button> <!-- Sử dụng button thay vì a -->
                                <a href="{{ route('admin.discount.create') }}" class="btn btn-secondary">Cancel</a> <!-- Cập nhật link đến route -->
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            
        </div>
    </div>
    <script>
        document.getElementById('discountPercentInput').addEventListener('input', function() {
            var discountValue = parseFloat(this.value);
            if (discountValue > 100) {
                // Gọi confirmDelete1() mà không cần itemId
                confirmDelete1(); 
                this.value = 100; 
            }
        });
    
        function confirmDelete1(itemId) {
            Swal.fire({
                title: 'Giá trị lớn hơn 100',
                text: "Vui lòng nhập nhỏ hơn 100!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Được rồi',
                cancelButtonText: 'Hủy bỏ'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Nếu không có itemId, có thể gửi mẫu khác hoặc không thực hiện hành động nào khác
                    // Chỉ là ví dụ gửi biểu mẫu, cần truyền itemId nếu cần
                    if (itemId) {
                        document.getElementById('delete-form-' + itemId).submit();
                    } else {
                        // Có thể thực hiện hành động khác nếu không có itemId
                        console.log('Người dùng đã đồng ý nhưng không có itemId.');
                    }
                }
            });
        }
    </script>
@endsection
