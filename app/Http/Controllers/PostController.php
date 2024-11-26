<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostController extends Controller
{
       public function index(Request $request)
    {
        // Lấy danh mục từ query string, mặc định là tất cả
        $categoryId = $request->get('category', null);

        // Lấy các bài viết theo danh mục và phân trang
        if ($categoryId) {
            $posts = Post::where('category_id', $categoryId)->paginate(6); 
        } else {
            $posts = Post::paginate(6); 
        }   


        $categories = Category::all();

        return view('pages.post', compact('posts', 'categories'));
    }
    public function show($id)
{
    $post = Post::findOrFail($id);

    // Lấy các bài viết liên quan (cùng danh mục)
    $relatedPosts = Post::where('category_id', $post->category_id)
    ->where('id', '!=', $id) // Loại bỏ bài viết hiện tại
    ->take(3) // Lấy tối đa 3 bài viết liên quan
    ->get();


    return view('pages.post_detail', compact('post', 'relatedPosts'));
}

}
