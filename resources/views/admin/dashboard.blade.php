@extends('admin.layout')

<style>
    .pagination-link {
        display: inline-block;
        background-color: #4CAF50;
        /* Màu xanh lá cây */
        color: white;
        /* Màu chữ */
        padding: 10px 15px;
        /* Khoảng cách trong */
        margin: 5px;
        /* Khoảng cách ngoài */
        text-decoration: none;
        /* Bỏ gạch chân */
        border-radius: 5px;
        /* Bo góc */
        transition: background-color 0.3s;
        /* Hiệu ứng chuyển màu */
    }

    .pagination-link:hover {
        background-color: #45a049;
        /* Màu xanh lá đậm khi hover */
    }

    .close-button {
        position: absolute;
        /* Thay đổi từ fixed sang absolute */
        bottom: 20px;
        /* Cách dưới cùng 20px */
        right: 20px;
        /* Cách bên phải 20px */
        background-color: #f44336;
        /* Màu đỏ */
        color: white;
        /* Màu chữ */
        border: none;
        /* Không viền */
        padding: 10px 15px;
        /* Khoảng cách trong */
        border-radius: 5px;
        /* Bo góc */
        cursor: pointer;
        /* Con trỏ chuột khi hover */
        z-index: 1000;
        /* Để nó ở trên cùng */
    }

    .close-button:hover {
        background-color: #d32f2f;
        /* Màu đỏ đậm khi hover */
    }

    .white {
        color: aliceblue;
    }
