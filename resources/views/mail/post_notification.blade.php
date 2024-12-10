{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài viết mới từ UIS Fruits</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }
        h1 {
            color: #333;
            font-size: 24px;
            margin: 20px 0;
        }
        p {
            color: #666;
            font-size: 16px;
            line-height: 1.6;
        }
        .read {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            font-size: 16px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            text-align: center;
            transition: background-color 0.3s ease;
        }
        .read:hover {
            background-color: #0056b3;
        }
        .read:active {
            background-color: #003f8e;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <!-- Ảnh bài viết, kiểm tra đúng đường dẫn -->
            <img src="{{ asset($post->image) }}" alt="Post Image">
        </div>
        <h1>{{ $post->title }}</h1>
        <p>{!! $post->content !!}</p>
        <!-- Cập nhật link Đọc thêm với class 'read' -->
        <a href="{{ route('post.show', $post->id) }}" class="read">Đọc thêm</a>
    </div>
</body>
</html> --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Báo Bài Viết Mới</title>
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
            <h2>Bài Viết Mới Trên Website</h2>
            <p>Xin chào </p>
            <p>Chúng tôi vừa xuất bản một bài viết mới cực kỳ thú vị trên website! Bài viết sẽ cung cấp cho bạn thông tin hữu ích về:</p>
            <p><strong>"{{ $post->title }}"</strong></p>
       
            <p>Hãy nhấn vào nút dưới đây để đọc bài viết đầy đủ:</p>
            <p style="text-align: center;">
                <a href="{{ route('post.show', $post->id) }}" class="read " style="color: black; text-decoration: none">Xem Bài Viết</a>
            </p>
            <p>Chúng tôi hy vọng bạn sẽ yêu thích bài viết này. Nếu có bất kỳ câu hỏi hay góp ý nào, đừng ngần ngại liên hệ với chúng tôi qua email: <a href="mailto:uisfruits@gmail.com">uisfruits@gmail.com</a>.</p>
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
