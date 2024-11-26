@extends('admin.layout')

@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Thêm User</h4>
                </div>
            </div>

            <div class="card">
                <form action="{{ isset($user) ? route('admin.users.update', $user->id) : route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if(isset($user))
                        @method('PUT') <!-- Thêm phương thức PUT cho cập nhật -->
                    @endif
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Tên</label>
                                    <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Mật khẩu</label>
                                    <div class="pass-group">
                                        <input type="password" name="password" class="form-control pass-input" {{ !isset($user) ? 'required' : '' }}>
                                        <span class="fas toggle-password fa-eye-slash"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Số điện thoại</label>
                                    <input type="text" name="phone" value="{{ old('phone', $user->phone ?? '') }}" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Địa chỉ</label>
                                    <input type="text" name="address" value="{{ old('address', $user->address ?? '') }}" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Role</label>
                                    <select name="role" class="select form-control">
                                        <option value="Owner" {{ (isset($user) && $user->role == 'Owner') ? 'selected' : '' }}>Owner</option>
                                        <option value="User" {{ (isset($user) && $user->role == 'User') ? 'selected' : '' }}>User</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-submit me-2">Submit</button>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-cancel">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