</style>
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="text-align: center">
        <strong><i class="fas fa-check-circle"></i> Thành công!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong><i class="fas fa-exclamation-circle"></i> Lỗi!</strong> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="row">
                @php
                    $dashboardItems = [
                        [
                            'count' => $userCount,
                            'label' => 'Người dùng',
                            'icon' => 'user',
                            'type' => 'user',
                            'route' => route('admin.users.index'),
                        ],
                        [
                            'count' => $productCount,
                            'label' => 'Sản phẩm',
                            'icon' => 'user-check',
                            'type' => 'product',
                            'route' => route('admin.products.index'),
                        ],
                        [
                            'count' => $discountCount,
                            'label' => 'Mã giảm giá',
                            'icon' => 'file-text',
                            'type' => 'discount',
                            'route' => route('admin.discount.index'),
                        ],
                        [
                            'count' => $orderCount,
                            'label' => 'Đơn hàng',
                            'icon' => 'file',
                            'type' => 'order',
                            'route' => route('admin.orders.index'),
                        ],
                    ];
                @endphp

                @foreach ($dashboardItems as $item)
                    <div class="col-lg-3 col-sm-6 col-12 d-flex">
                        <div class="dash-count" style="background: #45a049;color: aliceblue">
                            <div class="dash-counts">
                                <h4>{{ $item['count'] }}</h4>
                                <h5 style="color: white;">
                                    @if (isset($item['route']))
                                        <a href="{{ $item['route'] }}" style="color: white;">{{ $item['label'] }}</a>
                                    @else
                                        {{ $item['label'] }}
                                    @endif
                                </h5>
                            </div>
                            <div onclick="loadData('{{ $item['type'] }}')" class="white">
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
                    <button class="close-button" id="closeButton" onclick="toggleDataCard()">Đóng</button>
                    <!-- Đảm bảo nút ở đây -->
                </div>
            </div>

            <div class="row">
                <!-- Hai phần chung một hàng -->
                <div class="col-lg-7 col-md-7">
                    <div class="card">
                        <div class="card-body">
                            <div id="line_chart"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-5">
                    <div class="card">
                        <div class="card-body">
                            <div id="piechart_3d"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">

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
    google.charts.load("current", {
        packages: ["corechart"]
    });
    google.charts.setOnLoadCallback(drawChart);

    // Hàm vẽ biểu đồ
    google.charts.load("current", {
        packages: ["corechart"]
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        // Gọi API lấy dữ liệu từ backend
        fetch('/api/order-stats') // Địa chỉ API bạn đã tạo ở trên
            .then(response => response.json())
            .then(data => {
                // Chuyển đổi dữ liệu từ backend thành định dạng Google Charts
                var chartData = [
                    ['Status', 'Number of Orders']
                ];
                data.forEach(function(orderStat) {
                    chartData.push([orderStat.status, orderStat.count]);
                });

                // Tạo dữ liệu cho biểu đồ
                var dataTable = google.visualization.arrayToDataTable(chartData);

                // Tùy chọn cho biểu đồ
                var options = {
                    title: 'tổng đơn hàng trong 1 tháng',
                    is3D: true,
                    trigger: 'both', // Hiển thị tooltip khi hover và khi chọn
                    textStyle: {
                        fontSize: 14,
                        color: 'black'
                    }
                    // Hiển thị tooltip khi hover
                };

                // Tạo biểu đồ
                var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));

                // Vẽ biểu đồ
                chart.draw(dataTable, options);

                // Tùy chỉnh để hiển thị số lượng khi hover

            })
            .catch(error => console.error('Error fetching data: ', error));
    }
    //line
    google.charts.load('current', {
        packages: ['corechart']
    });
    google.charts.setOnLoadCallback(drawLineChart);

    function drawLineChart() {
        var data = google.visualization.arrayToDataTable([
            ['Tháng', 'Doanh thu'],
            @foreach ($monthlySales as $sale)
                ['Tháng {{ $sale['month'] }}', {{ $sale['total'] }}],
            @endforeach
        ]);
        /* console.log('data',data); */

        var options = {
            title: 'Tổng doanh thu hàng tháng trong năm',
            curveType: 'function',
            legend: {
                position: 'bottom'
            },
            hAxis: {
                title: 'Tháng',
                showTextEvery: 1,
                textStyle: {
                    fontSize: 12,
                    bold: true,
                    color: '#000'
                }
            },
            vAxis: {
                title: 'Doanh thu',
                minValue: 0,
                format: 'currency',
                textStyle: {
                    fontSize: 12,
                    color: '#000'
                }
            },
            chartArea: {
                width: '80%',
                height: '70%'
            },
            colors: ['#1b9e77'],
            pointSize: 5
        };

        var chart = new google.visualization.LineChart(document.getElementById('line_chart'));
        chart.draw(data, options);
    }
    google.charts.load('current', {
        packages: ['corechart']
    });
    google.charts.setOnLoadCallback(drawBarChart);

    function drawBarChart() {
        google.charts.load('current', {
            packages: ['corechart']
        });

        // Thiết lập callback để vẽ biểu đồ khi thư viện được tải
        google.charts.setOnLoadCallback(drawBarChart);

        // Hàm vẽ biểu đồ
        function drawBarChart() {
            google.charts.load('current', {
                packages: ['corechart']
            });

            google.charts.setOnLoadCallback(drawBarChart);

            function drawBarChart() {
                // Dữ liệu truyền từ PHP, cần đảm bảo rằng $chartData đã đúng cấu trúc (mảng 2 chiều)
                var data = google.visualization.arrayToDataTable(<?php echo json_encode($chartData); ?>);

                // Kiểm tra dữ liệu trên console để đảm bảo đúng cấu trúc
                console.log('Dữ liệu cho biểu đồ:', data);

                // Tùy chọn hiển thị biểu đồ
                var options = {
                    title: 'Doanh thu theo từng sản phẩm mỗi ngày trong 1 tháng',
                    isStacked: true, // Tùy chọn xếp chồng các giá trị
                    bar: {
                        groupWidth: '75%'
                    },
                    hAxis: {
                        title: 'Ngày',
                        textStyle: {
                            fontSize: 8
                        },
                        slantedText: true,
                        slantedTextAngle: 45 // Xoay trục ngang để dễ đọc hơn
                    },
                    vAxis: {
                        title: 'Giá trị',
                        textStyle: {
                            fontSize: 8
                        },
                    },
                    legend: {
                        position: 'top',
                        textStyle: {
                            fontSize: 10
                        }
                    },
                    chartArea: {
                        width: '120%', // Mở rộng chiều rộng
                        height: '75%'
                    },
                    width: 1400,
                    height: 700,
                    colors: ['#4CAF50', '#FFC107', '#2196F3'],
                    animation: {
                        startup: true,
                        duration: 1000,
                        easing: 'out'
                    }
                };

                // Tạo biểu đồ cột và vẽ nó lên trong phần tử có id 'bar_chart'
                var chart = new google.visualization.ColumnChart(document.getElementById('bar_chart'));
                chart.draw(data, options);



            }

            function drawTableChart() {
                google.charts.load('current', {
                    packages: ['table']
                });
                google.charts.setOnLoadCallback(function() {
                    var data = google.visualization.arrayToDataTable(<?php echo json_encode($chartData); ?>);

                    var options = {
                        showRowNumber: true,
                        width: '100%',
                        height: '100%'
                    };

                    var table = new google.visualization.Table(document.getElementById('bar_chart'));
                    table.draw(data, options);
                });
            }
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
                                   
                                    <td>${item.stock}</td>
                                    <td>${item.created_at}</td>
                                </tr>`;
                            break;
                        case 'order':
                            let statusClass = '';
                            let statusText = item
                                .status; // Mặc định hiển thị status như bình thường

                            // Xử lý trạng thái nếu status = 0
                            if (item.status == 0) {
                                statusText = 'Đang xử lý';
                                statusClass = 'text-warning'; // Thêm lớp CSS để đổi màu
                            } else if (item.status == 1) {
                                statusText = 'Đã hoàn thành';
                                statusClass = 'text-success'; // Thêm lớp CSS để đổi màu
                            }
                            row = `
                                <tr>
                                    <td>${item.id}</td>
                                    <td>${item.name}</td>
                                    <td>${item.phone}</td>
                                    <td>${statusText}</td>
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
                    pagination +=
                        `<a class="pagination-link" href="javascript:void(0);" onclick="loadData('${type}', ${i})">${i}</a>`;
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
