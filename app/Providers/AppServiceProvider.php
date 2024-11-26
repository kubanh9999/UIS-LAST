<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
{
    // Chia sẻ biến $notifications cho tất cả các view
    View::composer('*', function ($view) {
        $notifications = [
            'orders' => [],
            'posts' => []
        ];

        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (Auth::check()) {
            // Lấy thông báo của người dùng đăng nhập
            $notifications['posts'] = Post::select('title', 'image')
            ->orderBy('created_at', 'desc')
            ->take(2) // Lấy 2 bài viết mới nhất
            ->get();
            // Lấy danh sách đơn hàng của người dùng hiện tại
            $orders = Order::where('user_id', Auth::id()) // Chỉ lấy đơn hàng của người dùng hiện tại
                ->orderBy('created_at', 'desc')
                ->get();

            // Xử lý thông báo cho từng đơn hàng
            foreach ($orders as $order) {
                switch ($order->status) {
                    case '1':
                        $order->message = "Đơn hàng của bạn đang được chuẩn bị.<br>Dự kiến vận chuyển vào " . \Carbon\Carbon::parse($order->shipping_date)->format('d/m/Y H:i');
                        break;
                    case '2':
                        $order->message = "Đơn hàng của bạn đang vận chuyển.<br>Dự kiến đến vào " . \Carbon\Carbon::parse($order->estimated_arrival)->format('d/m/Y H:i');
                        break;
                    case '3':
                        $order->message = "Đơn hàng của bạn đã bị trễ.<br>Chúng tôi xin lỗi vì sự bất tiện này.";
                        break;
                    case '4':
                        $order->message = "Đơn hàng của bạn đã được giao thành công.<br>Cảm ơn bạn đã mua sắm tại cửa hàng chúng tôi!";
                        break;
                    default:
                        $order->message = "Đang xử lý trạng thái đơn hàng.";
                        break;
                }
            }

            // Gán danh sách đơn hàng vào $notifications
            $notifications['orders'] = $orders;

            // Chia sẻ biến $notifications với tất cả view
            $view->with('notifications', $notifications);
        }
    });
}

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
