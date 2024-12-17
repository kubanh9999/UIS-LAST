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
            padding: 20px 0;
            height: 50px;
            background-color: #28a745;
            color: #ffffff;
            border-radius: 5px 5px 0 0;
        }

        .header img {
            max-width: 120px;
            margin-bottom: 10px;
        }

        .header h1 {
            font-size: 24px;
            margin: 0;
        }

        .content {
            padding: 20px 0;
        }

        .content h2 {
            color: #28a745;
        }

        .button {
            display: inline-block;
            background-color: #28a745;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 4px;
            margin: 20px 0;
        }

        .footer {
            text-align: center;
            padding: 20px 0;
            font-size: 14px;
            color: #6c757d;
            background-color: #f8f9fa;
            border-top: 1px solid #e9ecef;
            border-radius: 0 0 5px 5px;
        }

        .footer a {
            color: #28a745;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="header">
          <h1>UIS Fruits</h1>
         
        </div>
        <div class="content">
            <h2>Chúc Mừng Bạn Đã Đặt Hàng Thành Công!</h2>
            <p>Xin chào <strong>{{$order->name}}</strong>,</p>
            <p>Cảm ơn bạn đã lựa chọn <strong>UIS Fruits</strong> cho nhu cầu mua sắm trái cây của mình. Chúng tôi rất vui khi được phục vụ bạn!</p>
            <p>Thông tin đơn hàng của bạn đã được ghi nhận thành công. Để xác nhận đơn hàng, vui lòng nhấn vào nút bên dưới:</p>
            <p style="text-align:center">
                <a href="{{ route('confirm.order', ['token' => $order->token]) }}" class="button" style="color: #fff; ">Xem đơn hàng </a>
            </p>
            <p>Nếu bạn có bất kỳ thắc mắc hoặc yêu cầu hỗ trợ nào, đừng ngần ngại liên hệ với chúng tôi qua email: <a href="mailto:uisfruits@gmail.com">uisfruits@gmail.com</a>.</p>
            <p>Một lần nữa, cảm ơn bạn đã tin tưởng UIS Fruits. Chúng tôi mong chờ được phục vụ bạn trong tương lai!</p>
            <p>Trân trọng,</p>
            <p><strong>Đội ngũ UIS Fruits</strong></p>
        </div>
        <div class="footer">
            <p>&copy; 2024 UIS FRUITS. Đã đăng ký bản quyền.</p>
            <p><a href="#">Chính sách bảo mật</a> | <a href="#">Điều khoản dịch vụ</a></p>
        </div>
    </div>
</body>

</html>
