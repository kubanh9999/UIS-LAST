<?php
namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Discount;


class DiscountController extends Controller
{
    public function index()
    {
        $discounts = Discount::orderBy('id', 'desc')->get();
        return view('admin.discount.index', compact('discounts'));
    }

    public function create()
    {
        return view('admin.discount.create');
    }

    public function store(Request $request)
    {
        Discount::create([
            'code' => $request->input('code'),
            'discount_percent' => $request->input('discount_percent'),
            'quantity' => $request->input('quantity'),  
            'description' => $request->input('description'),
            'valid_form' => $request->input('valid_form'), 
            'valid_end' => $request->input('valid_end'), 
            'is_active' => true, // Có thể tự động đánh dấu là hoạt động
        ]);
       /*  dd($request->all()); */
        return redirect()->route('admin.discount.index')->with('success', 'Mã giảm giá đã được tạo thành công!');
    }

    public function edit($id)
    {
        $discount = Discount::findOrFail($id);
        return view('admin.discount.edit', compact('discount'));
    }
    
    public function update(Request $request, $id)
    {
        $user = Discount::findOrFail($id); 
        $user->code = $request->input('code');
        $user->discount_percent = $request->input('discount_percent');
        $user->quantity = $request->input('quantity');
        $user->description = $request->input('description');
        $user->valid_form = $request->input('valid_form');
        $user->valid_end = $request->input('valid_end');
        $user->save();
    
        return redirect()->route('admin.discount.index')->with('success', 'mã giảm giá đã được cập nhật thành công!');
    }

    public function destroy($id)
    {
        $discount = Discount::findOrFail($id);
        $discount->delete();

        return redirect()->route('admin.discount.index')->with('success', 'Mã giảm giá đã được xóa thành công!');
    }

    public function updateDiscount(Request $request, $id)
    {
        try {
            $discount = Discount::findOrFail($id);
            
            // Xử lý cột và giá trị được gửi
            $column = $request->input('column');
            $value = $request->input('value');
    
            // Kiểm tra cột hợp lệ và cập nhật
            if ($column && in_array($column, ['code', 'discount_percent', 'description', 'valid_form', 'valid_end'])) {
                // Loại bỏ dấu % nếu có trong discount_percent
                if ($column === 'discount_percent' && str_ends_with($value, '%')) {
                    $value = rtrim($value, '%');
                }
    
                $discount->$column = $value;
                $discount->save();
            }
    
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            // Ghi log lỗi để kiểm tra
            \Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    
}
