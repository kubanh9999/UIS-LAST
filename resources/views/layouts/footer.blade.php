{{-- <style>
    html, body {
    height: 100%;
    margin: 0;
    display: flex;
    flex-direction: column;
}

.content {
    flex: 1;
}

footer {
    margin-top: auto;
}

</style> --}}

<footer class="footer">
    <div class="container">
        <div class="swapper">
            <div class="inner-box">
                <a href="">
                    <img src="{{asset('client/assets/img/logo3.png')}}" alt="logo">
                </a>
                <p class="inner-text">Cửa hàng <b>uis</b> là một website cung cấp thực phẩm an toàn, nông sản sạch
                    cho người
                    dân</p>
                    <ul class="inner-list">
                        <li><i class="fas fa-map-marker-alt"></i> Công viên phần mềm Quang Trung TPHCM</li>
                        <li><i class="fas fa-phone"></i> 1900 6750</li>
                    </ul>
            </div>
            <div class="inner-box">
                <h5 class="title">Về UIS FRUITS</h5>
                <ul class="inner-list">
                    <li><a href="">Trang chủ</a></li>
                    <li><a href="">Sản phẩm</a></li>
                    <li><a href="">Về chúng tôi</a></li>
                    <li><a href="">Liên hệ</a></li>
                </ul>
            </div>
            <div class="inner-box">
                <h5 class="title">Hỗ trợ khách hàng</h5>
                <ul class="inner-list">
                    <li>Chính sách giao hàng</li>
                    <li>Chính sách đổi trả</li>
                    <li>Chính sách thành viên</li>
                    <li>Hướng dẫn mua hàng đổi hàng</li>
                </ul>
            </div>
            <div class="inner-box">
                <h5 class="title">Đăng ký nhận tin</h5>
                <p>Nhận thông tin khuyến mãi</p>
                <form class="input-group" method="POST" action="{{ route('subscribe') }}">
                    @csrf <!-- Token bảo mật của Laravel -->
                    <input type="email" class="form-control" name="email" placeholder="Email" required>
                    <button class="btn" type="submit">Đăng ký</button>
                </form>
            </div>            
        </div>
    </div>
    <div class="copyright">
        <p>&copy; Bản quyền thuộc về Team Uis </p>
    </div>
</footer>