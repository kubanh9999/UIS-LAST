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
        $salesData = DB::table('orders')
            ->select(
                DB::raw('MONTH(order_date) as month'),
                DB::raw('SUM(total_amount) as total_revenue')
            )
            ->whereYear('order_date', $currentYear)
            ->groupBy('month')
            ->get();
    
        // Cập nhật doanh thu cho các tháng có dữ liệu
        foreach ($salesData as $sale) {
            $monthlySales[$sale->month]['total'] += $sale->total_revenue;
        }
    
        // Lấy danh sách sản phẩm
    $products_all = Product::all();
    $productIds = $products_all->pluck('id')->toArray(); // Lấy ID sản phẩm
    
    // Lấy danh sách giỏ quà
    $productTypes_all = DB::table('product_types')->get();
    $productTypeIds = $productTypes_all->pluck('id')->toArray(); // Lấy ID giỏ quà
    
    // Kết hợp ID sản phẩm và ID giỏ quà vào cùng một mảng
    $productIds = array_merge($productIds, $productTypeIds);
    
    // Lấy tên sản phẩm
    $productNames = $products_all->pluck('name')->toArray(); // Lấy tên sản phẩm
    
    // Chuẩn bị dữ liệu cho Google Charts
    $chartData = [];
    $chartData[] = ['Ngày', ...$productNames]; // Thêm tên sản phẩm vào mảng
    
    // Lấy tháng, năm hiện tại và số ngày trong tháng
    $currentMonth = date('m');
    $currentYear = date('Y');
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
    $days = range(1, $daysInMonth);
    
    // Truy vấn doanh thu hàng ngày
    $dailySales = DB::table('order_details')
        ->join('orders', 'order_details.order_id', '=', 'orders.id')
        ->leftJoin('products', 'order_details.product_id', '=', 'products.id') // Join bảng products
        ->leftJoin('product_types', 'order_details.gift_id', '=', 'product_types.id') // Join bảng product_types
        ->select(
            DB::raw('DAY(orders.created_at) as day'), // Lấy ngày trong tháng
            DB::raw('COALESCE(products.id, product_types.id) as product_id'), // Lấy ID sản phẩm hoặc giỏ quà
            DB::raw('COALESCE(products.name, product_types.name) as product_name'), // Lấy tên sản phẩm hoặc giỏ quà
            DB::raw('SUM(order_details.total_price) as total_revenue') // Tính tổng doanh thu cho mỗi sản phẩm trong ngày
        )
        ->whereYear('orders.created_at', $currentYear)
        ->whereMonth('orders.created_at', $currentMonth)
        ->groupBy(DB::raw('DAY(orders.created_at), COALESCE(products.id, product_types.id), COALESCE(products.name, product_types.name)')) // Nhóm theo ngày và sản phẩm
        ->get()
        ->groupBy('day'); // Nhóm dữ liệu theo ngày
    
    // Cập nhật doanh thu cho các ngày
    $dailyRevenue = [];
    foreach ($dailySales as $day => $sales) {
        foreach ($sales as $sale) {
            $productId = $sale->product_id; // Lấy ID sản phẩm
            $revenue = $sale->total_revenue;
            $dailyRevenue[$day][$productId] = $revenue;
        }
    }
    
    // Đảm bảo rằng mỗi ngày đều có doanh thu cho tất cả các sản phẩm (bao gồm giỏ quà)
    foreach ($days as $day) {
        if (!isset($dailyRevenue[$day])) {
            $dailyRevenue[$day] = []; // Nếu không có doanh thu, tạo mảng trống
        }
    
        foreach ($productIds as $productId) {
            if (!isset($dailyRevenue[$day][$productId])) {
                $dailyRevenue[$day][$productId] = 0; // Gán doanh thu là 0 nếu không có dữ liệu
            }
        }
    }
    
    // Cập nhật chartData
    $chartData = [];
    $header = ['Ngày'];  // Bắt đầu với cột "Ngày"
    foreach ($productIds as $productId) {
        // Kiểm tra trong bảng products
        $product = DB::table('products')->where('id', $productId)->first();
    
        if ($product) {
            $header[] = "Sản phẩm: " . $product->name;
            continue;
        }
    
        // Kiểm tra trong bảng product_types (giỏ quà)
        $gift = DB::table('product_types')->where('id', $productId)->first();
        if ($gift) {
            $header[] = "Giỏ quà: " . $gift->name;
        } else {
            $header[] = "Không tìm thấy sản phẩm/giỏ quà (ID: " . $productId . ")";
        }
    }
    
    $chartData[] = $header;  // Thêm header vào dữ liệu
    
    foreach ($days as $day) {
        $row = [$day];  // Thêm ngày vào mảng
        foreach ($productIds as $productId) {
            $revenue = $dailyRevenue[$day][$productId] ?? 0;
            $row[] = $revenue;  // Doanh thu cho từng sản phẩm
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
    public function getOrderStats() {
        // Lấy số lượng đơn hàng theo từng trạng thái
        $orderStats = DB::table('orders')
        ->select(DB::raw('MONTH(created_at) as month'), 'status', DB::raw('count(*) as count'))
        ->whereYear('created_at', Carbon::now()->year)  // Lọc đơn hàng theo năm hiện tại
        ->groupBy(DB::raw('MONTH(created_at)'), 'status')
        ->orderBy(DB::raw('MONTH(created_at)'))
        ->get()
        ->map(function($item) {
            // Thay thế mã trạng thái với tên trạng thái
            switch ($item->status) {
                case 'Đã hủy':
                    $item->status = 'Đã hủy';
                    break;
                case 'Đang xử lý':
                    $item->status = 'Đang xử lý';
                    break;
                case 'Đang vận chuyển':
                    $item->status = 'Đang vận chuyển';
                    break;    
                case 'Hoàn thành':
                    $item->status = 'Hoàn thành';
                    break;
                case 'Đã giao':
                    $item->status = 'Đã giao';
                    break;
                default:
                    $item->status = 'Không xác định';
                    break;
            }
            return $item;
        });
    

return response()->json($orderStats);
    }
}
