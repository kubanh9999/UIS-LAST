<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('client/assets/css/bootstrap.min.css') }}" >
    <link rel="stylesheet" href="{{ asset('client/assets/css/base.css') }}">
    <link rel="stylesheet" href="{{ asset('client/assets/css/style.css') }}">
    <link rel="shortcut icon" href="client/assets/img/uis.png" type="image/x-icon">
    <title>Uis Fruits</title>
</head>

<body>

    @include('layouts.header2')
    
    <main>
        @yield('content')
    </main>

    @include('layouts.footer2')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('client/assets/js/script.js') }}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="{{ asset('client/assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('client/assets/js/bootstrap.min.js') }}"></script>

    <script>
        fetch('/users/log-time', { // Thay đổi đường dẫn
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // CSRF token
            },
            body: JSON.stringify({
                duration: duration
            })
        });
        let startTime = new Date().getTime();

        // Gửi thời gian truy cập về server sau mỗi 30 giây
        setInterval(() => {
            let currentTime = new Date().getTime();
            let duration = Math.floor((currentTime - startTime) /
                1000); // Tính thời gian ở lại trang tính bằng giây

            fetch('/api/log-time', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Nếu bạn sử dụng CSRF
                },
                body: JSON.stringify({
                    duration: duration
                })
            });
        }, 30000); // Gửi mỗi 30 giây
    </script>
</body>

</html>
