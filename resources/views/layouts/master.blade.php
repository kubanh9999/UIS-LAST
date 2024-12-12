<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('client/assets/css/bootstrap.min.css') }}" >
    <link rel="stylesheet" href="{{ asset('client/assets/css/base.css') }}">
    <link rel="stylesheet" href="{{ asset('client/assets/css/style.css') }}">
    <link rel="shortcut icon" href="{{asset('client/assets/img/uis.png')}}" type="image/x-icon">
  
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Uis Fruits</title>
</head>

<body>

    @include('layouts.header')
    
    <main>
        @yield('content')
        <script type="text/javascript">
            var Tawk_API = Tawk_API || {},
                Tawk_LoadStart = new Date();
    
            // Nạp Tawk.to script
            (function() {
                var s1 = document.createElement("script"),
                    s0 = document.getElementsByTagName("script")[0];
                s1.async = true;
                s1.src = 'https://embed.tawk.to/675279a74304e3196aed2379/1ied2mdor';
                s1.charset = 'UTF-8';
                s1.setAttribute('crossorigin', '*');
                s0.parentNode.insertBefore(s1, s0);
            })();
    
            // Khi Tawk.to sẵn sàng
            Tawk_API.onLoad = function() {
                fetch('/api/product-count')
                    .then(response => response.json())
                    .then(data => {
                        console.log('Số lượng sản phẩm ban đầu:', data.count);
    
                        // Cập nhật thuộc tính trên Tawk.to
                        Tawk_API.setAttributes({
                            productcount: data.count // Key không chứa ký tự đặc biệt
                        }, function(error) {
                            if (error) {
                                console.error('Tawk.to Error:', error);
                            }
                        });
                    })
                    .catch(error => console.error('Error fetching product count:', error));
            };
    
            // Cập nhật số lượng sản phẩm mỗi 60 giây
            setInterval(function() {
                if (Tawk_API && Tawk_API.setAttributes) {
                    fetch('/api/product-count')
                        .then(response => response.json())
                        .then(data => {
                            console.log('Số lượng sản phẩm cập nhật:', data.count);
    
                            // Cập nhật thuộc tính trên Tawk.to
                            Tawk_API.setAttributes({
                                productcount: data.count 
                               /*  console.log('productcount',productcount); */
                                // Key không chứa ký tự đặc biệt
                            }, function(error) {
                                if (error) {
                                    console.error('Tawk.to Error:', error);
                                }
                            });
                        })
                        .catch(error => console.error('Error fetching product count:', error));
                }
            }, 60000); // Cập nhật mỗi 60 giây
        </script>
        
    </main>

    @include('layouts.footer')

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
