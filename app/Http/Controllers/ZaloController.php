<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product; // Import model của bạn
use App\Models\Category;
use GuzzleHttp\Client; // Đảm bảo bạn đã cài đặt GuzzleHTTP
class ZaloController extends Controller
{
    // Phương thức để lấy dữ liệu
    public function index()
    {
        $data = Product::all(); 
        return response()->json($data);
    }

    // Phương thức chi tiết sản phẩm
    public function categories()
    {
        $data = Category::all(); // Đảm bảo tên model là đúng (chữ 't' trong 'Product')
        return response()->json($data);
    }
    public function productsByCategory($categoryId)
    {
        $products = Product::where('category_id', $categoryId)->get(); // Lọc sản phẩm theo ID danh mục
        return response()->json($products);
    }
    
}

