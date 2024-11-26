<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #e9ecef;
            border-radius: 5px;
        }

        .header {
            text-align: center;
            padding: 10px 0;
        }

        .header img {
            max-width: 150px;
        }

        .order-details {
            margin: 20px 0;
        }

        .order-details th,
        .order-details td {
            padding: 8px;
            border-bottom: 1px solid #e9ecef;
        }

        .order-details th {
            background-color: #f8f9fa;
        }

        .footer {
            text-align: center;
            padding: 20px 0;
            font-size: 14px;
            color: #6c757d;
        }
        .button {
            display: inline-block;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="header">
        <!-- <img src="{{ asset('assets/img/logo/logo.jpg.png') }}" alt="Logo"> <br> -->
        </div>
        <h2>Thư Xác Nhận Đơn Hàng</h2>
        <p>Gửi {{$order->name}},</p>
        <p>Cảm ơn khách hàng <b>{{$order->name}}</b> đã tin tưởng và đặt hàng tại shop chúng tôi - Đơn hàng đã được đặt thành công.</p>

        <p><a href="{{ route('confirm.order',['token'=> $order->token]) }}" class="button" style="color:white;">Xác nhận đơn hàng</a></p>
        <!-- <table class="table table-striped order-details">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Product 1</td>
                    <td>1</td>
                    <td>$50.00</td>
                </tr>
                <tr>
                    <td>Product 2</td>
                    <td>2</td>
                    <td>$30.00</td>
                </tr>
                <tr>
                    <td colspan="2" class="text-right"><strong>Total</strong></td>
                    <td><strong>$110.00</strong></td>
                </tr>
            </tbody>
        </table> -->

        <p>Nếu bạn có câu hỏi gì về sản phẩm hãy gửi mail về bvphuc2004@gmail.com để được shop hỗ trợ.</p>
        <p>Trân trọng,</p>
        <p>Bùi Văn Phúc - PS33476</p>
        <div class="footer">
            <p>&copy; 2024 ps33476 . Đã đăng ký bản quyền.</p>
        </div>
    </div>
</body>
</html>
