<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\District;
use App\Models\Province;
use App\Models\Ward;
use Illuminate\Support\Facades\DB;
class AccountManagementController extends Controller
{
    public function management()
    {
        $user = Auth::user(); 
        $provinces = Province::all();
        $districts = District::where('province_id', $user->province_id)->get();
        $wards = Ward::where('district_id', $user->district_id)->get();
        $user->load('province', 'district', 'ward'); // Lấy thông tin người dùng hiện tại

    
        $orders = Order::orderBy('id', 'DESC')
            ->where('user_id', $user->id)
            ->with(['orderDetails', 'orderDetails.product', 'orderDetails.gift', 'orderDetails.productInGift.product']) // Nạp dữ liệu liên quan
            ->get();

        $discount = null;

        if ($user->discount_id != 0) {
            $discount = DB::table('discounts')->where('id', $user->discount_id)->first();
        }

        return view('pages.account-management2', compact('orders','provinces', 'user','districts','wards','discount'));
    }

    public function changePassword()
    {

        return view('pages.account-management2');
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
        $user = Auth::user(); 
        $provinces = Province::all();
        $districts = District::where('province_id', $user->province_id)->get();
        $wards = Ward::where('district_id', $user->district_id)->get();
        $user->load('province', 'district', 'ward'); // Lấy thông tin người dùng hiện tại
        $orders = Order::with([
            'orderDetails.product',
            'orderDetails.gift',
            'orderDetails.productInGift' => function ($query) {
                $query->with('product'); // eager load product trong productInGift
            }
        ])->find($id);
        $discount = null;

        if ($orders->discounts_id != null) {
            $discount = DB::table('discounts')->find($orders->discounts_id); // Lấy thông tin giảm giá từ discount_id trong đơn hàng
        }
        return view('pages.order-detail', compact('discount','orders','provinces', 'user','districts','wards'));
    }

    public function cancelOrder($orderId)
    {
        // Tìm đơn hàng theo ID
        $order = Order::find($orderId);

        // Kiểm tra nếu đơn hàng tồn tại và trạng thái là "Đang xử lý" (status = 0)
        if ($order && $order->status == 'Đang xử lý') {
            // Thay đổi trạng thái đơn hàng thành "Đã hủy"
            $order->status = 'Đã hủy';
            $order->save();

            // Quay lại trang account-management với thông báo thành công
            return redirect()->route('account.management')
                ->with('success', 'Đơn hàng đã được hủy thành công.');
        }

        // Nếu trạng thái không phải "Đang xử lý", quay lại trang và thông báo lỗi
        return redirect()->route('account.management')
            ->with('error', 'Không thể hủy đơn hàng vì đơn hàng không còn trong trạng thái "Đang xử lý".');
    }
    public function completeOrder($orderId)
    {
        $order = Order::find($orderId);

        if ($order && $order->status == 'Đã giao') {
            // Cập nhật trạng thái thành 'Hoàn thành'
            $order->status = 'Hoàn thành';
            $order->save();

            // Quay lại trang đơn hàng của user với thông báo thành công
            return redirect()->route('account.management')->with('success', 'Đơn hàng đã hoàn thành!');
        }
        return redirect()->route('account.management')->with('error', 'Đơn hàng không thể hoàn thành.');
    }


    public function showUserInfo()
    {
        $user = Auth::user(); 
        $provinces = Province::all();
        $districts = District::where('province_id', $user->province_id)->get();
        $wards = Ward::where('district_id', $user->district_id)->get();
        $user->load('province', 'district', 'ward'); // Lấy thông tin người dùng hiện tại
        return view('account.management2', compact('user','wards','districts ','provinces'));
    }


    public function updateUserInfo(Request $request)
    {
       /*  dd(vars: $request->ward_id); */
        $user = Auth::user(); // Lấy thông tin người dùng hiện tại
        // Cập nhật thông tin người dùng
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'street' => $request->street,
            'province_id' => $request->province_id,
            'district_id' => $request->district_id,
            'wards_id' => $request->ward_id,
        ]);

        return redirect()->route('account.management')->with('success', 'Cập nhật thông tin thành công!');
    }
}
