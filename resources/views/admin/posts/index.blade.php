@extends('admin.layout')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>QUẢN LÝ BÀI VIẾT</h4>

                </div>
                <div class="page-btn">
                    <a href="{{route('admin.post.create')}}" class="btn btn-success">
                        <i class="fa-solid fa-plus"></i>THÊM BÀI VIẾT MỚI
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-top">
                        <div class="search-set">
                            {{-- <div class="search-path">
                                <a class="btn btn-success" id="filter_search">
                                    <img src="{{ asset('assets/img/icons/filter.svg') }}" alt="img">
                                  
                                </a>
                            </div> --}}
                            <div class="search-input">
                                <a class="btn btn-searchset"><img src="{{ asset('assets/img/icons/search-white.svg') }}"
                                        alt="img"></a>
                            </div>
                        </div>
                        <div class="wordset">
                            <ul>
                                <li>
                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"><img
                                            src="{{ asset('assets/img/icons/pdf.svg') }}" alt="img"></a>
                                </li>
                                <li>
                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel"><img
                                            src="{{ asset('assets/img/icons/excel.svg') }}" alt="img"></a>
                                </li>
                                <li>
                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="print"><img
                                            src="{{ asset('assets/img/icons/printer.svg') }}" alt="img"></a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- <div class="card" id="filter_inputs">
                        <div class="card-body pb-0">
                            <div class="row">
                                <div class="col-lg-2 col-sm-6 col-12">
                                    <div class="form-group">
                                        <select class="select">
                                            <option>Choose Category</option>
                                            <option>Computers</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-6 col-12">
                                    <div class="form-group">
                                        <select class="select">
                                            <option>Choose Sub Category</option>
                                            <option>Fruits</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-6 col-12">
                                    <div class="form-group">
                                        <select class="select">
                                            <option>Choose Sub Brand</option>
                                            <option>Iphone</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-1 col-sm-6 col-12 ms-auto">
                                    <div class="form-group">
                                        <a class="btn btn-success ms-auto"><img
                                                src="{{ asset('assets/img/icons/search-whites.svg') }}" alt="img"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}

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
                                    <th>Ảnh</th>
                                    <th>Tên</th>
                                    <th>Danh mục</th>
                                    <th>Ngày tạo</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($post as $item)
                                <tr>
                                    <td>
                                        <label class="checkboxs">
                                            <input type="checkbox" name="select-item" value="{{ $item->id }}">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </td>
                                    <td>{{ $item->id }}</td>
                                    <td>
                                        @php
                                            $imagePath = public_path($item->image);
                                        @endphp

                                        @if (file_exists($imagePath))
                                            <img src="{{ asset($item->image) }}" alt="Ảnh sản phẩm" width="100">
                                        @else
                                            <img src="{{ asset('layouts/img/'.$item->image) }}" alt="Ảnh sản phẩm" width="100">
                                        @endif
                                    </td>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ $item->category_id }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>
                                        <!-- Edit button -->
                                        <a href="{{ route('admin.post.edit', $item->id) }}" style="margin-left: 5px">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                    
                                        <!-- View button -->
                                        <a href="{{ route('admin.post.show', $item->id) }}" style="margin-left: 10px">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                    
                                        <!-- Delete form -->
                                        <form id="delete-form-{{ $item->id }}" action="{{ route('admin.post.destroy', $item->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                    
                                            <!-- Button with icon and tooltip -->
                                            <button type="button" onclick="confirmDelete({{ $item->id }})" style="border: none; background: none; cursor: pointer;" title="Xóa bài viết">
                                                <i class="fa-solid fa-trash" style="color: red; font-size: 20px;"></i>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmDelete(itemId) {
            Swal.fire({
                title: 'Bạn có chắc chắn?',
                text: "Hành động này không thể hoàn tác!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Vâng, xóa nó!',
                cancelButtonText: 'Hủy bỏ'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit form nếu người dùng nhấn đồng ý
                    document.getElementById('delete-form-' + itemId).submit();
                }
            })
        }
    </script>
@endsection
