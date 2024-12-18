<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function store(Request $request)
{
    try {
        // Validate dữ liệu đầu vào
        $request->validate([
            'email' => 'required|email|unique:subscribers,email',
        ]);
        // Lưu email vào cơ sở dữ liệu
        Subscriber::create(['email' => $request->email]);
        // Thông báo thành công
        return redirect()->back()->with('success', 'Đăng ký nhận thông báo thành công!');
    } catch (\Exception $e) {
        // Xử lý ngoại lệ và thông báo lỗi chung
        return redirect()->back()->with('error', 'Đã xảy ra lỗi. Vui lòng thử lại sau.');
    }
}
}
