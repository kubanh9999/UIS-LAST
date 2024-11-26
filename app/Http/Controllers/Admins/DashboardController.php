<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Discount;
use App\Models\Order;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB; // Đảm bảo đã import DB

class DashboardController extends Controller
{
    public function __invoke()
    {

        // Đếm số lượng người dùng, sản phẩm, giảm giá, và đơn hàng
        $userCount = User::where('created_at', '>=', Carbon::now()->subDays(7))->count();

        $productCount = Product::where('stock', '<=', 20)->count();

        $discountCount = Discount::whereDate('valid_end', '>=', Carbon::now())
            ->whereDate('valid_end', '<=', Carbon::now()->addDays(7))
            ->count();

        $orderCount = Order::where('status', 'đang xử lý')->count();

        // Biểu đồ doanh thu hàng tháng
        $monthlySales = [];
        $currentYear = date('Y');

        // Khởi tạo mảng với doanh thu bằng 0 cho tất cả 12 tháng
        for ($month = 1; $month <= 12; $month++) {
            $monthlySales[$month] = [
                'month' => $month,
                'total' => 0,
            ];
        }

        // Lấy doanh thu từ cơ sở dữ liệu
        $salesData = DB::table('order_details')
            ->select(
                DB::raw('MONTH(orders.created_at) as month'), // Lấy tháng từ created_at
                DB::raw('SUM(order_details.total_price) as total_revenue')
            )
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->whereYear('orders.created_at', $currentYear) // Lọc theo năm
            ->groupBy('month') // Nhóm theo tháng
            ->get();

        // Cập nhật doanh thu cho các tháng có dữ liệu
        foreach ($salesData as $sale) {
            $monthlySales[$sale->month]['total'] += $sale->total_revenue;
        }

        // Chuyển đổi dữ liệu về dạng mảng để sử dụng trong view
        $monthlySales = array_values($monthlySales);

        // Lấy danh sách sản phẩm
        $products_all = Product::all();
        $productIds = $products_all->pluck('id')->toArray(); // Lấy ID sản phẩm
        $productNames = $products_all->pluck('name')->toArray(); // Lấy tên sản phẩm

        // Chuẩn bị dữ liệu cho Google Charts
        $chartData = [];
        $chartData[] = ['Ngày', ...$productNames]; // Thêm tên sản phẩm vào mảng

        // Lấy doanh thu theo ngày trong tháng
        $currentMonth = date('m'); // Lấy tháng hiện tại
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear); // Lấy số ngày trong tháng
        $days = range(1, $daysInMonth); // Mảng chứa ngày từ 1 đến số ngày trong tháng

        // Tạo dữ liệu cho biểu đồ doanh thu hàng ngày
        $dailySales = DB::table('order_details')
            ->select(
                DB::raw('DAY(orders.created_at) as day'),
                'order_details.product_id',
                DB::raw('SUM(order_details.total_price) as total_revenue')
            )
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->whereYear('orders.created_at', $currentYear) // Lọc theo năm
            ->whereMonth('orders.created_at', $currentMonth) // Lọc theo tháng
            
            ->groupBy('day', 'order_details.product_id') // Nhóm theo ngày và product_id
            ->get();
            

        // Khởi tạo mảng doanh thu hàng ngày
        $dailyRevenue = [];
        foreach ($dailySales as $sale) {
            $dailyRevenue[$sale->day][$sale->product_id] = $sale->total_revenue;
          /*   dd($dailyRevenue); */
        }

        // Tạo dữ liệu cho biểu đồ theo ngày
        foreach ($days as $day) {
            $row = [$day];
            foreach ($productIds as $productId) {
                // Lấy doanh thu cho sản phẩm theo ngày
                $revenue = $dailyRevenue[$day][$productId] ?? 0; // Lấy doanh thu hoặc 0 nếu không có dữ liệu
                
                $row[] = $revenue;
            }
            $chartData[] = $row; // Thêm dữ liệu vào mảng
        }

        return view('admin.dashboard', compact('userCount', 'productCount', 'discountCount', 'orderCount', 'monthlySales', 'chartData'));
    }

    public function getUsers()
    {
        $users = User::where('created_at', '>=', Carbon::now()->subDays(7))
            ->where('role', '!=', 1) // Loại bỏ người dùng có role = 1
            ->paginate(10);

        return response()->json($users);
    }
    public function getProducts()
    {
        $Products = Product::where('stock', '<=', 20)->paginate(10);
        return response()->json($Products);
    }
    public function getOrder()
    {
        $Orders = Order::where('status', 'đang xử lý')->paginate(10);
        return response()->json($Orders);
    }
    public function getDiscounts()
    {
        $discounts = Discount::whereDate('valid_end', '>=', Carbon::now())
            ->whereDate('valid_end', '<=', Carbon::now()->addDays(7))
            ->paginate(10);

        return response()->json($discounts);
    }
}
