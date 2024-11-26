@extends('admin.layout')

<style>
  
    .pagination-link {
        display: inline-block;
        background-color: #4CAF50; /* Màu xanh lá cây */
        color: white; /* Màu chữ */
        padding: 10px 15px; /* Khoảng cách trong */
        margin: 5px; /* Khoảng cách ngoài */
        text-decoration: none; /* Bỏ gạch chân */
        border-radius: 5px; /* Bo góc */
        transition: background-color 0.3s; /* Hiệu ứng chuyển màu */
    }

    .pagination-link:hover {
        background-color: #45a049; /* Màu xanh lá đậm khi hover */
    }
    .close-button {
        position: absolute; /* Thay đổi từ fixed sang absolute */
    bottom: 20px; /* Cách dưới cùng 20px */
    right: 20px; /* Cách bên phải 20px */
    background-color: #f44336; /* Màu đỏ */
    color: white; /* Màu chữ */
    border: none; /* Không viền */
    padding: 10px 15px; /* Khoảng cách trong */
    border-radius: 5px; /* Bo góc */
    cursor: pointer; /* Con trỏ chuột khi hover */
    z-index: 1000; /* Để nó ở trên cùng */
    }

    .close-button:hover {
        background-color: #d32f2f; /* Màu đỏ đậm khi hover */
    }
</style>

@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="row">
                @php
                    $dashboardItems = [
                        ['count' => $userCount, 'label' => 'Người dùng', 'icon' => 'user', 'type' => 'user', 'route' => route('admin.users.index')],
                        ['count' => $productCount, 'label' => 'Sản phẩm', 'icon' => 'user-check', 'type' => 'product', 'route' => route('admin.products.index')],
                        ['count' => $discountCount, 'label' => 'Mã giảm giá', 'icon' => 'file-text', 'type' => 'discount','route' => route('admin.discount.index')],
                        ['count' => $orderCount, 'label' => 'Đơn hàng', 'icon' => 'file', 'type' => 'order', 'route' => route('admin.orders.index')],
                    ];
                @endphp
            
                @foreach ($dashboardItems as $item)
                    <div class="col-lg-3 col-sm-6 col-12 d-flex">
                        <div class="dash-count" style="background: #45a049">
                            <div class="dash-counts">
                                <h4>{{ $item['count'] }}</h4>
                                <h5>
                                    @if (isset($item['route']))
                                        <a href="{{ $item['route'] }}">{{ $item['label'] }}</a>
                                    @else
                                        {{ $item['label'] }}
                                    @endif
                                </h5>
                            </div>
                            <div onclick="loadData('{{ $item['type'] }}')" class="dash-imgs">
                                <i data-feather="{{ $item['icon'] }}"></i>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>        
                
            <div class="card mb-0" id="dataCard" style="display: none">
                <div class="card-body">
                    <h4 class="card-title">danh sách</h4>
                    <div class="table-responsive dataview">
                        <table class="table datatable">
                            <thead id="tableHeaders"></thead>
                            <tbody id="tableData"></tbody>
                        </table>
                        <div id="pagination" style="margin-top: 10px;"></div>
                    </div>
                    <button class="close-button" id="closeButton" onclick="toggleDataCard()">Đóng</button> <!-- Đảm bảo nút ở đây -->
                </div>
            </div>
           

            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div id="line_chart"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div id="bar_chart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection


