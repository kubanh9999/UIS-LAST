<!DOCTYPE html>
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
</html>