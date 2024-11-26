<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\OrderDetail;
use App\Mail\OrderMail;
use App\Models\Product;
use App\Models\ProductInGift;
use App\Models\ProductType;
use App\Models\Order;
use Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Symfony\Component\ErrorHandler\Debug;

class CheckoutController extends Controller
{
    // Hiển thị trang checkout
    public function index() {
        $cart = session()->get('cart', []);
        $product_ids = array_keys($cart);
        $products = Product::whereIn('id', $product_ids)->get();
    
        foreach ($products as $product) {
            // Kiểm tra xem 'quantity' có tồn tại trong giỏ hàng hay không
            if (isset($cart[$product->id]['quantity'])) {
                $product->quantity = $cart[$product->id]['quantity'];
            } else {
                // Nếu không có quantity, có thể đặt giá trị mặc định (0 hoặc 1)
                $product->quantity = 0; // Hoặc có thể bỏ qua sản phẩm này nếu cần
            }
        }
    
        $selectedGiftId = session()->get('selected_product');
        $selectedGift = $selectedGiftId ? ProductType::find($selectedGiftId) : null;
    
        return view('pages.checkout', compact('products'));
    }
    
    // Xử lý checkout với sản phẩm quà tặng được chọn
    public function checkout(Request $request)
{
    $productData = [
        'product_id' => $request->input('product_id'),
        'sku' => $request->input('sku'),
        'price' => $request->input('price'),
        'image' => $request->input('image'),
        'quantity' => $request->input('quantity'),
    ];
 /*    dd(  $productData); */

    $cart = session()->get('cart', []); // Lấy giỏ hàng từ session
    $selectedGiftId = $request->input('selected_product');
    $selectedGift = null;
/* dd($cart); */
    if (is_array($selectedGiftId) && count($selectedGiftId) > 0) {
        $selectedGift = ProductType::find($selectedGiftId[0]);
    }

    $product_ids = array_keys($cart); // Lấy danh sách id sản phẩm từ giỏ hàng
    $products = Product::whereIn('id', $product_ids)->get(); // Lấy thông tin các sản phẩm theo id

    // Tính toán tổng giá trị đơn hàng
    $totalPrice = 0;

    foreach ($products as $product) {
        // Kiểm tra xem sản phẩm có trong giỏ hàng và có trường quantity không
        if (isset($cart[$product->id]['quantity'])) {
            $quantity = $cart[$product->id]['quantity']; // Lấy số lượng từ giỏ hàng
            $product->quantity = $quantity;

            // Tính tổng giá trị cho sản phẩm này
            $totalPrice += (float)$product->price * (int)$product->quantity;
            dd(    $totalPrice);// Thay 'price' bằng thuộc tính giá sản phẩm
        } else {
            $product->quantity = 0; // Nếu không có quantity, đặt giá trị mặc định là 0
        }
       
    }
/*     dd($totalPrice); */
    // Tính phí vận chuyển (nếu có)
    $shippingCost = 30000; // Ví dụ: phí vận chuyển là 1000, thay thế bằng logic của bạn nếu cần

    return view('pages.checkout', compact('products', 'selectedGift', 'totalPrice', 'shippingCost', 'cart', 'productData'));

}



