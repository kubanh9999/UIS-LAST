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

        $orderCount = Order::where('status', 0)->count();

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
        /* 
                dd($monthlySales); */
        // Lấy danh sách sản phẩm
        $products_all = Product::all();
        $productIds = $products_all->pluck('id')->toArray(); // Lấy ID sản phẩm
        $productNames = $products_all->pluck('name')->toArray(); // Lấy tên sản phẩm

        // Chuẩn bị dữ liệu cho Google Charts
        $chartData = [];
        $chartData[] = ['Ngày', ...$productNames]; // Thêm tên sản phẩm vào mảng

        // Lấy tháng, năm hiện tại và số ngày trong tháng
        $currentMonth = date('m');
        $currentYear = date('Y');
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
        $days = range(1, $daysInMonth);
        $productIds = DB::table('products')->pluck('id'); // Lấy danh sách product_id

        // Truy vấn doanh thu hàng ngày
        $dailySales = DB::table('order_details')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->leftJoin('products', 'order_details.product_id', '=', 'products.id') // Join bảng products
            ->leftJoin('product_types', 'order_details.gift_id', '=', 'product_types.id') // Join bảng product_types
            ->select(
                DB::raw('DAY(orders.created_at) as day'),
                DB::raw('COALESCE(products.id, product_types.id) as product_id'), // Lấy id sản phẩm hoặc giỏ quà
                DB::raw('COALESCE(products.name, product_types.name) as product_name'), // Lấy tên sản phẩm hoặc giỏ quà
                DB::raw('SUM(order_details.total_price) as total_revenue')
            )
            ->whereYear('orders.created_at', $currentYear)
            ->whereMonth('orders.created_at', $currentMonth)
            ->groupBy(DB::raw('DAY(orders.created_at), COALESCE(products.id, product_types.id), COALESCE(products.name, product_types.name)')) // Cập nhật GROUP BY
            ->get()
            ->groupBy('day'); // Nhóm dữ liệu theo ngày

        $dailyRevenue = [];
        foreach ($dailySales as $day => $sales) {
            foreach ($sales as $sale) {
                $productId = $sale->product_id; // Lấy ID sản phẩm
                $revenue = $sale->total_revenue;
                $dailyRevenue[$day][$productId] = $revenue;
            }
        }

        $productIds = array_keys($dailyRevenue[array_key_first($dailyRevenue)]);  // Lấy danh sách sản phẩm từ doanh thu của ngày đầu tiên

        // Tạo header động cho biểu đồ (Ngày + các sản phẩm)
        $chartData = [];
        $header = ['Ngày'];  // Bắt đầu với cột "Ngày"
        foreach ($productIds as $productId) {
            // Kiểm tra trong bảng products
            $product = DB::table('products')->where('id', $productId)->first();

            if ($product) {
                // Nếu tìm thấy trong bảng products
                $header[] = "Sản phẩm: " . $product->name;
                continue; // Bỏ qua các bước kiểm tra tiếp theo
            }

            // Nếu không tìm thấy trong products, kiểm tra bảng product_types
            $gift = DB::table('product_types')->where('id', $productId)->first();

            if ($gift) {
                // Nếu tìm thấy trong bảng product_types
                $header[] = "Giỏ quà: " . $gift->name;
            } else {
                // Nếu không tìm thấy trong cả hai bảng, thay vì ID, bạn có thể hiển thị một thông báo hoặc xử lý thích hợp
                $header[] = "Không tìm thấy sản phẩm/giỏ quà (ID: " . $productId . ")";
            }
        }
        $chartData[] = $header;  // Thêm header vào dữ liệu
// Tạo dữ liệu cho các ngày
        foreach ($days as $day) {
            $row = [$day];  // Thêm ngày vào mảng
            foreach ($productIds as $productId) {
                $revenue = $dailyRevenue[$day][$productId] ?? 0;  // Doanh thu cho từng sản phẩm
                $row[] = $revenue;
            }
            $chartData[] = $row;  // Thêm dòng dữ liệu vào biểu đồ
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
        $Orders = Order::where('status', 0)->paginate(10);
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
