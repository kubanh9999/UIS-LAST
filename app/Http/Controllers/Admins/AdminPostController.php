<?php

namespace App\Http\Controllers\Admins;

use App\Models\Post;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::all();
        $post = Post::all();

        return view('admin.posts.index', compact('post', 'category'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = Category::all();
        return view('admin.posts.create', compact('category'));
    }
    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads', $fileName, 'public');

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('storage/' . $filePath);
            $msg = 'Tải lên thành công!';

            // Trả về URL cho CKEditor
            return "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Lưu ảnh vào thư mục tùy chỉnh (nếu có ảnh được tải lên)
        $thumbnailPath = null;
        if ($request->hasFile('image')) {
            // Lấy tên file gốc
            $originalFileName = $request->file('image')->getClientOriginalName();
            // Tạo tên file duy nhất để tránh trùng
            $uniqueFileName = time() . '_' . preg_replace('/\s+/', '_', $originalFileName);
            // Xác định thư mục lưu ảnh (bạn có thể thay đổi thư mục này)
            $uploadFolder = 'uploads/posts';
            // Lưu ảnh vào thư mục đã chỉ định
            $request->file('image')->move(public_path($uploadFolder), $uniqueFileName);    
            // Đường dẫn ảnh để lưu vào cơ sở dữ liệu
            $thumbnailPath = $uploadFolder . '/' . $uniqueFileName;
        }
    
        // Tạo bài viết mới và lưu vào cơ sở dữ liệu
        $post = new Post();
        $post->title = $request->input('title');
        $post->category_id = $request->input('category_id');
        $post->content = $request->input('content');
        $post->image = $thumbnailPath;
        $post->status = $request->input('status');
        $post->user_id = Auth::id(); // Lấy ID người dùng hiện tại
        $post->save();
    
        // Chuyển hướng về danh sách bài viết với thông báo thành công
        return redirect()->route('admin.post.index')->with('success', 'Bài viết đã được tạo thành công!');
    }
    

    /**
     * Display the specified resource.
     */
    public function edit($id)
    {
        // Lấy bài viết theo ID
        $post = Post::findOrFail($id);
        $categories = Category::all();
        // Trả về view chỉnh sửa bài viết
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    // Cập nhật bài viết
    public function update(Request $request, $id)
    {
        // Lấy bài viết cần cập nhật
        $post = Post::findOrFail($id);

        // Xử lý file hình ảnh nếu có
        $thumbnailPath = $post->image; // Giữ nguyên hình ảnh cũ nếu không tải ảnh mới

        if ($request->hasFile('image')) {
            // xóa ảnh cũ
            if ($thumbnailPath && file_exists(public_path($thumbnailPath))) {
                unlink(public_path($thumbnailPath));
            }
            // Lấy tên file gốc
            $originalFileName = $request->file('image')->getClientOriginalName();
            // Tạo tên file duy nhất để tránh trùng
            $uniqueFileName = time() . '_' . preg_replace('/\s+/', '_', $originalFileName);
            // Xác định thư mục lưu ảnh (bạn có thể thay đổi thư mục này)
            $uploadFolder = 'uploads/posts';
            // Lưu ảnh vào thư mục đã chỉ định
            $request->file('image')->move(public_path($uploadFolder), $uniqueFileName);    
            // Đường dẫn ảnh để lưu vào cơ sở dữ liệu
            $thumbnailPath = $uploadFolder . '/' . $uniqueFileName;
        }

        // Cập nhật các trường thông tin bài viết
        $post->title = $request->input('title');
        $post->category_id = $request->input('category_id');
        $post->content = $request->input('content');
        $post->image = $thumbnailPath;
        $post->status = $request->input('status'); // Trực tiếp gán status từ request
        $post->user_id = Auth::id(); // Lấy ID người dùng hiện tại
        $post->save();

        // Chuyển hướng về danh sách bài viết với thông báo thành công
        return redirect()->route('admin.post.index')->with('success', 'Bài viết đã được cập nhật thành công!');
    }
    function show($id)
    {
        $post = Post::findOrFail($id);

        // Trả về view hiển thị bài viết xem trước
        return view('admin.posts.show', compact('post'));
    }
    /**
     * Update the specified resource in storage.
     */

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Tìm bài viết theo ID, nếu không tìm thấy sẽ trả về lỗi 404
        $post = Post::findOrFail($id);
        $thumbnailPath = $post->image;
        if ($thumbnailPath && file_exists(public_path($thumbnailPath))) {
            unlink(public_path($thumbnailPath));
        }
        // Xóa bài viết
        $post->delete();

        // Quay lại trang danh sách bài viết và thông báo thành công
        return redirect()->route('admin.post.index')->with('success', 'Bài viết đã được xóa thành công!');
    }
}
