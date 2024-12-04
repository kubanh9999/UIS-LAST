@extends('admin.layout')

@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Danh sách tài khoản</h4>
                </div>
                {{-- <div class="page-btn">
                    <a href="{{ route('admin.users.create') }}" class="btn btn-success">
                        <i class="fa-solid fa-plus"></i>Thêm tài khoản
                    </a>
                </div> --}}
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
                    <div class="table-top">
                        <div class="search-set">
                            <div class="search-path">
                                <a class="btn btn-success" id="filter_search">
                                    <img src="{{ asset('assets/img/icons/filter.svg') }}" alt="img">
                               
                                </a>
                            </div>
                            <div class="search-input">
                                <a class="btn btn-searchset">
                                    <img src="{{ asset('assets/img/icons/search-white.svg') }}" alt="img">
                                </a>
                            </div>
                        </div>
                        <div class="wordset">
                            <ul>
                                <li>
                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf">
                                        <img src="{{ asset('assets/img/icons/pdf.svg') }}" alt="img">
                                    </a>
                                </li>
                                <li>
                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel">
                                        <img src="{{ asset('assets/img/icons/excel.svg') }}" alt="img">
                                    </a>
                                </li>
                                <li>
                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="print">
                                        <img src="{{ asset('assets/img/icons/printer.svg') }}" alt="img">
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card" id="filter_inputs">
                        <div class="card-body pb-0">
                            <div class="row">
                                <div class="col-lg-2 col-sm-6 col-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Nhập tên người dùng">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-4 col-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Nhập số điện thoại">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-6 col-12">
                                    <div class="form-group">
                                        <input type="email" class="form-control" placeholder="Nhập email">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-3 col-12">
                                    <div class="form-group">
                                        <select class="form-control">
                                            <option value="">Tình trạng</option>
                                            <option value="0">Hoạt động</option>
                                            <option value="1">Bị khóa</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-1 col-sm-6 col-12 ms-auto">
                                    <div class="form-group">
                                        <a class="btn btn-success ms-auto">
                                            <img src="{{ asset('assets/img/icons/search-whites.svg') }}" alt="img">
                                        </a>
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
                                            <input type="checkbox">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </th>
                                    <th>Tên</th>
                                    <th>Email</th>
                                    <th>Số điện thoại</th>
                                    <th>Tình trạng</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user as $item)
                                    <tr>
                                        <td>
                                            <label class="checkboxs">
                                                <input type="checkbox">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->phone }}</td>
                                        <td class="status">{{ $item->status }}</td>
                                        <td class="action-cell">
                                            <div class="action-icons">
                                                <button type="button" class="btn status-btn" data-id="{{ $item->id }}" data-status="{{ $item->status }}" onclick="toggleStatusq(this)">
                                                    <i class="fa-solid {{ $item->status == 'hoạt động' ? 'fa-unlock' : 'fa-lock' }}"></i>
                                                </button>
                                            </div>
                                            
                                                
                                              {{--   <a class="action-icon" href="{{ route('admin.users.edit', $item->id) }}">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a> --}}
                                               {{--  <form id="delete-form-{{ $item->id }}" action="{{ route('admin.users.destroy', $item->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn delete-btn" onclick="confirmDelete({{ $item->id }})">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </form> --}}
                                            </div>
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


    
            <!-- Modal Header -->

            <!-- Modal body -->
          
<!-- SweetAlert2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.16/dist/sweetalert2.min.css" rel="stylesheet">

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOMt23bF3n8zq5/Rc5NQ0Hnd9Hzft2YMePwP5w9" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Khi nhấn nút "Xóa tất cả", hiển thị form xóa giỏ hàng
            $('#clearCart').on('click', function() {
                $('#clear-cart-form').show();
            });
        });
    
        function confirmClearCart() {
            // Hiển thị hộp thoại xác nhận
            if (confirm(" Bạn có chắc chắn muốn xóa tài khoản này k ?")) {
                // Gửi form để xóa giỏ hàng
                document.getElementById('clear-cart-form').submit();
            } else {
                // Thông báo khi người dùng chọn không xóa
                alert("Giỏ hàng không bị xóa.");
            }
        }
    </script>
   
    <script>
 function toggleStatusq(button) {
    const userId = $(button).data('id'); // Lấy userId từ data-id
    let currentStatus = $(button).data('status'); // Lấy trạng thái hiện tại từ data-status
    const newStatus = currentStatus === 'hoạt động' ? 'bị khóa' : 'hoạt động'; // Chuyển trạng thái

    console.log('Current userId:', userId);
    console.log('Current Status:', currentStatus);
    console.log('New Status:', newStatus);

    // Gửi yêu cầu AJAX
    $.ajax({
        url: '/admin/users/toggle-status',
        method: 'POST',
        data: {
            id: userId,
            status: newStatus,
            _token: '{{ csrf_token() }}'  // Thêm token bảo mật
        },
        success: function(response) {
            if (response.success) {
                const button = $('button[data-id="' + userId + '"]');
                const icon = button.find('i');

                // Cập nhật lại biểu tượng
                icon.removeClass('fa-lock fa-unlock')
                    .addClass(newStatus === 'bị khóa' ? 'fa-lock' : 'fa-unlock');

                // Cập nhật trạng thái của người dùng
                button.attr('data-status', newStatus);
                Swal.fire({
                    icon: 'success',
                    title: 'Cập nhật trạng thái thành công!',
                    showConfirmButton: false,
                    timer: 1500  // Thời gian tự động đóng thông báo (1.5s)
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Đã xảy ra lỗi!',
                    text: 'Không thể cập nhật trạng thái.',
                    confirmButtonText: 'Thử lại'
                });
            }
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'Không thể kết nối với máy chủ!',
                text: 'Vui lòng kiểm tra lại kết nối.',
                confirmButtonText: 'Đóng'
            });
        }
    });
}


    </script>
    

@endsection
