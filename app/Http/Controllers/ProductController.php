<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Product;

use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class ProductController extends Controller
{

    public function index(Request $request)
{
    $categories = Category::all();

    // Bắt đầu query cho sản phẩm
    $products = Product::query();

    // Sắp xếp sản phẩm
    $sortOption = $request->input('sort', 'default');
    switch ($sortOption) {
        case 'asc':
            $products = $products->orderBy('price', 'asc');
            break;
        case 'desc':
            $products = $products->orderBy('price', 'desc');
            break;
        case 'newest':
            $products = $products->orderBy('created_at', 'desc');
            break;
        case 'oldest':
            $products = $products->orderBy('created_at', 'asc');
            break;
    }

    // Lọc sản phẩm theo giá
    $priceRange = $request->input('price');
    if ($priceRange) {
        switch ($priceRange) {
            case 'under_99000':
                $products = $products->where('price', '<', 99000);
                break;
            case '99000_201000':
                $products = $products->whereBetween('price', [99000, 201000]);
                break;
            case '201000_301000':
                $products = $products->whereBetween('price', [201000, 301000]);
                break;
            case '301000_501000':
                $products = $products->whereBetween('price', [301000, 501000]);
                break;
            case '501000_1000000':
                $products = $products->whereBetween('price', [501000, 1000000]);
                break;
            case 'above_1000000':
                $products = $products->where('price', '>', 1000000);
                break;
        }
    }


    $products = $products->paginate(12);

    // Lọc ProductType dựa trên sản phẩm đã lọc
    $productTypes = ProductType::whereHas('products', function ($query) use ($sortOption, $priceRange) {
        // Lặp lại điều kiện sắp xếp và lọc giá cho `ProductType`
        switch ($sortOption) {
            case 'asc':
                $query->orderBy('price', 'asc');
                break;
            case 'desc':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
        }

        if ($priceRange) {
            switch ($priceRange) {
                case 'under_99000':
                    $query->where('price', '<', 99000);
                    break;
                case '99000_201000':
                    $query->whereBetween('price', [99000, 201000]);
                    break;
                case '201000_301000':
                    $query->whereBetween('price', [201000, 301000]);
                    break;
                case '301000_501000':
                    $query->whereBetween('price', [301000, 501000]);
                    break;
                case '501000_1000000':
                    $query->whereBetween('price', [501000, 1000000]);
                    break;
                case 'above_1000000':
                    $query->where('price', '>', 1000000);
                    break;
            }
        }
    })->paginate(6); // Phân trang ProductType

    return view('pages.product', compact('products', 'categories', 'productTypes'));
}


public function showByCategory($id)
{
    // Lấy tất cả các danh mục
    $categories = Category::all();

    // Khởi tạo biến $productTypes mặc định là mảng rỗng
    $productTypes = collect();

    // Kiểm tra nếu id là 'all', tức là yêu cầu tất cả sản phẩm
    if ($id == 'all') {
        // Lấy tất cả sản phẩm và giỏ quà, chọn các cột giống nhau
        $products = DB::table('products')
                      ->select('id', 'name', 'price', 'image', 'category_id')  // Chọn các cột cần thiết từ bảng products
                      ->unionAll(
                          DB::table('product_types')
                             ->select('id', 'name', 'price_gift as price', 'image', 'category_id')  // Chọn các cột cần thiết từ bảng product_types
                      )
                      ->paginate(12);
    } else {
        // Lấy sản phẩm theo category_id và phân trang
        $products = DB::table('products')
                      ->where('category_id', $id)
                      ->paginate(12);

        // Lấy các loại sản phẩm thuộc category_id (giỏ quà)
        $productTypes = DB::table('product_types')
                          ->where('category_id', $id)
                          ->paginate(12);
                   /*        dd($productTypes); */
                         
    }
   
    // Truyền tất cả dữ liệu cần thiết vào view
    return view('pages.product', compact('products', 'categories', 'productTypes'));
}




    public function detail($id)
    {
        $product_detail = Product::with('category', 'images')->find($id);
    
        if (!$product_detail) {
            abort(404);
        }
    
        $userId = Auth::id(); // lấy ID của người dùng đã đăng nhập
    
        $approvedComments = Comment::where('product_id', $product_detail->id)
            ->where(function ($query) use ($userId) {
                $query->where('status', 1)
                    ->orWhere('user_id', $userId); 
            })
            ->whereNull('parent_id')
            ->with(['user', 'replies' => function ($query) use ($userId) {
                $query->where(function ($subQuery) use ($userId) {
                    $subQuery->where('status', 1)
                        ->orWhere('user_id', $userId); 
                })
                ->orderBy('created_at', 'desc');
            }])
            ->orderBy('created_at', 'desc')
            ->get();
    
        // Lấy các sản phẩm cùng danh mục
        $relatedProducts = Product::where('category_id', $product_detail->category_id)
                                  ->where('id', '!=', $id) // Loại bỏ sản phẩm hiện tại
                                  ->take(5) // Lấy 5 sản phẩm liên quan
                                  ->get();
    
        $sku = 'I' . str_pad($product_detail->id, 5, '0', STR_PAD_LEFT);
    
        return view('pages.productDetail', compact('product_detail', 'sku', 'approvedComments', 'relatedProducts'));
    }
    
    // Tìm kiếm sản phẩm 
    public function search(Request $request)
{
    $query = $request->input('query', ''); // Từ khóa tìm kiếm
    $sortOption = $request->input('sort', 'default'); // Tùy chọn sắp xếp
    $priceRange = $request->input('price'); // Phạm vi giá
    $categoryId = $request->input('category_id'); // Lọc theo danh mục

    // Lấy danh sách danh mục để hiển thị
    $categories = Category::all();

    // Bắt đầu query sản phẩm
    $products = Product::query();

    // Tìm kiếm theo từ khóa
    if (!empty($query)) {
        $products->where(function ($queryBuilder) use ($query) {
            $queryBuilder->where('name', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%");
        });
    }

    // Lọc theo danh mục
    if (!empty($categoryId)) {
        $products->where('category_id', $categoryId);
    }

    // Lọc sản phẩm theo giá
    if (!empty($priceRange)) {
        switch ($priceRange) {
            case 'under_99000':
                $products->where('price', '<', 99000);
                break;
            case '99000_201000':
                $products->whereBetween('price', [99000, 201000]);
                break;
            case '201000_301000':
                $products->whereBetween('price', [201000, 301000]);
                break;
            case '301000_501000':
                $products->whereBetween('price', [301000, 501000]);
                break;
            case '501000_1000000':
                $products->whereBetween('price', [501000, 1000000]);
                break;
            case 'above_1000000':
                $products->where('price', '>', 1000000);
                break;
        }
    }

    // Sắp xếp sản phẩm theo tùy chọn
    switch ($sortOption) {
        case 'asc':
            $products->orderBy('price', 'asc');
            break;
        case 'desc':
            $products->orderBy('price', 'desc');
            break;
        case 'newest':
            $products->orderBy('created_at', 'desc');
            break;
        case 'oldest':
            $products->orderBy('created_at', 'asc');
            break;
    }

    // Phân trang sản phẩm
    $products = $products->paginate(6);

    // Lọc ProductType giống như lọc Product
    $productTypes = ProductType::whereHas('products', function ($queryBuilder) use ($query, $categoryId, $priceRange) {
        // Tìm kiếm theo từ khóa
        if (!empty($query)) {
            $queryBuilder->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%");
            });
        }

        // Lọc theo danh mục
        if (!empty($categoryId)) {
            $queryBuilder->where('category_id', $categoryId);
        }

        // Lọc theo giá
        if (!empty($priceRange)) {
            switch ($priceRange) {
                case 'under_99000':
                    $queryBuilder->where('price', '<', 99000);
                    break;
                case '99000_201000':
                    $queryBuilder->whereBetween('price', [99000, 201000]);
                    break;
                case '201000_301000':
                    $queryBuilder->whereBetween('price', [201000, 301000]);
                    break;
                case '301000_501000':
                    $queryBuilder->whereBetween('price', [301000, 501000]);
                    break;
                case '501000_1000000':
                    $queryBuilder->whereBetween('price', [501000, 1000000]);
                    break;
                case 'above_1000000':
                    $queryBuilder->where('price', '>', 1000000);
                    break;
            }
        }
    });

    // Sắp xếp ProductType theo tùy chọn
    switch ($sortOption) {
        case 'asc':
            $productTypes->with(['products' => function ($query) {
                $query->orderBy('price', 'asc');
            }]);
            break;
        case 'desc':
            $productTypes->with(['products' => function ($query) {
                $query->orderBy('price', 'desc');
            }]);
            break;
        case 'newest':
            $productTypes->with(['products' => function ($query) {
                $query->orderBy('created_at', 'desc');
            }]);
            break;
        case 'oldest':
            $productTypes->with(['products' => function ($query) {
                $query->orderBy('created_at', 'asc');
            }]);
            break;
    }

    $productTypes = $productTypes->paginate(6); // Phân trang ProductType

    return view('pages.product', compact('products', 'categories', 'productTypes'))
        ->with('query', $query);
}

}
