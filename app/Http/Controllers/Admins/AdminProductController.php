<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Mail\ProductNotificationMail;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use App\Models\ProductType;
use App\Models\ProductImage;
use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class AdminProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::orderBy('id', 'desc')->get();
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
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
            'product_image' => 'required|image|max:2048',
            'child_images' => 'required|array|min:1',
            'child_images.*' => 'image|max:2048',
            'product_type' => 'required|string',
            'upload_folder' => 'nullable|string', // Thêm tùy chọn để xác định thư mục
        ]);

        // Thư mục lưu trữ mặc định (nếu không được chỉ định)
        $uploadFolder = $request->input('upload_folder', 'uploads/products');

        // Lưu ảnh sản phẩm chính
        $productImage = null;
        if ($request->hasFile('product_image')) {
            // Lấy tên file gốc
            $fileName = $request->file('product_image')->getClientOriginalName();

            // Di chuyển file đến thư mục chỉ định
            $request->file('product_image')->move(public_path($uploadFolder), $fileName);

            // Đường dẫn tương đối để lưu vào DB
            $productImage = $uploadFolder . '/' . $fileName;
        }

        // Nếu là giỏ quà, lưu vào bảng product_types
        if ($request->product_type === 'gift_basket') {
            try {
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
            return redirect()->route('admin.products.gift')->with('success', 'Giỏ quà đã được thêm thành công!');
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
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Thêm sản phẩm thất bại: ' . $e->getMessage()]);
        }
        // Lấy email từ bảng subscribers và users và gửi email thông báo
        $subscribers = Subscriber::all(); // Lấy tất cả người đăng ký
        $users = User::all(); // Lấy tất cả người dùng

        // Gửi email đến tất cả người đăng ký
        foreach ($subscribers as $subscriber) {
            Mail::to($subscriber->email)->send(new ProductNotificationMail($product));
        }

        // Gửi email đến tất cả người dùng
        foreach ($users as $user) {
            Mail::to($user->email)->send(new ProductNotificationMail($product));
        }

        // Lưu ảnh con cho sản phẩm trái cây
        if ($request->hasFile('child_images')) {
            foreach ($request->file('child_images') as $image) {
                // Lấy tên file ảnh con
                $childFileName = $image->getClientOriginalName();

                // Di chuyển ảnh con đến thư mục con
                $image->move(public_path($uploadFolder . '/child'), $childFileName);

                // Đường dẫn tương đối để lưu vào DB
                $childImagePath = $uploadFolder . '/child/' . $childFileName;

                // Lưu ảnh con vào cơ sở dữ liệu
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $childImagePath,
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

    public function editGift($id)
    {
        // Lấy sản phẩm theo ID
        $gift = ProductType::findOrFail($id);

        // Lấy danh sách danh mục để hiển thị trong dropdown
        $categories = Category::all();

        // Trả về view với sản phẩm và danh sách danh mục
        return view('admin.products.editGift', compact('gift', 'categories'));
    }

    public function updateGift(Request $request, string $id)
    {

        $gift = ProductType::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'price_gift' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Cập nhật sản phẩm
        $gift->name = $request->name;
        $gift->category_id = $request->category_id;
        $gift->price_gift = $request->price_gift;
        $gift->stock = $request->stock;
        $gift->description = $request->description;

        // Kiểm tra và lưu ảnh sản phẩm chính
        if ($request->hasFile('image')) {
            $productImage = $request->file('image')->store('upload', 'public');
            $gift->image = $productImage;
        }

        $gift->save();


        return redirect()->route('admin.products.gift')->with('success', 'Giỏ quà đã được cập nhật thành công!');
    }

    public function updateField(Request $request)
    {
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
            'child_images' => 'nullable|array|min:1',
            'child_images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'upload_folder' => 'nullable|string', // Tùy chọn thư mục lưu trữ
        ]);

        // Cập nhật thông tin sản phẩm
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->price = $request->price;
        $product->discount = $request->discount;
        $product->stock = $request->stock;
        $product->description = $request->description;

        // Lấy thư mục upload, mặc định là 'uploads/products'
        $uploadFolder = $request->input('upload_folder', 'uploads/products');

        // Kiểm tra và cập nhật ảnh sản phẩm chính
        if ($request->hasFile('product_image')) {
            // Xóa ảnh cũ nếu có
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }

            // Lưu ảnh mới
            $fileName = $request->file('product_image')->getClientOriginalName();
            $request->file('product_image')->move(public_path($uploadFolder), $fileName);
            $product->image = $uploadFolder . '/' . $fileName;
        }

        $product->save();

        // Xử lý ảnh con
        if ($request->hasFile('child_images')) {
            // Xóa ảnh con cũ
            $oldChildImages = ProductImage::where('product_id', $product->id)->get();
            foreach ($oldChildImages as $oldImage) {
                if (file_exists(public_path($oldImage->image))) {
                    unlink(public_path($oldImage->image));
                }
            }
            ProductImage::where('product_id', $product->id)->delete();

            // Lưu ảnh con mới
            foreach ($request->file('child_images') as $image) {
                $childFileName = $image->getClientOriginalName();
                $image->move(public_path($uploadFolder . '/child'), $childFileName);
                $childImagePath = $uploadFolder . '/child/' . $childFileName;

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $childImagePath,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được cập nhật thành công!');
    }

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
    public function destroy($id)
    {
        try {
            // Tìm sản phẩm theo ID
            $product = Product::findOrFail($id);

            // Xử lý ảnh chính của sản phẩm
            $imagePath = $product->image; // Ảnh chính
            if ($imagePath && file_exists(public_path($imagePath))) {
                unlink(public_path($imagePath)); // Xóa ảnh chính
            }

            // Xử lý ảnh con của sản phẩm (giả sử bạn có bảng `product_images` lưu ảnh con)
            $childImages = $product->images; // Quan hệ tới bảng ảnh con
            if ($childImages) {
                foreach ($childImages as $childImage) {
                    $childImagePath = $childImage->path; // Đường dẫn của ảnh con
                    if ($childImagePath && file_exists(public_path($childImagePath))) {
                        unlink(public_path($childImagePath)); // Xóa ảnh con
                    }
                    // Xóa bản ghi ảnh con trong cơ sở dữ liệu
                    $childImage->delete();
                }
            }

            // Xóa sản phẩm khỏi cơ sở dữ liệu
            $product->delete();

            // Quay lại trang danh sách sản phẩm với thông báo thành công
            return redirect()->route('admin.products.index')->with('success', 'Sản phẩm và các ảnh liên quan đã được xóa thành công.');
        } catch (\Exception $e) {
            // Trường hợp có lỗi, quay lại với thông báo lỗi
            return redirect()->route('admin.products.index')->with('error', 'Không thể xóa sản phẩm.');
        }
    }
    public function destroyGift($id)
    {
        try {
            // Tìm giỏ quà theo ID
            $giftBasket = ProductType::findOrFail($id);

            // Xóa các ảnh liên quan nếu có (nếu cần)
            if (file_exists(public_path($giftBasket->image))) {
                unlink(public_path($giftBasket->image)); // Xóa ảnh sản phẩm
            }

            // Xóa giỏ quà
            $giftBasket->delete();

            return redirect()->route('admin.gift_baskets.index')->with('success', 'Giỏ quà đã được xóa thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Lỗi khi xóa giỏ quà: ' . $e->getMessage()]);
        }
    }



    public function updateStatus(Request $request)
    {
        // Các trạng thái hợp lệ
        $validStatuses = ['Đã hủy', 'Đang xử lý', 'Đang vận chuyển', 'Đã nhận hàng'];
        // Lấy đơn hàng từ ID
        $order = Order::find($request->id);
        if ($order) {
            // Kiểm tra nếu trạng thái hợp lệ
            if (in_array($request->status, $validStatuses)) {
                // Cập nhật trạng thái
                $order->status = $request->status;
                $order->save();
    
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false, 'message' => 'Trạng thái không hợp lệ']);
            }
        }
    
        return response()->json(['success' => false]);
    }
    
    function gift()
    {
        $ProductType = ProductType::orderBy('id', 'desc')->get();
        /* dd($ProductType); */
        return view('admin.products.show_gift', compact('ProductType'));
    }
}
