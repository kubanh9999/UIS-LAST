<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class AdminCommentController extends Controller
{
    public function index()
    {
        $comments = Comment::withCount('replies')
            ->whereNull('parent_id') // Chỉ lấy bình luận cha
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.comments.index', compact('comments'));
    }
    public function detail($id)
    {
        $comment = Comment::with(['user', 'product', 'replies.user'])
       ->findOrFail($id);
            /* dd($comment); */
        return view('admin.comments.detail', compact('comment'));
    }

    public function approveComment($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->status = 1;
        $comment->save();
        return redirect()->back()->with('success', 'Bình luận đã được duyệt.');
    }
    public function hideComment($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->status = 2;
        $comment->save();
        return redirect()->back()->with('success', 'Bình luận đã được ẩn.');
    }
    public function unhideComment($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->status = 1;
        $comment->save();
        return redirect()->back()->with('success', 'Bình luận đã được hiện lại.');
    }
    public function confirmDelete($id)
    {
        $deleteComment = Comment::FindOrFail($id);
        $deleteComment->delete();
        return redirect()->back()->with('success', 'Bình luận đã được xóa.');
    }

    // Quản lí chi tiết bình luận con
    public function deleteReply($id)
    {
        $reply = Comment::findOrFail($id);
        $reply->delete();
        return redirect()->back()->with('success', 'Đã xóa câu trả lời.');
    }

    public function hideReply($id)
    {
        $reply = Comment::findOrFail($id);
        $reply->update(['status' => 2]); // Giả định 2 là trạng thái ẩn
        return redirect()->back()->with('success', 'Đã ẩn câu trả lời.');
    }

    public function unhideReply($id)
    {
        $reply = Comment::findOrFail($id);
        $reply->update(['status' => 1]); // Giả định 1 là trạng thái đã duyệt
        return redirect()->back()->with('success', 'Đã hiện lại câu trả lời.');
    }
    public function approveReply($id)
    {
        $reply = Comment::findOrFail($id);
        $reply->status = 1; // Đánh dấu là đã duyệt
        $reply->save();

        return redirect()->back()->with('success', 'Câu trả lời đã được duyệt!');
    }
}
