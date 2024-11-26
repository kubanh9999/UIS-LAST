@extends('admin.layout')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>User Management</h4>
                    <h6>Edit/Update User</h6>
                </div>
            </div>

            <div class="card">
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') <!-- Thêm phương thức PUT cho cập nhật -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>tên</label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>email</label>
                                    <input type="text" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
                                </div>
                            </div>
                            
                          {{--   <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Password</label>
                                    <div class="pass-group">
                                        <input type="password" name="password" class="form-control pass-input" placeholder="123456" autocomplete="off">
                                        <span class="fas toggle-password fa-eye-slash"></span>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>số điện thoại</label>
                                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>địa chỉ</label>
                                    <input type="email" name="address" value="{{ old('email', $user->email) }}" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Role</label>
                                    <select name="role" class="select form-control" required>
                                        <option value="Owner" {{ $user->role == 'Owner' ? 'selected' : '' }}>Owner</option>
                                        <option value="User" {{ $user->role == 'User' ? 'selected' : '' }}>User</option>
                                    </select>
                                </div>
                            </div>
                           
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-submit me-2">Update</button>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-cancel">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection
