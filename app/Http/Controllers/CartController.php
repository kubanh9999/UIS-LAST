<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ProductType;
use Illuminate\Support\Facades\Auth;
class CartController extends Controller
{
    // Hiển thị giỏ hàng
    public function index()
    {
        $cart = Session::get('cart', []);
    /*     dd( $cart); */
        $total = $this->calculateTotal();
      /*   dd($cart); */
        $products = DB::table('product_types')->get();
        return view('pages.cart', compact('cart', 'total','products'));
    }

    // Thêm sản phẩm vào giỏ hàng
    public function addToCart(Request $request, $id)
{
    /* dd($request->all()); */

    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để mua hàng.');
    }

    $gift = ProductType::find($id);
    $item = $gift ?? Product::find($id); // Nếu không tìm thấy quà tặng, tìm sản phẩm thường

    // Kiểm tra nếu không có sản phẩm
    if (!$item) {
        return redirect()->route('home.index')->with('error', 'Sản phẩm không tồn tại');
    }

    // Phân biệt quà tặng và sản phẩm thường
    $itemKey = $gift ? 'gift_' . $item->id : 'product_' . $item->id;

    // Lấy giỏ hàng hiện tại từ session (hoặc khởi tạo nếu chưa có)
    $cart = session()->get('cart', []);

    // Kiểm tra số lượng hàng tồn kho
    $currentQuantity = isset($cart[$itemKey]) ? $cart[$itemKey]['quantity'] : 0;
    $newQuantity = $currentQuantity + $request->quantity;
    if ($newQuantity > $item->stock) {
        return back()->with('error', "Số lượng bạn yêu cầu vượt quá tồn kho. Sản phẩm chỉ còn {$item->stock} trong kho.");
    }
    // Kiểm tra và thêm/cập nhật sản phẩm trong giỏ hàng
    if (isset($cart[$itemKey])) {
       // Nếu sản phẩm đã có trong giỏ, tăng số lượng
       $cart[$itemKey]['quantity'] = $newQuantity;;
    } else {
        // Nếu sản phẩm chưa có, thêm mới
        $cart[$itemKey] = [
            'id' => $item->id,
            'gift_id' => $item->id,
            'name' => $item->name,
            'image' => $item->image,
            'price' => $item->price,
            'quantity' => $request->quantity,
            'price_gift' => $gift->price_gift ?? null
        ];
    }

    // Lưu giỏ hàng vào session
    session()->put('cart', $cart);

    // Kiểm tra hành động dựa trên tham số 'action'
    if ($request->input('action') === 'buy_now') {
        // Nếu người dùng chọn "Mua ngay", chuyển đến trang giỏ hàng
        return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được thêm vào giỏ hàng.');
    } else {
        // Nếu người dùng chọn "Thêm giỏ hàng", quay lại trang hiện tại
        return back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng.');
    }
}



    // Cập nhật số lượng giỏ hàng
   // Cập nhật số lượng giỏ hàng
   public function updateCart(Request $request, $id)
   {
       $cart = Session::get('cart', []);

       // Xây dựng khóa đầy đủ từ id sản phẩm, ví dụ: product_19
       $productKey = 'product_' . $id; // Đây là cho các sản phẩm thông thường
       $giftKey = 'gift_' . $id; // Đây là cho giỏ quà

       // Kiểm tra xem sản phẩm có tồn tại trong giỏ hàng hay không
       if (isset($cart[$productKey])) {
           // Cập nhật số lượng sản phẩm thông thường
           $quantity = (int) $request->quantity;

           if ($quantity > 0) {
               // Cập nhật số lượng cho sản phẩm thông thường
               $cart[$productKey]['quantity'] = $quantity;
           } else {
               // Nếu quantity không hợp lệ, xóa sản phẩm khỏi giỏ
               unset($cart[$productKey]);
           }

       } elseif (isset($cart[$giftKey])) {
           // Cập nhật số lượng giỏ quà
           $quantity = (int) $request->quantity;

           if ($quantity > 0) {
               // Cập nhật số lượng cho giỏ quà
               $cart[$giftKey]['quantity'] = $quantity;
           } else {
               // Nếu quantity không hợp lệ, xóa giỏ quà khỏi giỏ
               unset($cart[$giftKey]);
           }

       } else {
           return response()->json([
               'success' => false,
               'message' => 'Sản phẩm không tồn tại trong giỏ hàng.'
           ]);
       }


        // Kiểm tra số lượng tồn kho
        $gift = ProductType::find($id);
        $item = $gift ?? Product::find($id);
        $availableStock = $gift ? $item->stock : $item->stock;

        if ($quantity > $availableStock) {
            return response()->json([
                'success' => false,
                'message' => "Số lượng bạn yêu cầu vượt quá tồn kho. Sản phẩm chỉ còn {$availableStock} trong kho."
            ]);
        }

        // Cập nhật số lượng trong giỏ hàng
        if ($gift) {
            $cart[$giftKey]['quantity'] = $quantity;
        } else {
            $cart[$productKey]['quantity'] = $quantity;
        }

       // Lưu giỏ hàng lại vào session
       Session::put('cart', $cart);

       // Tính lại tổng tiền và số lượng
       $total = $this->calculateTotal();
       $cartItemCount = array_sum(array_column($cart, 'quantity'));

       return response()->json([
           'success' => true,
           'totalPrice' => $total,
           'cartItemCount' => $cartItemCount
       ]);
   }
    // Xóa sản phẩm khỏi giỏ hàng
    public function delete($id)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]); // Xóa sản phẩm khỏi giỏ hàng
            Session::put('cart', $cart);
        }

        // Tính tổng tiền và số lượng sản phẩm
        $totalPrice = $this->calculateTotal();
        $cartItemCount = array_sum(array_column($cart, 'quantity'));

        return response()->json([
            'success' => true,
            'message' => 'Sản phẩm đã xóa thành công',
            'totalPrice' => $totalPrice,
            'cartItemCount' => $cartItemCount
        ]);
    }

    // Xóa toàn bộ sản phẩm khỏi giỏ hàng
    public function clearCart()
    {
        Session::forget('cart'); // Xóa toàn bộ giỏ hàng

        return response()->json([
            'success' => true,
            'message' => 'Toàn bộ sản phẩm đã được xóa khỏi giỏ hàng',
            'totalPrice' => 0,
            'cartItemCount' => 0
        ]);
    }

    // Tính tổng tiền
    private function calculateTotal()
    {
        $cart = Session::get('cart', []);

        return array_reduce($cart, function ($carry, $item) {
            // Trường hợp 1: Giỏ quà tùy chọn, dùng 'total'
            if (isset($item['fruits']) && isset($item['total']) && is_numeric($item['total'])) {
                $carry += $item['total'];
            }
            // Trường hợp 2: Gift (giỏ quà cố định), dùng 'price_gift'
            elseif (isset($item['price_gift']) && is_numeric($item['price_gift']) && $item['price_gift'] !== null) {
                $carry += $item['price_gift'] * (int) $item['quantity'];
            }
            // Trường hợp 3: Sản phẩm thông thường, dùng 'price'
            elseif (isset($item['price']) && is_numeric($item['price']) && isset($item['quantity']) && is_numeric($item['quantity'])) {
                $carry += $item['price'] * (int) $item['quantity'];
            }

            return $carry;
        }, 0);
    }

    public function addGiftBasketToCart(Request $request, $basket_id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập mua hàng.');
        }
    
        // Khởi tạo giỏ hàng từ session
        $cart = Session::get('cart', []);
        $quantities = $request->input('quantities', []);
        
        // Kiểm tra giỏ quà
        $giftBasket = ProductType::find($basket_id);
        if (!$giftBasket) {
            return redirect()->route('cart.index')->with('error', 'Giỏ quà không tồn tại.');
        }
    
        // Kiểm tra trái cây trong giỏ quà
        $fruits = [];
        foreach ($request->fruits as $fruit_id => $isChecked) {
            if ($isChecked) {
                $fruit = Product::find($fruit_id);
                if ($fruit) {
                    // Lấy giá trị quantity từ form, ép kiểu về số nguyên
                    $quantity = (int)($quantities[$fruit_id] ?? 0); // Đảm bảo quantity là số nguyên
                    $quantityKg = $quantity / 1000; // Chuyển đổi quantity từ gam sang kg
    
                    // Lấy giá trị price từ sản phẩm, ép kiểu về số thập phân
                    $price = (float)$fruit->price; // Đảm bảo price là số thập phân
    
                    if ($quantityKg > $fruit->stock) {  // Giả sử `stock` là trường lưu trữ số lượng tồn kho
                        return back()->with('error', 'Số lượng trái cây ' . $fruit->name . ' vượt quá số lượng tồn kho.');
                    }
    
                    if ($quantity > 0) {
                        $fruits[$fruit_id] = [
                            'product_id' => $fruit->id,
                            'name' => $fruit->name,
                            'image' => $fruit->image,
                            'quantity' => $quantityKg, // Lưu số lượng theo kg
                            'price' => $price
                        ];
                    }
                }
            }
        }
    
        // Tính tổng giỏ quà
        $totalPrice = $this->calculateBasketTotal($fruits); // Tính tổng giỏ quà
        /* dd($totalPrice); */ // Debug totalPrice
    
        $basket = [
            'gift_id' => $giftBasket->id,
            'basket_name' => $giftBasket->name,
            'basket_image' => $giftBasket->image,
            'fruits' => $fruits,
            'total' => $totalPrice // Đảm bảo sử dụng totalPrice
        ];
    
        // Thêm giỏ quà vào giỏ hàng trong session
        $cart[] = $basket;
        Session::put('cart', $cart);
    
        if ($request->input('action') === 'buy_now') {
            return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được thêm vào giỏ hàng và chuyển tới trang giỏ hàng.');
        } else {
            return back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng.');
        }
    }
    
    // Hàm tính tổng giỏ quà
    public function calculateBasketTotal($fruits)
    {
        $total = 0;
        foreach ($fruits as $fruit) {
            // Nếu quantity đã là kg thì không cần chia thêm nữa
            $weightInKg = $fruit['quantity'];
    
            // Cộng dồn tổng theo trọng lượng và giá trị
            $total += $weightInKg * $fruit['price'];
        }
    
        return $total;
    }

}