    // Hoàn tất quy trình checkout
    public function completeCheckout(Request $request)
{
    $cart = session()->get('cart');
    if (!$cart) {
        return redirect()->back()->with('error', 'Giỏ hàng trống!');
    }

    $totalAmount = session()->get('discounted_total', 0);
    if ($totalAmount === 0) {
        foreach ($cart as $item) {
            if (isset($item['total'])) { 
                // Trường hợp giỏ quà tùy chỉnh (total đã tính sẵn từ trái cây bên trong)
                $totalAmount += $item['total'];
            } else if (isset($item['price_gift'])) { 
                // Trường hợp giỏ quà có sẵn
                $totalAmount += $item['price_gift'] * $item['quantity'];
            } else {
                // Trường hợp sản phẩm bình thường
                $totalAmount += $item['price'] * $item['quantity'];
            }
        }
    }
    $shippingCost = 30000;
    $totalAmount += $shippingCost;
    dd($totalAmount);
    die();
    // Kiểm tra tổng số tiền không âm
    if ($totalAmount < 0) {
        return redirect()->back()->with('error', 'Tổng số tiền không hợp lệ!');
    }

    $token = Str::random(12);
    $order = new Order();
    $order->fill([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'address' => $request->address,
        'payment_method' => 0,
        'status' => '0',
        'token' => $token,
        'order_date' => now(),
        'user_id' => Auth::id(),
        'total_amount' => max(0, $totalAmount),
    ]);

    // Kiểm tra mã giảm giá
    if ($request->has('discount_code')) {
        $discount = Discount::where('code', $request->discount_code)
            ->where('valid_form', '<=', now())
            ->where('valid_end', '>=', now())
            ->first();
        if ($discount) {
            $order->discounts_id = $discount->id;
            $totalAmount -= $discount->amount;
        } else {
            return redirect()->back()->with('error', 'Mã giảm giá không hợp lệ hoặc đã hết hạn.');
        }
    }

    // Lưu đơn hàng
    $order->save();

    // Lưu chi tiết sản phẩm trong đơn hàng
    foreach ($cart as $item) {
        if (isset($item['fruits'])) { // Trường hợp giỏ quà tùy chỉnh
            foreach ($item['fruits'] as $fruit) {
                // Lưu sản phẩm trong giỏ quà, chỉ cần lưu một bản ghi
                OrderDetail::create([
                    'user_id' => Auth::id(),
                    'order_id' => $order->id,
                    'gift_id' => $item['gift_id'], // Có thể để null nếu không cần
                    'product_id' => $fruit['product_id'], // Đảm bảo không null
                    'quantity' => $fruit['quantity'],
                    'price' => $fruit['price'],
                    'total_price' => $fruit['price'] * $fruit['quantity'],
                ]);

                
            }
            $product = Product::find($fruit['product_id']);
            if ($product) {
                $product->stock -= $fruit['quantity'];
                $product->sales += $fruit['quantity']; // Giảm số lượng tồn kho
                $product->save();
            }
            
        } elseif (isset($item['price_gift'])) { // Trường hợp giỏ quà có sẵn
            // Chỉ thêm gift_id, không thêm product_id
            OrderDetail::create([
                'order_id' => $order->id,
                'gift_id' => $item['id'], // ID của giỏ quà
                'quantity' => $item['quantity'],
                'price' => $item['price_gift'],
                'total_price' => $item['price_gift'] * $item['quantity'],
            ]);
        } else { // Trường hợp sản phẩm bình thường
            // Đảm bảo product_id không null
            if (isset($item['id'])) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'], // Đảm bảo giá trị không null
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total_price' => $item['price'] * $item['quantity'],
                ]);
                $product = Product::find($item['id']);
                if ($product) {
                    $product->stock -= $item['quantity']; // Giảm số lượng tồn kho
                    $product->sales += $item['quantity']; // Tăng số lượng bán ra
                    $product->save();
                }
            } else {
                // Xử lý nếu product_id không tồn tại
                throw new Exception("Product ID is required for normal products.");
            }
        }
    }
    
    // Gửi email thông báo đơn hàng
    Mail::to($order->email)->send(new OrderMail($order));
    session()->forget(['cart', 'discounted_total']);

    return view('pages.checkoutSuccess');
}



    // Xác nhận đơn hàng
    public function confirmOrder($token)
    {
        $order = Order::where('token', $token)->first();

        if ($order) {
            $order->status = 'confirmed'; // Cập nhật trạng thái
            $order->save();
            return redirect()->route('home.index')->with('success', 'Bạn đã xác nhận đơn hàng thành công.');
        }

        return abort(404);
    }

    // Áp dụng mã giảm giá
    public function applyDiscount(Request $request)
{
    // Bước 1: Xác thực mã giảm giá
    $request->validate([
        'discount_code' => 'required|string|max:50',
    ]);

    $discountCode = $request->input('discount_code');

    // Bước 2: Kiểm tra mã giảm giá trong cơ sở dữ liệu
    $discount = Discount::where('code', $discountCode)
                        ->where('valid_form', '<=', now()->addDay())
                        ->where('valid_end', '>=', now())
                        ->first();

    // Bước 3: Tính tổng giá trị sản phẩm trong giỏ hàng từ session
    $cart = session()->get('cart', []);
    $totalPrice = 0; // Khởi tạo tổng giá trị
/* dd($cart); */
    // Tính tổng giá trị giỏ hàng
   // Khởi tạo tổng giá trị giỏ hàng

    foreach ($cart as $item) {
        if (isset($item['fruits'])) {
            // Đây là giỏ quà
            foreach ($item['fruits'] as $fruit) {
                $price = (float) $fruit['price']; // Giá của từng loại trái cây trong giỏ
                $quantity = (int) $fruit['quantity']; // Số lượng của từng loại trái cây
                $totalPrice += $price * $quantity; // Cộng vào tổng giá trị
            }
        } else {
            // Đây là sản phẩm thông thường
            $price = (float) $item['price']; // Giá sản phẩm
            $quantity = (int) $item['quantity']; // Số lượng sản phẩm
            $totalPrice += $price * $quantity; // Cộng vào tổng giá trị
        }
    }

    // Áp dụng giảm giá nếu có
    if ($discount) {
        $discountPercentage = $discount->discount_percent; // Lấy tỷ lệ giảm giá
        $discountAmount = ($totalPrice * $discountPercentage) / 100; // Tính số tiền giảm giá

        $totalPrice -= $discountAmount;
        session()->put('discount_amount', round($discountAmount, 2));
        session()->put('discount_id', $discount->id);
        session()->put('discounted_total', round($totalPrice, 2));
    } else {
        $discountPercentage = 0;
       /*  $totalAmountAfterDiscount = $totalPrice; */ // Nếu không có mã giảm giá, đặt về 0
    }

    // Bước 5: Trả về tổng giá trị sau khi giảm giá
    return response()->json([
        'total_price' => number_format($totalPrice, 2, '.', ''),
        'discount' => $discountPercentage, // Trả về discount_percentage
        'message' => $discount ? 'Giảm giá đã được áp dụng.' : 'Mã giảm giá không hợp lệ hoặc đã hết hạn.'
    ]);
}



    // Xử lý thanh toán vnpay
    public function payment(Request $request)
    {
        // Thiết lập báo lỗi và múi giờ
        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
        date_default_timezone_set('Asia/Ho_Chi_Minh');
    
        // Cấu hình VNPAY
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://127.0.0.1:8000";
        $vnp_TmnCode = "CT0QGQXU";
        $vnp_HashSecret = "2ZCDCGTZPE6S8GW4PNVXSODU026WOI2M";
    
        // Lấy giỏ hàng từ session
        $cart = session()->get('cart');
        if (!$cart) {
            return redirect()->back()->with('error', 'Giỏ hàng trống!');
        }
    
        $totalAmount = session()->get('discounted_total', 0);
        if ($totalAmount === 0) {
            foreach ($cart as $item) {
                if (isset($item['total'])) { 
                    // Trường hợp giỏ quà tùy chỉnh (total đã tính sẵn từ trái cây bên trong)
                    $totalAmount += $item['total'];
                } else if (isset($item['price_gift'])) { 
                    // Trường hợp giỏ quà có sẵn
                    $totalAmount += $item['price_gift'] * $item['quantity'];
                } else {
                    // Trường hợp sản phẩm bình thường
                    $totalAmount += $item['price'] * $item['quantity'];
                }
            }
        }
        $shippingCost = 30000;
        $totalAmount += $shippingCost;
    
        // Kiểm tra tổng số tiền không âm
        if ($totalAmount < 0) {
            return redirect()->back()->with('error', 'Tổng số tiền không hợp lệ!');
        }
        /* dd($totalAmount); */
        // Lấy mã giảm giá từ session (nếu có)
     /*    $discountAmount = session('discount_amount', 0); // Nếu không có giá trị sẽ mặc định là 0
        $discountId = session('discount_id');
        $totalAmountAfterDiscount = $totalAmount - $discountAmount;
     
        // Thêm phí vận chuyển
        $shippingCost = 30000; // Phí vận chuyển cố định
        $totalAmountAfterDiscount += $shippingCost;
   
        // Đảm bảo tổng số tiền không nhỏ hơn 0
        if ($totalAmountAfterDiscount < 0) {
            $totalAmountAfterDiscount = 0;
        }
     */
    $discountAmount = 0;
    if ($request->has('discount_code')) {
        $discount = Discount::where('code', $request->discount_code)
            ->where('valid_form', '<=', now())
            ->where('valid_end', '>=', now())
            ->first();
        if ($discount) {
            $discountAmount = $discount->amount;
            $totalAmount -= $discountAmount; // Subtract discount from total amount
        } else {
            return redirect()->back()->with('error', 'Mã giảm giá không hợp lệ hoặc đã hết hạn.');
        }
    }
        // Tạo mã giao dịch và các thông tin liên quan
        $vnp_TxnRef = Str::random(12);
        $vnp_OrderInfo = 'Thanh toán cho đơn hàng';
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $totalAmount *100; // Đổi sang đơn vị VND (cộng với 100 vì VNPAY yêu cầu tính theo "cent")
        $vnp_Locale = 'vn';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $request->ip();
    
        // Dữ liệu thanh toán
        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        ];
    
        if (!empty($vnp_BankCode)) {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
    
        // Sắp xếp và tạo chuỗi truy vấn
        ksort($inputData);
        $hashdata = http_build_query($inputData);
    
        // Tạo mã bảo mật
        $vnp_Url .= "?" . $hashdata;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= '&vnp_SecureHash=' . $vnpSecureHash;
        }
    
        // Tạo đơn hàng trong cơ sở dữ liệu
        $order = Order::create([
            'user_id' => Auth::id(),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'status' => 0,
            'payment_method' => 'VNPAY',
            'discounts_id' => $discountAmount > 0 ? $discount->id : null,  // Use $discountAmount here
    'total_amount' => $totalAmount, // Use the updated totalAmount
            'token' => $vnp_TxnRef,
            'order_date' => now(),
        ]);
    
        // Lưu chi tiết đơn hàng
        foreach ($cart as $item) {
            if (isset($item['fruits'])) { // Trường hợp giỏ quà tùy chỉnh
                foreach ($item['fruits'] as $fruit) {
                    OrderDetail::create([
                        'user_id' => Auth::id(),
                        'order_id' => $order->id,
                        'gift_id' => $item['gift_id'], // Có thể để null nếu không cần
                        'product_id' => $fruit['product_id'],
                        'quantity' => $fruit['quantity'],
                        'price' => $fruit['price'],
                        'total_price' => $fruit['price'] * $fruit['quantity'],
                    ]);
                }
            } elseif (isset($item['price_gift'])) { // Trường hợp giỏ quà có sẵn
                OrderDetail::create([
                    'order_id' => $order->id,
                    'gift_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price_gift'],
                    'total_price' => $item['price_gift'] * $item['quantity'],
                ]);
            } else { // Trường hợp sản phẩm bình thường
                if (isset($item['id'])) {
                    OrderDetail::create([
                        'order_id' => $order->id,
                        'product_id' => $item['id'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                        'total_price' => $item['price'] * $item['quantity'],
                    ]);
                }
            }
        }
    
        session()->forget('discount_amount');
        session()->forget('discount_id');
        session()->forget('cart');
    
        // Chuyển hướng đến VNPAY
        return redirect($vnp_Url);
    }
    
    
    /* thanh toán momo */
    public function momo(Request $request) {
      /*  dd($request->all()); */
      $cart = session()->get('cart');
      if (!$cart) {
          return redirect()->back()->with('error', 'Giỏ hàng trống!');
      }
  
      $totalAmount = session()->get('discounted_total', 0);
      if ($totalAmount === 0) {
          foreach ($cart as $item) {
              if (isset($item['total'])) { 
                  // Trường hợp giỏ quà tùy chỉnh (total đã tính sẵn từ trái cây bên trong)
                  $totalAmount += $item['total'];
              } else if (isset($item['price_gift'])) { 
                  // Trường hợp giỏ quà có sẵn
                  $totalAmount += $item['price_gift'] * $item['quantity'];
              } else {
                  // Trường hợp sản phẩm bình thường
                  $totalAmount += $item['price'] * $item['quantity'];
              }
          }
      }
      $shippingCost = 30000;
      $totalAmount += $shippingCost;
  
      // Kiểm tra tổng số tiền không âm
      if ($totalAmount < 0) {
          return redirect()->back()->with('error', 'Tổng số tiền không hợp lệ!');
      }
        // Get discount from session (if any)
        $discountAmount = session('discount_amount', 0);
        $discountId = session('discount_id');
        $totalAmountAfterDiscount = $totalAmount - $discountAmount;
    
        // Ensure the total amount doesn't go below 0
        if ($totalAmountAfterDiscount < 0) {
            $totalAmountAfterDiscount = 0;
        }
    
        // Validate input data
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'address' => 'required|string',
        ]);
    
        // Prepare for MoMo payment
        $vnp_TxnRef = Str::random(12);
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        $orderInfo = "Thanh toán qua MoMo";
        $orderId = time() . "";
        $redirectUrl = "http://127.0.0.1:8000";
        $ipnUrl = "http://127.0.0.1:8000";
        $extraData = "";
    
        if ($request->has('payUrl')) {
            // Create request data
            $requestId = time() . "";
            $requestType = "payWithATM";
            $rawHash = "accessKey=" . $accessKey . "&amount=" . $totalAmount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
            $signature = hash_hmac("sha256", $rawHash, $secretKey);
    
            // Data to send
            $data = [
                'partnerCode' => $partnerCode,
                'partnerName' => "Test",
                'storeId' => "MomoTestStore",
                'requestId' => $requestId,
                'amount' => $totalAmountAfterDiscount,
                'orderId' => $orderId,
                'orderInfo' => $orderInfo,
                'redirectUrl' => $redirectUrl,
                'ipnUrl' => $ipnUrl,
                'lang' => 'vi',
                'extraData' => $extraData,
                'requestType' => $requestType,
                'signature' => $signature
            ];
    
            // Send request to MoMo API
            $result = $this->execPostRequest($endpoint, json_encode($data));
            $jsonResult = json_decode($result, true);
    
            // Check response from MoMo
            if (isset($jsonResult['payUrl'])) {
                // Save order to database
                $order = Order::create([
                    'user_id' => Auth::id(),
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'phone' => $request->input('phone'),
                    'address' => $request->input('address'),
                    'status' => 0,
                    'payment_method' => 'momo',
                    'discounts_id' => $discountId, // Save discount ID
                    'total_amount' => $totalAmountAfterDiscount,
                    'token' => $vnp_TxnRef,
                    'order_date' => now(),
                ]);
    
                // Save order details
                foreach ($cart as $item) {
                    if (isset($item['fruits'])) { // Trường hợp giỏ quà tùy chỉnh
                        foreach ($item['fruits'] as $fruit) {
                            // Lưu sản phẩm trong giỏ quà, chỉ cần lưu một bản ghi
                            OrderDetail::create([
                                'user_id' => Auth::id(),
                                'order_id' => $order->id,
                                'gift_id' => $item['gift_id'], // Có thể để null nếu không cần
                                'product_id' => $fruit['product_id'], // Đảm bảo không null
                                'quantity' => $fruit['quantity'],
                                'price' => $fruit['price'],
                                'total_price' => $fruit['price'] * $fruit['quantity'],
                            ]);
                        }
                        $product = Product::find($fruit['product_id']);
                        if ($product) {
                            $product->stock -= $fruit['quantity'];
                            $product->sales += $fruit['quantity']; // Giảm số lượng tồn kho
                            $product->save();
                        }
                    } elseif (isset($item['price_gift'])) { // Trường hợp giỏ quà có sẵn
                        // Chỉ thêm gift_id, không thêm product_id
                        OrderDetail::create([
                            'order_id' => $order->id,
                            'gift_id' => $item['id'], // ID của giỏ quà
                            'quantity' => $item['quantity'],
                            'price' => $item['price_gift'],
                            'total_price' => $item['price_gift'] * $item['quantity'],
                        ]);
                    } else { // Trường hợp sản phẩm bình thường
                        // Đảm bảo product_id không null
                        if (isset($item['id'])) {
                            OrderDetail::create([
                                'order_id' => $order->id,
                                'product_id' => $item['id'], // Đảm bảo giá trị không null
                                'quantity' => $item['quantity'],
                                'price' => $item['price'],
                                'total_price' => $item['price'] * $item['quantity'],
                            ]);
                            $product = Product::find($item['id']);
                            if ($product) {
                                $product->stock -= $item['quantity']; // Giảm số lượng tồn kho
                                $product->sales += $item['quantity']; // Tăng số lượng bán ra
                                $product->save();
                            }
                        } else {
                            // Xử lý nếu product_id không tồn tại
                            throw new Exception("Product ID is required for normal products.");
                        }
                    }
                }
                
                // Clear session data
                session()->forget('discount_amount');
                session()->forget('discount_id');
                session()->forget('cart');
    
                // Redirect to payment URL
                return redirect()->away($jsonResult['payUrl']);
            } else {
                // Handle error if no payment URL is returned
                return back()->with('error', 'Không lấy được URL thanh toán từ MoMo.');
            }
        }
    
        return back()->with('error', 'Yêu cầu không hợp lệ.');
    }
    


    public function execPostRequest($url, $data) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

}
 
