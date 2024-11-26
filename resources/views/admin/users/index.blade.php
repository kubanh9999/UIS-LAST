@extends('admin.layout')

@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Danh sách tài khoản</h4>
                </div>
                <div class="page-btn">
                    <a href="{{ route('admin.users.create') }}" class="btn btn-success">
                        <i class="fa-solid fa-plus"></i>Thêm tài khoản
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
                                        <td class="status">{{ $item->status == 0 ? 'Hoạt động' : 'Bị khóa' }}</td>
                                        <td class="action-cell">
                                            <div class="action-icons">
                                                <button type="button" class="btn status-btn" data-toggle="modal" data-target="#myModal" data-id="{{ $item->id }}" data-status="{{ $item->status }}">
                                                    <i class="fa-solid {{ $item->status == 0 ? 'fa-lock' : 'fa-unlock' }}"></i>
                                                </button>
                                                <a class="action-icon" href="{{ route('admin.users.edit', $item->id) }}">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                                <form id="delete-form-{{ $item->id }}" action="{{ route('admin.users.destroy', $item->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn delete-btn" onclick="confirmDelete({{ $item->id }})">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </form>
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


    <div class="modal" id="myModal">
        <div class="modal-dialog">
          <div class="modal-content">
      
            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Xác nhận</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
      
            <!-- Modal body -->
            <div class="modal-body">
              <form action="">
                <h2 style="font-size: 13px; margin: 8px 0px ">Bạn có muốn khóa tài khoản này:</h2>
                <div class="mb-1">
                    <label for="day">
                        <input type="radio" id="day" name="box"> Trong 1 ngày
                    </label>
                </div>
                
                <div class="mb-1">
                    <label for="month">
                        <input type="radio" id="month"  name="box"> Trong 1 tháng
                    </label>
                </div>
                <div class="mb-1">
                    <label for="year">
                        <input type="radio" id="year" name="box"> Trong 1 năm
                    </label>
                </div>
                <div class="mb-1">
                    <label for="vinhvien">
                        <input type="radio" id="vinhvien" name="box"> Vĩnh biệt cụ
                    </label>
                </div>
                
              </form>
            </div>
      
            <!-- Modal footer -->
            <div class="modal-footer" >
              <button type="button" class=" btn-muted" data-dismiss="modal">Close</button>
              <button type="button" class=" btn-primary" data-dismiss="modal">Xác nhận</button>
            </div>
      
          </div>
        </div>
      </div>

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
@endsection
