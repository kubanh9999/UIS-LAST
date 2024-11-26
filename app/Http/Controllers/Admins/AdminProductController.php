<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use App\Models\ProductType;
use App\Models\ProductImage;
class AdminProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::orderBy('id', 'desc')->get();
        return view('admin.products.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    { $categories = Category::all();
        return view('admin.products.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'required|string',
           'product_image' => 'required|image|max:2048', // No trailing comma
    'child_images' => 'required|array|min:1', // Kiểm tra có ít nhất 1 ảnh con
    'child_images.*' => 'image|max:2048',
            'product_type' => 'required|string' // Kiểm tra loại sản phẩm (trái cây, giỏ quà)
        ]);

        // Lưu ảnh sản phẩm chính
        $productImage = null;
        if ($request->hasFile('product_image')) {
            // Lấy tên ảnh gốc
            $originalName = $request->file('product_image')->getClientOriginalName();
        
            // Lưu ảnh vào thư mục 'uploads/products' với tên gốc
            $productImage = $request->file('product_image')->storeAs('', $originalName, 'public');
        }
        // Nếu là giỏ quà, lưu vào bảng product_types
        if ($request->product_type === 'gift_basket') {
            try {
                // Lưu giỏ quà vào bảng product_types
                $giftBasket = ProductType::create([
                    'name' => $request->name,
                    'category_id' => $request->category_id,
                    'price_gift' => $request->price,
                    'description' => $request->description,
                    'image' => $productImage,
                ]);
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['error' => 'Lỗi khi thêm giỏ quà vào product_types: ' . $e->getMessage()]);
            }
            return redirect()->route('admin.products.index')->with('success', 'Giỏ quà đã được thêm thành công!');
        }

        // Nếu là trái cây, lưu vào bảng products
        try {
            $product = Product::create([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'price' => $request->price,
                'discount' => $request->discount,
                'stock' => $request->stock,
                'description' => $request->description,
                'image' => $productImage,
               // Trái cây không có product_type_id
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Thêm sản phẩm thất bại: ' . $e->getMessage()]);
        }

        // Lưu ảnh con cho sản phẩm trái cây
        if ($request->hasFile('child_images')) {
            foreach ($request->file('child_images') as $image) {
                $childImage = $image->store('uploads/products/child', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $childImage,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Trái cây đã được thêm thành công!');
    }



    public function edit($id)
    {
        // Lấy sản phẩm theo ID
        $product = Product::findOrFail($id);

        // Lấy danh sách danh mục để hiển thị trong dropdown
        $categories = Category::all();

        // Trả về view với sản phẩm và danh sách danh mục
        return view('admin.products.edit', compact('product', 'categories'));
    }
    public function updateField(Request $request){
        $product = Product::find($request->id);
        // Lấy tên trường và giá trị mới từ yêu cầu
        $field = $request->field;
        $value = $request->value;
        // Kiểm tra xem trường có thuộc `$fillable` hay không
        if (in_array($field, $product->getFillable()) && in_array($field, ['name', 'price', 'stock'])) {
            // Cập nhật giá trị trường và lưu sản phẩm
            $product->$field = $value;
            $product->save();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => 'Trường không hợp lệ']);
    }

    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'required|string',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'child_images' => 'nullable|array|size:3',
            'child_images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Cập nhật sản phẩm
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->price = $request->price;
        $product->discount = $request->discount;
        $product->stock = $request->stock;
        $product->description = $request->description;

        // Kiểm tra và lưu ảnh sản phẩm chính
        if ($request->hasFile('product_image')) {
            $productImage = $request->file('product_image')->store('upload', 'public');
            $product->image = $productImage;
        }

        $product->save();

        // Cập nhật ảnh con
        if ($request->hasFile('child_images')) {
            // Xóa ảnh cũ nếu cần
            ProductImage::where('product_id', $product->id)->delete();

            foreach ($request->file('child_images') as $image) {
                $childImage = $image->store('upload', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $childImage,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được cập nhật thành công!');
    }


    /**
     * Display the specified resource.
     */
    /**
 * Display the specified resource.
 */
public function show($id)
{
    // Eager load the productImages relationship
    $product = Product::with('productImages')->findOrFail($id);

    return view('admin.products.show', compact('product'));
}



    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */


    /**
     * Remove the specified resource from storage.
     */
public function destroy($id){
    try {
        $product = Product::findOrFail($id);

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được xóa thành công.');
    } catch (\Exception $e) {

        return redirect()->route('admin.products.index')->with('error', 'Không thể xóa sản phẩm.');
    }
}
public function updateStatus(Request $request)
{
    $order = Order::find($request->id);
    if ($order) {
        $order->status = $request->status;
        $order->save();

        return response()->json(['success' => true]);
    }
    return response()->json(['success' => false]);
}
function gift(){
    $ProductType = ProductType::orderBy('id', 'desc')->get();
    /* dd($ProductType); */
return view('admin.products.show_gift' ,compact('ProductType'));
}

}
