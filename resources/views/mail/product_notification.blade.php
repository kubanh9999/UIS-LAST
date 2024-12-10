<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giới Thiệu Sản Phẩm Mới</title>
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
            background-color: #28a745;
            color: #ffffff;
            border-radius: 5px 5px 0 0;
        }

        .header h1 {
            font-size: 24px;
            margin: 0;
        }

        .product-image {
            text-align: center;
            margin: 20px 0;
        }

        .product-image img {
            max-width: 100%;
            border-radius: 5px;
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
            <h2>Sản Phẩm Mới Từ UIS Fruits</h2>
            <p>Xin chào,</p>
            <p>Chúng tôi vui mừng giới thiệu đến bạn sản phẩm mới nhất của chúng tôi:</p>
            <p><strong>"{{ $product->name }}"</strong></p>
            <div class="product-image">
                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
            </div>
            <p> {!! $product->description !!}</p>
          
            <p>Giá chỉ: <strong>{{ number_format($product->price, 0, ',', '.') }} VNĐ</strong></p>
            <p>Hãy nhấn vào nút dưới đây để khám phá thêm và đặt hàng ngay:</p>
            <p style="text-align: center;">
                <a href="{{ route('product.detail', $product->id) }}">xem chi tiết</a>
            </p>
            <p>Chúng tôi hy vọng bạn sẽ yêu thích sản phẩm này. Nếu có bất kỳ câu hỏi nào, đừng ngần ngại liên hệ với chúng tôi qua email: <a href="mailto:uisfruits@gmail.com">uisfruits@gmail.com</a>.</p>
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
