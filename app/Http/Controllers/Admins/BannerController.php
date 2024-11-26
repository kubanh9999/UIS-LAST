<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
class BannerController extends Controller
{
    // Danh sách banner
    public function index()
    {
        $categories = Category::all();
        $banners = Banner::orderBy('id', 'asc')->get();
        return view('admin.banner.index', compact('banners','categories'));
    }

    // Hiển thị form thêm banner
    public function create()
    {
        $categories = Category::select('id', 'name')->get();
        return view('admin.banner.create', compact('categories'));
    }

    // Lưu banner mới
    public function store(Request $request): RedirectResponse
{
 /*  dd($request->all()); */
    // Kiểm tra nếu ảnh đã được tải lên
    if (!$request->hasFile('image_path')) {
        return redirect()->back()->withErrors(['image_path' => 'Không có file ảnh được tải lên!']);
    }
    
    // Thiết lập đường dẫn lưu trữ ảnh
    $uploadPath = $request->custom_path ?? 'layouts/img/banner';
   
    // Lưu ảnh vào thư mục chỉ định
    $fileName = $request->file('image_path')->getClientOriginalName();
  
    $request->file('image_path')->move(public_path($uploadPath), $fileName);

    // Đường dẫn tương đối của ảnh
    $relativePath = $uploadPath . '/' . $fileName;

    // Tự động tạo link nếu không có nhưng có danh mục
    $link = $request->link; // Liên kết tùy chọn
    if (!$link && $request->category_id) {
        $link = url('products/categorys/' . $request->category_id); // Tạo link theo category_id
    }

    // Lưu thông tin banner vào cơ sở dữ liệu
    Banner::create([
        'image_path' => $relativePath,
        'position' => $request->position, // Sử dụng $request->position
        'type' => $request->type, // Sử dụng $request->type
        'alt_text' => $request->alt_text, // Sử dụng $request->alt_text
        'link' => $link, // Lưu liên kết
        'category_id' => $request->category_id , // Lưu category_id
    ]);

    // Chuyển hướng với thông báo thành công
    return redirect()->route('admin.banners.management')->with('success', 'Banner được thêm thành công.');
}




    // Hiển thị form sửa banner
    public function edit($id)
    {
        $categories = Category::select('id', 'name')->get();
        $banner = Banner::findOrFail($id);
        return view('admin.banner.edit', compact('banner','categories'));
    }

    // Cập nhật banner
  // Controller
public function update(Request $request, $id)
{
    $request->validate([
        'position' => 'required|integer',
        'type' => 'required|string|max:255',
        'alt_text' => 'nullable|string|max:255',
        'image_path' => 'nullable|image|max:2048',
        'category_id' => 'nullable|integer', // Danh mục tùy chọn
        'link' => 'nullable|string|max:255', // Liên kết tùy chọn
    ]);

    // Tìm banner cần sửa
    $banner = Banner::findOrFail($id);

    // Đường dẫn upload ảnh
    $uploadPath = $request->custom_path ?? 'layouts/img/banner';

    // Xử lý upload ảnh mới (nếu có)
    if ($request->hasFile('image_path')) {
        // Kiểm tra và tạo thư mục nếu chưa tồn tại
        $fullUploadPath = public_path($uploadPath);
        if (!file_exists($fullUploadPath)) {
            if (!mkdir($fullUploadPath, 0777, true) && !is_dir($fullUploadPath)) {
                return back()->withErrors(['image_path' => 'Không thể tạo thư mục lưu trữ hình ảnh.']);
            }
        }

        // Di chuyển file vào thư mục
        $fileName = time() . '_' . $request->file('image_path')->getClientOriginalName();
        $request->file('image_path')->move($fullUploadPath, $fileName);

        // Lưu đường dẫn tương đối vào database
        $relativePath = $uploadPath . '/' . $fileName;
        $banner->image_path = $relativePath;
    }

    // Chỉ lấy ID của danh mục để tạo link
    $link = $request->link;
    if (!$link && $request->category_id) {
        $link = '/products/category/' . $request->category_id;
    }

    // Cập nhật thông tin banner
    $banner->position = $request->position;
    $banner->type = $request->type;
    $banner->alt_text = $request->alt_text;
    $banner->link = $link;
    $banner->category_id = $request->category_id;
    $banner->save();

    // Chuyển hướng với thông báo thành công
    return redirect()->route('admin.banners.management')->with('success', 'Banner được cập nhật thành công.');
}


    // Xóa banner
    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->delete();

        return redirect()->route('admin.banners.management')->with('success', 'Banner được xóa thành công.');
    }
}
