@extends('admin.layout')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Thêm mã giảm giá</h4>
                    <h6>Tạo mới một mã giảm giá</h6>
                </div>
            </div>
            <form action="{{ route('admin.discount.store') }}" method="post">
                @csrf <!-- Thêm CSRF token để bảo mật -->
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <!-- Mã giảm giá -->
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="code">Mã giảm giá</label>
                                    <input type="text" name="code" id="code" class="form-control" required>
                                </div>
                            </div>
            
                            <!-- Phần trăm giảm giá -->
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="discountPercentInput">Phần trăm giảm giá</label>
                                    <input type="number" name="discount_percent" id="discountPercentInput" 
                                           class="form-control" min="0" max="100" required>
                                </div>
                            </div>
            
                            <!-- Số lượng -->
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="quantity">Số lượng</label>
                                    <input type="number" name="quantity" id="quantity" class="form-control" min="0" required>
                                </div>
                            </div>
            
                            <!-- Mô tả -->
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="description">Mô tả</label>
                                    <input type="text" name="description" id="description" class="form-control" required>
                                </div>
                            </div>
            
                            <!-- Ngày bắt đầu -->
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="validForm">Ngày bắt đầu</label>
                                    <input type="date" name="valid_form" id="validForm" class="form-control" required>
                                </div>
                            </div>
            
                            <!-- Ngày kết thúc -->
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="validEnd">Ngày kết thúc</label>
                                    <input type="date" name="valid_end" id="validEnd" class="form-control" required>
                                </div>
                            </div>
            
                            <!-- Nút Submit và Cancel -->
                            <div class="col-lg-12">
                                <div class="form-group d-flex justify-content-end">
                                    <a href="{{ route('admin.discount.index') }}" class="btn btn-secondary me-2">Hủy</a>
                                    <button type="submit" class="btn btn-success">Đồng ý</button>
                                </div>
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
