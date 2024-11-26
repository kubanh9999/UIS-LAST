<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

    // Hàm đăng bình luận
    public function post_comment(Request $request, $productId)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để bình luận.');
        } 
        $validatedData = $request->validate([
            'content' => 'required|string|max:500',
        ]);
        $validatedData['product_id'] = $productId;
        $validatedData['user_id'] = Auth::id();

        $existingComment = Comment::where('user_id', $validatedData['user_id'])
            ->where('product_id', $productId)
            ->where('content', $validatedData['content'])
            ->first();

        if ($existingComment) {
            return redirect()->back()->with('error', 'Bạn đã bình luận nội dung này rồi!');
        }

        // Tạo bình luận mới
        Comment::create($validatedData);
        return redirect()->back()->with('success', 'Bình luận thành công!');
    }


    // Hàm thích bình luận
    public function like($id)
    {
        $comment = Comment::findOrFail($id); 
        $comment->increment('likes');

        return redirect()->back()->with('success', 'Đã thích bình luận!');
    }
    // public function unlike($id)
    // {
    //     $comment = Comment::find($id);
    //     if ($comment) {
    //         // Giả sử bạn có một quan hệ giữa comment và user để theo dõi lượt thích
    //         $comment->likes()->detach(Auth::id());
    //         return back()->with('success', 'Bạn đã bỏ thích bình luận.');
    //     }
    //     return back()->with('error', 'Không tìm thấy bình luận.');
    // }

    // Hàm trả lời bình luận
    public function reply(Request $request, $id)
    {
        $request->validate(['content' => 'required|string|max:500']);

        $comment = Comment::findOrFail($id); 
        Comment::create([
            'product_id' => $comment->product_id,
            'user_id' => Auth::id(),
            'content' => $request->content,
            'parent_id' => $id,
        ]);

        return redirect()->back()->with('success', 'Đã gửi trả lời!');
    }

    // Hàm xóa bình luận
    public function delete($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return redirect()->back()->with('success', 'Đã xóa bình luận!');
    }
}
