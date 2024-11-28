@extends('admin.layout')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>DANH MỤC SẢN PHẨM </h4>
                    <h6>View/Search product Category</h6>
                    <h6>Note Status: <strong>-1</strong> : Đã hủy / <strong>0</strong> : Đang xử lý / <strong>1</strong> : Đang vận chuyển / <strong>2</strong> : Đã nhận hàng</h6>
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
                            <div class="search-path">
                                <a class="btn btn-success" id="filter_search">
                                    <img src="{{ asset('assets/img/icons/filter.svg') }}" alt="img">
                                
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
                                    <option value="-1" {{ $item->status == -1 ? 'selected' : '' }}>Đã hủy</option>
                                    <option value="0" {{ $item->status == 0 ? 'selected' : '' }}>Đang xử lý</option>
                                    <option value="1" {{ $item->status == 1 ? 'selected' : '' }}>Đang vận chuyển</option>
                                    <option value="2" {{ $item->status == 2 ? 'selected' : '' }}>Đã nhận hàng</option>
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



    <script>
    document.querySelectorAll('.editable-status').forEach(element => {
        element.addEventListener('click', function() {
            const currentText = this.innerText;
            const orderId = this.getAttribute('data-order-id');

            // Thay đổi span thành input
            const input = document.createElement('input');
            input.type = 'text';
            input.value = currentText;
            input.classList.add('status-input');
            this.innerHTML = '';
            this.appendChild(input);
            input.focus();

            // Khi người dùng bấm Enter hoặc click ra ngoài, cập nhật giá trị
            input.addEventListener('blur', function() {
                updateStatus(orderId, input.value, element);
            });

            input.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    updateStatus(orderId, input.value, element);
                }
            });
        });
    });

    function updateOrderStatus(selectElement) {
        const orderId = selectElement.getAttribute('data-order-id'); // Lấy ID đơn hàng
        const newStatus = selectElement.value; // Lấy trạng thái mới

        // Gửi request AJAX
        fetch(`/admin/orders/update-status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({
                id: orderId, // Gửi ID đơn hàng
                status: newStatus // Gửi trạng thái mới
            }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
            icon: 'success',
            title: 'Thành công!',
            text: 'Trạng thái đơn hàng đã được cập nhật.',
            showConfirmButton: false,
            timer: 1500
        });
            } else {
                Swal.fire({
            icon: 'error',
            title: 'Lỗi!',
            text: 'Có lỗi xảy ra khi cập nhật trạng thái.',
            showConfirmButton: true
        });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Không thể kết nối tới server.');
        });
}

</script>
@endsection
