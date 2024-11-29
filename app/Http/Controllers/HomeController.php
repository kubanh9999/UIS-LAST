<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Order;
use App\Models\ProductType;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    public function index()
    {
        $giftBaskets = ProductType::orderBy('created_at', 'desc')->limit(5)->get();
        $orders = Order::orderBy('created_at', 'desc')->get();
        $userId = Auth::id();
       
        $purchasedProductIds = Order::where('user_id', $userId)
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->pluck('order_details.product_id')->toArray();
        /*       dd($purchasedProductIds); */
        // Lấy danh mục của các sản phẩm mà người dùng đã mua
        $purchasedCategoryIds = Product::whereIn('id', $purchasedProductIds)
            ->pluck('category_id')->toArray();
        /*        dd($purchasedProductIds); */
        // Lấy các sản phẩm liên quan dựa trên danh mục
        $recommendedProducts = Product::whereIn('category_id', $purchasedCategoryIds)
            ->whereNotIn('id', $purchasedProductIds)
            ->take(12)
            ->get();
        /*    dd($recommendedProducts); */
        $newProducts = Product::select('products.id', 'products.name', 'products.price', 'products.image', 'products.stock', 'products.discount', 'categories.name as category_name')
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->where('products.created_at', '>=', now()->subDays(15)) // Chọn sản phẩm được tạo trong 30 ngày qua
        ->where('products.stock', '>', 0) // Chỉ lấy sản phẩm có số lượng tồn kho > 0
        ->orderBy('products.created_at', 'desc')
        ->take(5) // Lấy 5 sản phẩm mới nhất
        ->get();
    
    $newProductsGrouped = $newProducts->groupBy('category_name');
    $topProducts = Product::select('products.id', 'products.name', 'products.price', 'products.image', 'products.stock', 'products.discount', 'products.sales', 'categories.name as category_name')
    ->join('categories', 'products.category_id', '=', 'categories.id')
    ->where('products.sales', '>', 0)
    ->where('products.stock', '>', 0) // Chỉ lấy sản phẩm còn tồn kho
    ->orderBy('products.sales', 'desc') // Sắp xếp theo số lượng bán giảm dần
    ->take(5) // Lấy 5 sản phẩm bán chạy nhất
    ->get();

$topProductsGrouped = $topProducts->groupBy('category_name');

         /*    dd($newProducts); */
        // Sản phẩm bán chạy nhất (dựa trên số lượng bán từ bảng order_items)
        $topSellingProducts = Product::select(
            'products.id',
            'products.name',
            'products.price',
            'products.image',
            'products.stock',
            'products.discount',
            'categories.name as category_name' // Lấy tên danh mục và đặt tên là category_name
        )
            ->join('order_details', 'products.id', '=', 'order_details.product_id')
            ->join('categories', 'products.category_id', '=', 'categories.id') // Kết nối với bảng categories
            ->selectRaw('SUM(order_details.quantity) as total_sales')
            ->groupBy(
                'products.id',
                'products.name',
                'products.price',
                'products.image',
                'products.stock',
                'products.discount',
                'categories.name' // Đảm bảo group theo tên danh mục
            )
            ->orderBy('total_sales', 'desc')
            ->take(4)
            ->get();

            $categories = Category::all();
            $latestPost = DB::table('posts')->orderBy('created_at', 'desc')->first();
            $nextPosts = DB::table('posts')
            ->where('id', '!=', $latestPost->id) // Bỏ qua bài viết mới nhất
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
            $content = strip_tags($latestPost->content); // Xóa HTML tags
$words = explode(' ', $content); // Tách nội dung thành các từ
$limitedContent = implode(' ', array_slice($words, 0, 200));


// banner 

$mainBanners = DB::table('banners')
        ->where('type', 'main')
        ->orderBy('position', 'asc')  // Sắp xếp theo 'position' tăng dần
        ->get();
        
// Lấy banner thứ 2 (3 ảnh)
$secondaryBanners = DB::table('banners')->where('type', 'secondary')->orderBy('position')->get();

// Lấy banner thứ 3 (1 ảnh)
$tertiaryBanner = DB::table('banners')->where('type', 'third')->orderBy('position')->get();

        return view('pages.home', compact('newProducts', 'topSellingProducts', 'recommendedProducts', 'orders', 'giftBaskets', 'categories','latestPost','nextPosts','limitedContent','mainBanners','secondaryBanners','tertiaryBanner', 'topProducts','newProductsGrouped','topProductsGrouped'));
    }
    public function markAsRead($id)
    {
        return redirect()->back()->with('success', 'Thông báo đã được đánh dấu là đã đọc.');
    }

    public function showByCategory($id)
    {
        $categories = Category::all();

        $products = Product::where('category_id', $id)->paginate(6);

        return view('pages.product', compact('products', 'categories'));
    }

    public function selectFruits($id)
    {
        $basket = ProductType::findOrFail($id);
        $fruits = Product::all();

        return view('pages.custom-gift-basket', compact('basket', 'fruits'));
    }
    public function giftDetail($id)
    {
        $basket = DB::table('product_types')->where('id', $id)->first();
        $comments = Comment::with(['user', 'replies.user'])
        ->where('product_id', $id)
        ->where('status', '!=', 2 ) 
        ->whereNull('parent_id') 
        ->get();

        return view('pages.giftDetailt', compact('basket','comments'));
    }
    // Giới thiệu
    public function introduction()
    {

        return view('pages.introduction');
    }

    public function getProductsByCategory($categoryName)
    {
        $products = Product::select('id', 'name', 'price', 'image')
                            ->whereHas('category', function ($query) use ($categoryName) {
                                $query->where('name', $categoryName);
                            })
                            ->orderBy('created_at', 'desc')
                            ->take(5)
                            ->get();
    
        if ($products->isEmpty()) {
            return response()->json(['message' => 'Không có sản phẩm nào trong danh mục này.'], 404);
        }
    
        return response()->json($products);
    }
}
