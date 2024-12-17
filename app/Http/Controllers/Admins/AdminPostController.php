<?php

namespace App\Http\Controllers\Admins;

use App\Models\Post;
use App\Models\Category;
use App\Mail\PostNotificationMail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\PostCategory;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;

class AdminPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = PostCategory::all();
        $post = Post::with('category')->get();

        return view('admin.posts.index', compact('post', 'category'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = PostCategory::all();
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
        $originalFileName = $request->file('image')->getClientOriginalName();
        $uniqueFileName = time() . '_' . preg_replace('/\s+/', '_', $originalFileName);
        $uploadFolder = 'uploads/posts';
        $request->file('image')->move(public_path($uploadFolder), $uniqueFileName);    
        $thumbnailPath = $uploadFolder . '/' . $uniqueFileName;
    }

    // Tạo bài viết mới và lưu vào cơ sở dữ liệu
    $post = new Post();
    $post->title = $request->input('title');
    $post->category_id = $request->input('category_id');
    $post->content = $request->input('content');
    $post->author = $request->input('author');
    $post->image = $thumbnailPath;
    $post->user_id = Auth::id(); // Lấy ID người dùng hiện tại
    $post->save();

    // Gửi email thông báo cho tất cả subscriber
    $subscribers = Subscriber::all(); // Lấy tất cả subscriber
    foreach ($subscribers as $subscriber) {
        // Gửi email cho từng subscriber
        Mail::to($subscriber->email)->send(new PostNotificationMail($post));
    }

    // Chuyển hướng về danh sách bài viết với thông báo thành công
    return redirect()->route('admin.post.index')->with('success', 'Bài viết đã được tạo thành công và thông báo email đã được gửi!');
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
        $post->author = $request->input('author');
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

function index_categories(){
    $postCategories = DB::table('post_categories')->get();
    return view('admin.posts.index_categories',compact('postCategories'));
}
    function createCategory(){
        return view('admin.posts.createPost');
    }
    public function storeCategory(Request $request)
    {
        // Xác thực dữ liệu
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
    
        // Tạo danh mục mới
        DB::table('post_categories')->insert([
            'name' => $request->name,
            // 'description' => $request->description ?? null, // Nếu không có giá trị description thì dùng giá trị mặc định
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return redirect()->route('admin.indexCategory.post')->with('success', 'Danh mục đã được thêm thành công!');
    }
    public function editCategory($id)
{
    // Lấy danh mục theo ID
    $category = DB::table('post_categories')->where('id', $id)->first();

    // Kiểm tra nếu không tìm thấy danh mục
    if (!$category) {
        return redirect()->route('admin.indexCategory.post')->with('error', 'Danh mục không tồn tại!');
    }

    // Trả về view với dữ liệu danh mục
    return view('admin.posts.editCategory', compact('category'));
}

public function updateCategory(Request $request, $id)
{
    // Xác thực dữ liệu
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    // Tìm danh mục theo ID
    $category = DB::table('post_categories')->where('id', $id)->first();

    // Kiểm tra nếu không tìm thấy danh mục
    if (!$category) {
        return redirect()->route('admin.indexCategory.post')->with('error', 'Danh mục không tồn tại!');
    }

    // Cập nhật các thông tin danh mục
    DB::table('post_categories')
        ->where('id', $id)
        ->update([
            'name' => $request->name,
            // 'description' => $request->description ?? null, // Nếu có description thì update, nếu không có thì giữ null
            'updated_at' => now(), // Cập nhật thời gian sửa
        ]);

    // Quay lại trang danh mục với thông báo thành công
    return redirect()->route('admin.indexCategory.post')->with('success', 'Danh mục đã được cập nhật thành công!');
}

public function deletePost($id)
{
    $category = PostCategory::find($id);

    // Xóa tất cả các sản phẩm thuộc danh mục này
    $category->posts()->delete();

    // Xóa danh mục
    $category->delete();

    return redirect()->route('admin.indexCategory.post')->with('success', 'Danh mục và tất cả sản phẩm liên quan đã được xóa.');
}


}
