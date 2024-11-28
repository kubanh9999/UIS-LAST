@extends('admin.layout')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>DANH SÁCH MÃ GIẢM GIÁ </h4>
                 {{--    <h6>View/Search product Category</h6> --}}
                </div>
                <div class="page-btn">
                    <a href="{{route('admin.discount.create')}}" class="btn btn-success">
                        <i class="fa-solid fa-plus"></i> THÊM MÃ GIẢM GIÁ
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-top">
                        <div class="search-set">
                            <div class="search-path">
                                <a class="btn btn-success" id="filter_search">
                                    <img src="{{ asset('assets/img/icons/filter.svg') }}" alt="img">
                                    <span>{{-- <img src="assets/img/icons/closes.svg" alt="img"> --}}</span>
                                </a>
                            </div>
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

                    <div class="card" id="filter_inputs">
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
                    </div>

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
                                    <th>id</th>
                                    <th>mã giảm giá</th>
                                    <th>Phần trăm giảm giá</th>
                                    <th>ngày bắt đầu</th>
                                    <th>ngày kết thúc</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($discounts as $item)
                                <tr>
                                    <td>
                                        <label class="checkboxs">
                                            <input type="checkbox">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </td>
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->code}}</td>
                                    <td contenteditable="true" class="editable" data-column="discount_percent" data-id="{{ $item->id }}">{{$item->discount_percent}} %</td>
                                    <td contenteditable="true" class="editable" data-column="valid_form" data-id="{{ $item->id }}">{{$item->valid_form}}</td>
                                    <td contenteditable="true" class="editable" data-column="valid_end" data-id="{{ $item->id }}">{{$item->valid_end}}</td>
                                    <td class="d-flex justify-content-center align-items-center">
                                        <!-- Edit Link -->
                                        <a href="{{ route('admin.discount.edit', $item->id) }}" title="Edit">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                        
                                        <!-- Delete Form -->
                                       {{--  <form id="delete-form-{{ $item->id }}" action="{{ route('admin.discount.destroy', $item->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <!-- Delete Button -->
                                            <button type="button" class="btn" onclick="confirmDelete({{ $item->id }})" title="Delete">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form> --}}
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
   <script>
    document.addEventListener("DOMContentLoaded", function() {
    const editableCells = document.querySelectorAll('.editable');

    editableCells.forEach(cell => {
        cell.addEventListener('blur', function() {
            const column = cell.getAttribute('data-column');
            const value = cell.innerText;
            const id = cell.getAttribute('data-id');
console.log('column',column);
console.log('value',value);
console.log('id',id);

            if (value.trim() !== '') {
                // AJAX Request to Update the Database
                updateDiscount(id, column, value);
            }
        });
    });

    function updateDiscount(id, column, value) {
        fetch('{{ route("admin.discount.updateDiscount", ":id") }}'.replace(':id', id), {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({
                column: column,
                value: value
            })
        })
        .then(response => response.json()) // Parse JSON response
        .then(data => {
            if (data.success) {
    Swal.fire({
        title: 'cập nhật thành công',
        text: 'chúc mừng bạn đã cập nhật thành công',
        icon: 'success',
        confirmButtonText: 'OK',
        timer: 3000,
        timerProgressBar: true,
        background: '#f0f9ff', // màu nền tùy chỉnh
        confirmButtonColor: '#3085d6', // màu nút
        width: '400px', // kích thước thông báo
    });
} else {
    Swal.fire({
        title: 'Update Failed!',
        text: data.message || 'An error occurred. Please try again.',
        icon: 'error',
        confirmButtonText: 'OK',
        confirmButtonColor: '#d33',
    });
}
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
});

   </script>
@endsection
