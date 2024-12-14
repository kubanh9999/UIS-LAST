<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
class OrderController extends Controller
{
    public function printInvoice($id)
{
    $orders = Order::findOrFail($id);

    $pdf = app('dompdf.wrapper');
    // Chỉ truyền nội dung cần in
    $html = view('pages.account-order-detail', compact('orders'))->render();
    $pdf->loadHTML($html);

    // Cài đặt một số tùy chọn cho PDF để định dạng tốt hơn
    $pdf->set_option('isHtml5ParserEnabled', true);

    // Trả về PDF để tải xuống
    return $pdf->stream('invoice-' . $orders->id . '.pdf');
}
}
