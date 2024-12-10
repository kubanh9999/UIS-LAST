// ẩn topbar
window.onscroll = function() {
    let hiddenTopBar = document.getElementById('hidden-topbar');
    if (window.scrollY) {
        hiddenTopBar.classList.add('hidden');
    } else {
        hiddenTopBar.classList.remove('hidden');
    }
}

// banner khi mới vào trang web
document.addEventListener('DOMContentLoaded', function() {
    // Kiểm tra nếu người dùng đã truy cập trước đó
    if (!localStorage.getItem('bannerDisplayed')) {
        // Hiển thị overlay và banner
        const overlay = document.getElementById('overlay');
        const banner = document.getElementById('welcome-banner');

        overlay.style.display = 'block';
        banner.style.display = 'block';

        // Ẩn banner và overlay sau 5 giây
        setTimeout(function() {
            overlay.style.display = 'none';
            banner.style.display = 'none';
            localStorage.setItem('bannerDisplayed', 'true'); // Lưu trạng thái đã hiển thị
        }, 5000);

        // Khi người dùng đóng banner
        document.getElementById('close-banner').addEventListener('click', function() {
            overlay.style.display = 'none';
            banner.style.display = 'none';
            localStorage.setItem('bannerDisplayed', 'true'); // Lưu trạng thái đã hiển thị
        });
    }
});