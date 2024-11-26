<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountManagementController extends Controller
{
    public function management()
    {
        $user = Auth::user();
        $orders = Order::orderBy('id', 'DESC')
            ->where('user_id', $user->id)
            ->with(['orderDetails', 'orderDetails.product', 'orderDetails.gift', 'orderDetails.productInGift.product']) // Nạp dữ liệu liên quan
            ->get();
        return view('pages.account-management', compact('orders', 'user'));
    }

    public function changePassword()
    {

        return view('pages.account-management');
    }
    public function updatePassword(Request $request)
    {
        # Validation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        #Match The Old Password
        if (!Hash::check($request->old_password, Auth::user()->password)) {
            return back()->with("error", "Old Password Doesn't match!");
        }

        User::whereId(Auth::id())->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with("status", "Thay đổi mật khẩu thành công! ");
    }
    public function orderDetail($id)
    {
        $user = Auth::user(); // Lấy thông tin người dùng đã đăng nhập
        // Lấy đơn hàng theo user_id và id của đơn hàng
        $orders = Order::with([
            'orderDetails.product',
            'orderDetails.gift',
            'orderDetails.productInGift' => function ($query) {
                $query->with('product'); // eager load product trong productInGift
            }
        ])->find($id);

        return view('pages.account-check-orderDetail', compact('orders'));
    }

    public function cancelOrder($orderId)
    {
        // Tìm đơn hàng theo ID
        $order = Order::find($orderId);

        // Kiểm tra nếu đơn hàng tồn tại và trạng thái là "Đang xử lý" (status = 0)
        if ($order && $order->status == 0) {
            // Thay đổi trạng thái đơn hàng thành "Đã hủy"
            $order->status = -1;
            $order->save();

            // Quay lại trang account-management với thông báo thành công
            return redirect()->route('account.management')
                ->with('success', 'Đơn hàng đã được hủy thành công.');
        }

        // Nếu trạng thái không phải "Đang xử lý", quay lại trang và thông báo lỗi
        return redirect()->route('account.management')
            ->with('error', 'Không thể hủy đơn hàng vì đơn hàng không còn trong trạng thái "Đang xử lý".');
    }

    public function showUserInfo()
    {
        $user = Auth::user();  // Lấy thông tin người dùng hiện tại
        return view('account.management', compact('user'));
    }


    public function updateUserInfo(Request $request)
    {
        $user = Auth::user(); // Lấy thông tin người dùng hiện tại

        // Validate dữ liệu nhập
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
        ]);

        // Cập nhật thông tin người dùng
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->route('account.management')->with('success', 'Cập nhật thông tin thành công!');
    }
}
