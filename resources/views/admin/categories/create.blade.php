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
            <form action="{{ route('admin.categories.store') }}" method="post">
                @csrf <!-- Thêm CSRF token để bảo mật -->
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <!-- Category Name -->
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Category Name</label>
                                    <input type="text" name="name" required class="form-control"> <!-- Thêm class và required -->
                                </div>
                            </div>
                            <!-- Submit and Cancel Buttons -->
                            <div class="col-lg-12">
                                
                                <!-- Sử dụng button thay vì a -->
                                <a href="{{ route('admin.categories.create') }}" class="btn btn-secondary">Hủy</a>
                                <button type="submit" class="btn btn-success me-2">Đồng ý</button>
                                <!-- Cập nhật link đến route -->
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            
        </div>
    </div>
@endsection
