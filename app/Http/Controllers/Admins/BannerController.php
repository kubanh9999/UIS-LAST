<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;

use Illuminate\Http\RedirectResponse;
class BannerController extends Controller
{
    // Danh sách banner
    public function index()
    {
        $categories = Category::all();
        $mainBanners = Banner::where('type', 'main')->orderBy('position', 'asc')->get();
        $secondaryBanners = Banner::where('type', 'secondary')->orderBy('position', 'asc')->get();
        $thirdBanners = Banner::where('type', 'third')->orderBy('position', 'asc')->get();
        return view('admin.banner.index', compact('mainBanners','secondaryBanners','thirdBanners','categories'));
    }

    // Hiển thị form thêm banner
    public function create()
    {
        $categories = Category::select('id', 'name')->get();
        $products = Product::select('id', 'name')->get();
        return view('admin.banner.create', compact('categories','products'));
    }

    // Lưu banner mới
    public function store(Request $request): RedirectResponse
    {
        // Xác thực dữ liệu
        $validated = $request->validate([
            'image_path' => 'required|image',
            'position' => 'required|integer',
            'type' => 'required|string',
            'alt_text' => 'nullable|string',
            'link_type' => 'required|string|in:custom,category',  // Thêm điều kiện link_type có thể là 'custom' hoặc 'category'
            'custom_link' => 'nullable|required_if:link_type,custom|url', // Kiểm tra nếu link_type là custom thì custom_link là bắt buộc
            'category_id' => 'nullable|integer|exists:categories,id', // Kiểm tra tồn tại category_id
        ]);
    
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
    
        // Xác định giá trị liên kết
        $link = null;
        if ($validated['link_type'] === 'custom') {
            $link = $validated['custom_link'];  // Lấy liên kết tùy ý
        } elseif ($validated['link_type'] === 'category' && isset($validated['category_id'])) {
            // Tạo liên kết từ danh mục
            $link = url('products/categorys/' . $validated['category_id']);
        } else {
            // Nếu không có category_id và không phải link tùy chỉnh, bạn có thể gán một liên kết mặc định
            $link = 'default-link';  // Ví dụ, bạn có thể gán một giá trị mặc định
        }
    
        // Lưu thông tin banner vào cơ sở dữ liệu/-strong/-heart:>:o:-((:-h Banner::create([
            Banner::create([
                'image_path' => $relativePath,
                'position' => $validated['position'],
                'type' => $validated['type'],
                'alt_text' => $validated['alt_text'],
                'link' => $link,
                'category_id' => $validated['category_id'] ?? null,  // Chỉ lưu category_id nếu có
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
      // Xác thực dữ liệu đầu vào
      $request->validate([
          'position' => 'required|integer', // Vị trí (số nguyên)
          'type' => 'required|string|max:255', // Loại banner
          'alt_text' => 'nullable|string|max:255', // Mô tả (không bắt buộc)
          'image_path' => 'nullable|image|max:2048', // Hình ảnh (không bắt buộc, kích thước tối đa 2MB)
          'category_id' => 'nullable|integer', // Danh mục (không bắt buộc)
          'link' => 'nullable|string|max:255', // Liên kết (không bắt buộc)
      ]);
  
      // Tìm banner cần sửa theo ID
      $banner = Banner::findOrFail($id);
  
      // Đường dẫn thư mục lưu trữ ảnh (mặc định là 'layouts/img/banner')
      $uploadPath = $request->custom_path ?? 'layouts/img/banner';
  
      // Xử lý upload ảnh mới (nếu có)
      if ($request->hasFile('image_path')) {
          // Kiểm tra và tạo thư mục lưu trữ nếu chưa tồn tại
          $fullUploadPath = public_path($uploadPath);
          if (!file_exists($fullUploadPath)) {
              if (!mkdir($fullUploadPath, 0777, true) && !is_dir($fullUploadPath)) {
                  return back()->withErrors(['image_path' => 'Không thể tạo thư mục lưu trữ hình ảnh.']);
              }
          }
  
          // Di chuyển file vào thư mục và lưu tên file vào database
          $fileName = time() . '_' . $request->file('image_path')->getClientOriginalName();
          $request->file('image_path')->move($fullUploadPath, $fileName);
  
          // Lưu đường dẫn tương đối vào database
          $relativePath = $uploadPath . '/' . $fileName;
          $banner->image_path = $relativePath;
      }
  
      // Xử lý link (nếu có)
      $link = $request->link;
      if (!$link && $request->category_id) {
          // Nếu không có liên kết tùy ý, tạo liên kết từ danh mục
          $link = '/products/category/' . $request->category_id;
      }
  
      // Cập nhật thông tin banner/-strong/-heart:>:o:-((:-h $banner->position = $request->position;
      $banner->type = $request->type;
      $banner->position = $request->position; 
      $banner->alt_text = $request->alt_text;
      $banner->link = $link;
      $banner->category_id = $request->category_id;
      $banner->save();
  
      // Chuyển hướng với thông báo thành công
      return redirect()->route('admin.banners.management')->with('success', 'Banner đã được cập nhật thành công.');
  }
  


    // Xóa banner
    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->delete();

        return redirect()->route('admin.banners.management')->with('success', 'Banner được xóa thành công.');
    }
}