<?php
namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;
class AdminOrderController extends Controller
{
    public function index()  {
        $orders = Order::orderBy('created_at', 'desc')->get();
        return view('admin.order.index', compact('orders'));
    }
    public function show($id)
    {
        $order = Order::with([
            'orderDetails.product',
            'orderDetails.gift',
            'orderDetails.productInGift' => function ($query) {
                $query->with('product');
            },
            'user' // Lấy thông tin người mua hàng
        ])->findOrFail($id);

        if (!$order) {
            return redirect()->route('admin.orders.index')->with('error', 'Đơn hàng không tồn tại.');
        }

        return view('admin.order.detail', compact('order'));
    }

    
}