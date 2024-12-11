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
    public function searchFruits(Request $request)
    {
        $query = $request->get('query', '');

        $fruits = Product::where('name', 'LIKE', "%{$query}%")->get();

        // Xử lý dữ liệu trả về
        $fruits = $fruits->map(function ($fruit) {
            $imagePath = $fruit->image;

            // Kiểm tra nếu ảnh không chứa 'uploads/products'
            if (strpos($imagePath, 'uploads/products') === false) {
                $imagePath = asset('layouts/img/' . $fruit->image); // Thêm đường dẫn layouts/img
            } else {
                $imagePath = asset($fruit->image); // Dùng trực tiếp đường dẫn hiện tại
            }

            return [
                'id' => $fruit->id,
                'name' => $fruit->name,
                'price' => $fruit->price,
                'price_formatted' => number_format($fruit->price, 0, ',', '.'),
                'image' => $imagePath,
            ];
        });

        // Trả dữ liệu dạng JSON
        return response()->json($fruits);
    }

    public function index(Request $request)
    {
        // Lấy danh sách tất cả danh mục
        $categories = Category::all();

        // Bắt đầu query cho sản phẩm
        $products = Product::query();

        // 1. Lọc sản phẩm theo danh mục
        $categoryId = $request->input('category');
        if ($categoryId) {
            $products = $products->where('category_id', $categoryId);
        }

        // 2. Lọc sản phẩm theo mức giá
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

        // 3. Sắp xếp sản phẩm
        $sortOption = $request->input('sort', 'default'); // Mặc định không sắp xếp
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

        // Phân trang sản phẩm
        $products = $products->paginate(12);

        // Lấy danh sách ProductType (nếu cần)
        $productTypes = ProductType::whereHas('products', function ($query) use ($categoryId, $priceRange, $sortOption) {
            if ($categoryId) {
                $query->where('category_id', $categoryId);
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
        })->paginate(6);

        // Trả về view với dữ liệu
        return view('pages.product2', compact('products', 'categories', 'productTypes'));
    }


    public function showByCategory(Request $request, $id)
    {
        // Lấy tất cả các danh mục
        $categories = Category::all();
        $productTypes = collect(); // Khởi tạo collection rỗng

        // Xây dựng query sản phẩm
        $productsQuery = DB::table('products')
            ->select('id', 'name', 'price', 'image', 'category_id','sales');

        if ($id == 'all') {
            // Kết hợp bảng product_types mà không cần lọc giá
            $productTypesQuery = DB::table('product_types')
            ->select('id', 'name', 'price_gift as price', 'image', 'category_id', DB::raw('NULL as sales'));

            // Lọc theo giá cho products nếu có
            if ($request->has('price')) {
                $priceRange = $request->input('price');
                switch ($priceRange) {
                    case 'under_99000':
                        $productsQuery->where('price', '<', 99000);
                        break;
                    case '99000_201000':
                        $productsQuery->whereBetween('price', [99000, 201000]);
                        break;
                    case '201000_301000':
                        $productsQuery->whereBetween('price', [201000, 301000]);
                        break;
                    case '301000_501000':
                        $productsQuery->whereBetween('price', [301000, 501000]);
                        break;
                    case '501000_1000000':
                        $productsQuery->whereBetween('price', [501000, 1000000]);
                        break;
                    case 'above_1000000':
                        $productsQuery->where('price', '>', 1000000);
                        break;
                }
            }

            // Sắp xếp cho products nếu có
            if ($request->has('sort')) {
                $sortOption = $request->input('sort');
                switch ($sortOption) {
                    case 'asc':
                        $productsQuery->orderBy('price', 'asc');
                        break;
                    case 'desc':
                        $productsQuery->orderBy('price', 'desc');
                        break;
                    case 'newest':
                        $productsQuery->orderBy('id', 'desc');
                        break;
                    case 'oldest':
                        $productsQuery->orderBy('id', 'asc');
                        break;
                }
            }

            // Kết hợp query giữa products và product_types
            $unionQuery = $productsQuery->unionAll($productTypesQuery);

            // Tạo query tổng hợp
            $products = DB::table(DB::raw("({$unionQuery->toSql()}) as aggregate_table"))
                ->mergeBindings($productsQuery) // Liên kết bindings với products
                ->mergeBindings($productTypesQuery) // Liên kết bindings với product_types
                ->select('*');
        } else {
            // Lọc theo danh mục (category_id)
            $productsQuery->where('category_id', $id);

            // Lọc giỏ quà theo category_id
            $productTypesQuery = DB::table('product_types')
                ->where('category_id', $id);

            // Lọc theo giá cho giỏ quà
            if ($request->has('price')) {
                switch ($request->input('price')) {
                    case 'under_99000':
                        $productTypesQuery->where('price_gift', '<', 99000);
                        break;
                    case '99000_201000':
                        $productTypesQuery->whereBetween('price_gift', [99000, 201000]);
                        break;
                    case '201000_301000':
                        $productTypesQuery->whereBetween('price_gift', [201000, 301000]);
                        break;
                    case '301000_501000':
                        $productTypesQuery->whereBetween('price_gift', [301000, 501000]);
                        break;
                    case '501000_1000000':
                        $productTypesQuery->whereBetween('price_gift', [501000, 1000000]);
                        break;
                    case 'above_1000000':
                        $productTypesQuery->where('price_gift', '>', 1000000);
                        break;
                }
            }

            // Sắp xếp giỏ quà
            if ($request->has('sort')) {
                switch ($request->input('sort')) {
                    case 'asc':
                        $productTypesQuery->orderBy('price_gift', 'asc');
                        break;
                    case 'desc':
                        $productTypesQuery->orderBy('price_gift', 'desc');
                        break;
                    case 'newest':
                        $productTypesQuery->orderBy('id', 'desc');
                        break;
                    case 'oldest':
                        $productTypesQuery->orderBy('id', 'asc');
                        break;
                }
            }

            // Lấy giỏ quà
            $productTypes = $productTypesQuery->get();

            // Kết hợp kết quả
            $products = $productsQuery;
        }

        // Lọc theo giá cho sản phẩm nếu có
        if ($request->has('price')) {
            switch ($request->input('price')) {
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

        // Sắp xếp nếu có yêu cầu
        if ($request->has('sort')) {
            switch ($request->input('sort')) {
                case 'asc':
                    $products->orderBy('price', 'asc');
                    break;
                case 'desc':
                    $products->orderBy('price', 'desc');
                    break;
                case 'newest':
                    $products->orderBy('id', 'desc');
                    break;
                case 'oldest':
                    $products->orderBy('id', 'asc');
                    break;
            }
        }

        // Phân trang sản phẩm
        $products = $products->paginate(12);

        // Truyền dữ liệu vào view
        return view('pages.product2', compact('products', 'categories', 'productTypes'));
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

        return view('pages.product-detail', compact('product_detail', 'sku', 'approvedComments', 'relatedProducts'));
    }

    // Tìm kiếm sản phẩm 
    public function search(Request $request)
{
    $query = $request->input('query', ''); // Từ khóa tìm kiếm sản phẩm
    $sortOption = $request->input('sort', 'default'); // Tùy chọn sắp xếp
    $priceRange = $request->input('price'); // Phạm vi giá
    $categoryId = $request->input('category_id'); // Lọc theo danh mục
    $giftBasketQuery = $request->input('gift_basket'); // Tìm kiếm giỏ quà

    // Lấy danh sách danh mục
    $categories = Category::all();

    // Truy vấn sản phẩm
    $products = Product::query();

    // Tìm kiếm sản phẩm theo từ khóa
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

    // Lọc theo giá
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

    // Sắp xếp sản phẩm
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

    // Chỉ thực thi truy vấn giỏ quà nếu có tham số gift_basket
    $productTypes = collect(); // Tạo collection rỗng mặc định
    if (!empty($giftBasketQuery)) {
        $productTypes = ProductType::query()
            ->where(function ($queryBuilder) use ($giftBasketQuery) {
                $queryBuilder->where('name', 'like', "%{$giftBasketQuery}%")
                    ->orWhere('description', 'like', "%{$giftBasketQuery}%");
            })
            ->when($categoryId, function ($queryBuilder) use ($categoryId) {
                $queryBuilder->where('category_id', $categoryId);
            })
            ->when($priceRange, function ($queryBuilder) use ($priceRange) {
                switch ($priceRange) {
                    case 'under_99000':
                        $queryBuilder->whereHas('products', function ($query) {
                            $query->where('price', '<', 99000);
                        });
                        break;
                    case '99000_201000':
                        $queryBuilder->whereHas('products', function ($query) {
                            $query->whereBetween('price', [99000, 201000]);
                        });
                        break;
                    case '201000_301000':
                        $queryBuilder->whereHas('products', function ($query) {
                            $query->whereBetween('price', [201000, 301000]);
                        });
                        break;
                    case '301000_501000':
                        $queryBuilder->whereHas('products', function ($query) {
                            $query->whereBetween('price', [301000, 501000]);
                        });
                        break;
                    case '501000_1000000':
                        $queryBuilder->whereHas('products', function ($query) {
                            $query->whereBetween('price', [501000, 1000000]);
                        });
                        break;
                    case 'above_1000000':
                        $queryBuilder->whereHas('products', function ($query) {
                            $query->where('price', '>', 1000000);
                        });
                        break;
                }
            })
            ->when($sortOption, function ($queryBuilder) use ($sortOption) {
                switch ($sortOption) {
                    case 'asc':
                        $queryBuilder->orderBy('name', 'asc');
                        break;
                    case 'desc':
                        $queryBuilder->orderBy('name', 'desc');
                        break;
                    case 'newest':
                        $queryBuilder->orderBy('created_at', 'desc');
                        break;
                    case 'oldest':
                        $queryBuilder->orderBy('created_at', 'asc');
                        break;
                }
            })
            ->paginate(6);
    }

    return view('pages.product2', compact('products', 'categories', 'productTypes'))
        ->with('query', $query);
}



public function deleteCategory($categoryId)
{
    // Tìm danh mục cần xóa
    $category = Category::find($categoryId);

    if ($category) {
        // Xóa tất cả sản phẩm thuộc danh mục này
        $category->products()->delete();

        // Xóa danh mục
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Danh mục và sản phẩm đã được xóa!');
    }

    return redirect()->route('categories.index')->with('error', 'Danh mục không tồn tại!');
}

}