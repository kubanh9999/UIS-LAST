@extends('admin.layout')
@section('content')
<style>
    /* Tạo kiểu cho select */
.status-select {
    width: 200px;
    padding: 8px 12px;
    font-size: 14px;
    border-radius: 5px;
    border: 1px solid #ccc;
    background-color: #f9f9f9;
    transition: border-color 0.3s ease, background-color 0.3s ease;
}

/* Khi người dùng hover vào select */
.status-select:hover {
    border-color: #4CAF50; /* Màu viền khi hover */
    background-color: #e8f5e9; /* Màu nền khi hover */
}

/* Khi select được chọn */
.status-select:focus {
    border-color: #4CAF50; /* Màu viền khi chọn */
    background-color: #ffffff;
    outline: none; /* Loại bỏ viền mặc định khi focus */
}

/* Style cho các option bên trong select */
.status-select option {
    padding: 8px 12px;
    font-size: 14px;
}

</style>
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>QUẢN LÝ ĐƠN HÀNG </h4>
                    {{-- <h6>View/Search product Category</h6>
                    <h6>Note Status: <strong>-1</strong> : Đã hủy / <strong>0</strong> : Đang xử lý / <strong>1</strong> : Đang vận chuyển / <strong>2</strong> : Đã nhận hàng</h6> --}}
                </div>
             
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
                                <th>Tên Khách Hàng</th>
                                <th>Ngày đặt hàng   </th>
                                <th>Phương Thức Thanh Toán</th>
                                <th>Trạng Thái</th>
                                <th>Chi Tiết</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $item)
                            <tr>
                                <td>
                                    <label class="checkboxs">
                                        <input type="checkbox">
                                        <span class="checkmarks"></span>
                                    </label>
                                </td>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->order_date }}</td>
                                <td>{{ $item->payment_method }}</td>
                                <td>
                                    <select name="status" class="status-select" data-order-id="{{ $item->id }}" onchange="updateOrderStatus(this)">
                                        <option value="Đang xử lý" {{ $item->status == 'Đang xử lý' ? 'selected' : '' }}>Đang xử lý</option>
                                        <option value="Đang vận chuyển" {{ $item->status == 'Đang vận chuyển' ? 'selected' : '' }}>Đang vận chuyển</option>
                                        <option value="Đã giao" {{ $item->status == 'Đã giao' ? 'selected' : '' }}>Đã giao</option>
                                        <option value="Hoàn thành" {{ $item->status == 'Hoàn thành' ? 'selected' : '' }}>Hoàn thành đơn hàng</option>
                                        <option value="Đã hủy" {{ $item->status == 'Đã hủy' ? 'selected' : '' }}>Đã hủy</option>
                                    </select>
                                </td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $item->id) }}"><i class="fa-solid fa-eye"></i></a>
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


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Hàm cập nhật trạng thái đơn hàng bằng AJAX
        function updateOrderStatus(selectElement) {
            const orderId = selectElement.getAttribute('data-order-id'); // Lấy ID đơn hàng
            const newStatus = selectElement.value; // Lấy trạng thái mới
    
            // Hiển thị hộp thoại xác nhận
            if (confirm(`Bạn có chắc chắn muốn chuyển trạng thái đơn hàng sang '${newStatus}' không?`)) {
                // Gửi request AJAX
                fetch(`/admin/orders/update-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({
                        id: orderId, // ID đơn hàng
                        status: newStatus, // Trạng thái mới
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Trạng thái đơn hàng đã được cập nhật thành công.');
                    } else {
                        alert('Có lỗi xảy ra khi cập nhật trạng thái.');
                        // Nếu lỗi, khôi phục lại trạng thái cũ
                        selectElement.value = selectElement.getAttribute('data-current-status');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Không thể kết nối tới server.');
                    // Khôi phục lại trạng thái cũ
                    selectElement.value = selectElement.getAttribute('data-current-status');
                });
            } else {
                // Hủy thay đổi, khôi phục lại trạng thái cũ
                selectElement.value = selectElement.getAttribute('data-current-status');
            }
        }
    
        // Hàm ẩn các option không phù hợp dựa trên trạng thái hiện tại
        function updateOptions(selectElement) {
            const selectedStatus = $(selectElement).val(); // Trạng thái hiện tại
    
            // Hiển thị tất cả các option
            $(selectElement).find('option').show();
    
            // Ẩn các trạng thái không phù hợp
            switch (selectedStatus) {
                case 'Đang xử lý':
                    $(selectElement).find('option[value="Đã giao"]').hide();
                    $(selectElement).find('option[value="Hoàn thành"]').hide();
                    break;
                case 'Đang vận chuyển':
                    $(selectElement).find('option[value="Đã hủy"]').hide();
                    $(selectElement).find('option[value="Đang xử lý"]').hide();
                    $(selectElement).find('option[value="Hoàn thành"]').hide();
                    break;
                case 'Đã giao':
                    $(selectElement).find('option[value="Đã hủy"]').hide();
                    $(selectElement).find('option[value="Đang vận chuyển"]').hide();
                    $(selectElement).find('option[value="Đang xử lý"]').hide();
                    $(selectElement).find('option[value="Hoàn thành"]').hide();
                    break;
                case 'Hoàn thành':
                    $(selectElement).find('option[value="Đã hủy"]').hide();
                    $(selectElement).find('option[value="Đang vận chuyển"]').hide();
                    $(selectElement).find('option[value="Đang xử lý"]').hide();
                    $(selectElement).find('option[value="Đã giao"]').hide();
                    break;
                case 'Đã hủy':
                    $(selectElement).find('option').not('[value="Đã hủy"]').hide();
                    break;
            }
        }
    
        // Sự kiện DOM Ready
        $(document).ready(function () {
            // Áp dụng logic ẩn option ban đầu
            $('.status-select').each(function () {
                updateOptions(this);
            });
    
            // Gắn sự kiện change chỉ một lần duy nhất với .one()
            $('.status-select').one('change', function () {
                // Cập nhật danh sách các option
                updateOptions(this);
    
                // Cập nhật trạng thái đơn hàng
                // updateOrderStatus(this);
            });
        });
    </script>

@endsection