<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
    google.charts.load('current', { packages: ['corechart'] });
    google.charts.setOnLoadCallback(drawLineChart);

    function drawLineChart() {
        var data = google.visualization.arrayToDataTable([
            ['Tháng', 'Doanh thu'],
            @foreach ($monthlySales as $sale)
                ['Tháng {{ $sale['month'] }}', {{ $sale['total'] }}],
            @endforeach
        ]);

        var options = {
            title: 'Doanh thu hàng tháng trong năm',
            curveType: 'function',
            legend: { position: 'bottom' },
            hAxis: {
                title: 'Tháng',
                showTextEvery: 1,
                textStyle: { fontSize: 12, bold: true, color: '#000' }
            },
            vAxis: {
                title: 'Doanh thu',
                minValue: 0,
                format: 'currency',
                textStyle: { fontSize: 12, color: '#000' }
            },
            chartArea: { width: '80%', height: '70%' },
            colors: ['#1b9e77'],
            pointSize: 5
        };

        var chart = new google.visualization.LineChart(document.getElementById('line_chart'));
        chart.draw(data, options);
    }
    google.charts.load('current', {packages: ['corechart']});
    google.charts.setOnLoadCallback(drawBarChart);

    function drawBarChart() {
        google.charts.load('current', { packages: ['corechart'] });

// Thiết lập callback để vẽ biểu đồ khi thư viện được tải
google.charts.setOnLoadCallback(drawBarChart);

// Hàm vẽ biểu đồ
function drawBarChart() {
    // Dữ liệu truyền từ PHP
    var data = google.visualization.arrayToDataTable(<?php echo json_encode($chartData); ?>);
console.log(data);

    // Tùy chọn hiển thị biểu đồ
    var options = {
        title: 'Doanh thu theo từng sản phẩm mỗi tháng',
        hAxis: {
            title: 'Ngày',
            textStyle: { fontSize: 10 }, // Kích thước chữ trục X nhỏ hơn để dễ đọc
            slantedText: true, // Góc nghiêng cho chữ trên trục X nếu có nhiều dữ liệu
            slantedTextAngle: 45 // Góc nghiêng
        },
        vAxis: {
            title: 'Giá trị',
            textStyle: { fontSize: 10 }, // Kích thước chữ trục Y nhỏ hơn
            scaleType: 'log', // Sử dụng scale logarithmic nếu giá trị chênh lệch quá lớn
        },
        legend: {
            position: 'top',
            textStyle: { fontSize: 10 } // Kích thước chữ chú thích nhỏ hơn
        },
        chartArea: {
            width: '85%', // Vùng hiển thị biểu đồ
            height: '75%' // Tăng chiều cao của vùng hiển thị biểu đồ
        },
        bar: {
            groupWidth: '70%' // Giảm bớt groupWidth (giảm 150% xuống còn 70%) để các cột vừa phải
        },
        width: 1200, // Chiều rộng biểu đồ (tăng để có thêm không gian cho nhiều cột)
        height: 700, // Chiều cao biểu đồ
        colors: ['#4CAF50', '#FFC107', '#2196F3'], // Màu sắc cột
        animation: {
            startup: true, // Hiệu ứng khi tải biểu đồ
            duration: 1000, // Thời gian hiệu ứng
            easing: 'out' // Kiểu hiệu ứng
        }
    };

    // Tạo biểu đồ cột và vẽ
    var chart = new google.visualization.ColumnChart(document.getElementById('bar_chart'));
    chart.draw(data, options);
}


}

    function loadData(type, page = 1) {
        let url = '';
        let title = '';
        let headers = '';
        const baseUrl = "{{ asset('layouts/img') }}";
        switch (type) {
            case 'user':
                url = `/admin/dashboard/get-users?page=${page}`;
                title = 'Danh sách Người dùng đăng ký trong 7 ngày qua';
                headers = `
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Ngày tạo</th>
                    </tr>`;
                break;
            case 'product':
                url = '/admin/dashboard/get-products?page=' + page;
                title = 'Danh sách Sản phẩm sắp hết hàng ';
                headers = `
                    <tr>
                        <th>ID</th>
                        <th>Tên sản phẩm</th>
                        <th>Hình ảnh</th>
                        <th>Giá</th>
                        <th>Giảm giá</th>
                        <th>Tồn kho</th>
                        <th>Ngày tạo</th>
                    </tr>`;
                break;
            case 'order':
                url = '/admin/dashboard/get-orders?page=' + page;
                title = 'Danh sách người dùng mới mua hàng';
                headers = `
                    <tr>
                        <th>ID</th>
                        <th>Tên người mua</th>
                        <th>Số điện thoại</th>
                        <th>Trạng thái</th>
                        <th>Phương thức thanh toán</th>
                        <th>Tổng tiền</th>
                        <th>Ngày tạo đơn</th>
                    </tr>`;
                break;
            case 'discount':
                url = '/admin/dashboard/get-discounts?page=' + page;
                title = 'Danh sách Khuyến mãi sắp hết hạn';
                headers = `
                    <tr>
                        <th>ID</th>
                        <th>Mã khuyến mãi</th>
                        <th>Mô tả</th>
                        <th>Phần trăm giảm</th>
                        <th>Ngày bắt đầu</th>
                        <th>Ngày kết thúc</th>
                    </tr>`;
                break;
        }
        document.querySelector('.card-title').innerHTML = title;
        $('#tableHeaders').html(headers);
        $('#formTitle').text(title);

        $('#tableData').empty();

        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
                $('#tableData').empty(); 
                response.data.forEach(function(item) {
                    let row = '';

                    switch (type) {
                        case 'user':
                            row = `
                                <tr>
                                    <td>${item.id}</td>
                                    <td>${item.name}</td>
                                    <td>${item.email}</td>
                                    <td>${item.phone}</td>
                                    <td>${item.created_at}</td>
                                </tr>`;
                            break;
                        case 'product':
                            row = `
                                <tr>
                                    <td>${item.id}</td>
                                    <td>${item.name}</td>
                                    <td><img src="${baseUrl}/${item.image}" alt="image" width="50"></td>
                                    <td>${Math.round(item.price).toLocaleString('vi-VN')} VND</td>
                                    <td>${item.discount}</td>
                                    <td>${item.stock}</td>
                                    <td>${item.created_at}</td>
                                </tr>`;
                            break;
                        case 'order':
                            row = `
                                <tr>
                                    <td>${item.id}</td>
                                    <td>${item.name}</td>
                                    <td>${item.phone}</td>
                                    <td>${item.status}</td>
                                    <td>${item.payment_method}</td>
                                    <td>${item.total_amount}</td>
                                    <td>${item.created_at}</td>
                                </tr>`;
                            break;
                        case 'discount':
                            row = `
                                <tr>
                                    <td>${item.id}</td>
                                    <td>${item.code}</td>
                                    <td>${item.description}</td>
                                    <td>${item.discount_percent}</td>
                                    <td>${item.valid_form}</td>
                                    <td>${item.valid_end}</td>
                                </tr>`;
                            break;
                    }

                    $('#tableData').append(row);
                });

                // Xử lý phân trang
                let pagination = '';
                for (let i = 1; i <= response.last_page; i++) {
                    pagination += `<a class="pagination-link" href="javascript:void(0);" onclick="loadData('${type}', ${i})">${i}</a>`;
                }
                $('#pagination').html(pagination);

                $('#dataCard').show(); // Hiện card dữ liệu
            },
            error: function() {
                alert('Lỗi trong việc tải dữ liệu');
            }
        });
    }

    function toggleDataCard() {
        $('#dataCard').toggle(); // Chuyển đổi hiển thị của card dữ liệu
    }
</script>
