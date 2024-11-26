@extends('admin.layout')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>chỉnh sửa danh mục</h4>
                  
                </div>
            </div>

            <div class="card">
                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <!-- Category Name -->
                                <div class="col-lg-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Category Name</label>
                                        <input type="text" name="name" value="{{ old('name', $category->name) }}" required>
                                    </div>
                                </div>
                                
                                <!-- Submit and Cancel Buttons -->
                                <div class="col-lg-12">
                                    <button type="submit" class="btn btn-submit me-2">Submit</button>
                                    <a href="{{ route('admin.categories.index') }}" class="btn btn-cancel">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                
            </div>

        </div>
    </div>
@endsection
