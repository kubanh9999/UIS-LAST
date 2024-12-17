<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostCategory;

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
            $posts = Post::paginate(6); // Lấy tất cả bài viết nếu không lọc
        }

        $categories = PostCategory::all();
        // Lấy danh sách ID bài viết từ session
        $recentPostIds = session()->get('recently_viewed_posts', []);

        // Lấy thông tin bài viết từ cơ sở dữ liệu
        $recentlyViewedPosts = Post::whereIn('id', $recentPostIds)->get();

        return view('pages.post2', compact('posts', 'categories', 'recentlyViewedPosts'));
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);

        // Lấy các bài viết liên quan (cùng danh mục)
        $relatedPosts = Post::where('category_id', $post->category_id)
            ->where('id', '!=', $id) // Loại bỏ bài viết hiện tại
            ->take(8) // Lấy tối đa 3 bài viết liên quan
            ->get();

        // Lưu ID bài viết vào session
        $recentPosts = session()->get('recently_viewed_posts', []);

        if (!in_array($id, $recentPosts)) {
            // Thêm bài viết vào danh sách
            $recentPosts[] = $id;

            // Giới hạn 5 bài viết gần nhất
            if (count($recentPosts) > 5) {
                array_shift($recentPosts);
            }

            // Lưu lại vào session
            session()->put('recently_viewed_posts', $recentPosts);
        }

        return view('pages.post-detail2', compact('post', 'relatedPosts'));
    }
}
