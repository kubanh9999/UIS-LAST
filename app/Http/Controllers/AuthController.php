<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Mail;
use App\Models\UserTimeLog;
class AuthController extends Controller
{
    public function sendVerificationCode(Request $request)
{
    $request->validate([
        'email' => 'required|email',
    ]);

    // Tạo mã OTP
    $otp = rand(100000, 999999);

    // Lưu mã vào session
    session([
        'verification_email' => $request->email,
        'verification_code' => $otp,
        'verification_expires_at' => now()->addMinutes(5), // 5 phút hết hạn
    ]);

    // Gửi email
    Mail::raw("Mã xác minh của bạn là: $otp", function ($message) use ($request) {
        $message->to($request->email)
                ->subject('Mã xác minh email');
    });

    // Trả về thông báo thành công dưới dạng JSON
    return response()->json([
        'success' => true,
        'message' => 'Mã xác minh đã được gửi tới email của bạn!'
    ]);
}

    public function verifyCode(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'verification_code' => 'required|numeric',
    ]);

    // Kiểm tra email và mã từ session
    if (
        session('verification_email') === $request->email &&
        session('verification_code') == $request->verification_code
    ) {
        if (now()->greaterThan(session('verification_expires_at'))) {
            return back()->withErrors(['verification_code' => 'Mã xác minh đã hết hạn!']);
        }

        // Xóa mã OTP khỏi session sau khi xác minh thành công
        session()->forget(['verification_email', 'verification_code', 'verification_expires_at']);

        return redirect()->route('home')->with('message', 'Xác minh email thành công!');
    }

    return back()->withErrors(['verification_code' => 'Mã xác minh không chính xác!']);
}
    // Hiển thị form đăng ký
    public function showRegisterForm()
    {
        return view('pages.register');
    }

    // Xử lý đăng ký
    public function register(Request $request)
{
    if (!session()->has('verification_email') || !session()->has('verification_code')) {
        session()->flash('swal', [
            'icon' => 'error',
            'title' => 'Lỗi xác minh',
            'text' => 'Vui lòng xác minh email trước khi đăng ký.',
        ]);
        return redirect()->route('register');
    }
    
    // Kiểm tra xem email và mã OTP có khớp với session không
    if (session('verification_email') !== $request->email || session('verification_code') != $request->verification_code) {
        session()->flash('swal', [
            'icon' => 'error',
            'title' => 'Lỗi xác minh',
            'text' => 'Mã OTP không chính xác.',
        ]);
        return back();
    }
    
    // Kiểm tra xem mã OTP có hết hạn không
    if (now()->greaterThan(session('verification_expires_at'))) {
        session()->flash('swal', [
            'icon' => 'error',
            'title' => 'Lỗi xác minh',
            'text' => 'Mã OTP đã hết hạn.',
        ]);
        return back();
    }
    
    // Nếu tất cả kiểm tra hợp lệ
    session()->flash('swal', [
        'icon' => 'success',
        'title' => 'Xác minh thành công',
        'text' => 'Mã OTP chính xác. Bạn có thể tiếp tục đăng ký.',
    ]);
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed', // Validate mật khẩu
    ], [
        'email.unique' => 'Email này đã được đăng ký.',
        'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
        'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
    ]);
    
    // Tạo người dùng mới
    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 0,
    ]);

    // Xóa session sau khi đăng ký thành công
    session()->forget(['verification_email', 'verification_code', 'verification_expires_at']);

    return redirect()->route('login')->with('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
}

    // Hiển thị form đăng nhập
    public function showLoginForm()
    {
        return view('pages.login');
    }

    // Xử lý đăng nhập
    public function login(Request $request)
    {
        
        // Validate dữ liệu từ form
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        // Kiểm tra thông tin đăng nhập
        if (Auth::attempt($request->only('email', 'password'))) {
            // Lấy thông tin người dùng đã đăng nhập
            $user = Auth::user();
            if ($user->status == 'bị khóa') {
                auth()->logout();
                return redirect()->back()->with('error', 'Tài khoản của bạn đã bị khóa. Vui lòng liên hệ với admin.');
            }
            if ($user->role == 1) {
                return redirect('/admin'); // Điều hướng đến trang admin nếu role = 1
            }
            return redirect()->route('home.index'); // Điều hướng đến trang dashboard nếu không phải admin
           
    
        }
        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không chính xác.',
        ]);
    }

    // Đăng xuất
    public function logout(Request $request)
{
    Auth::logout();  // Đăng xuất người dùng
    session()->forget(['cart']);  // Xóa giỏ hàng (nếu có)
    $request->session()->invalidate();  // Hủy session
    $request->session()->regenerateToken();  // Tạo lại token CSRF để bảo mật

    // Chuyển hướng về trang login và gửi script để thay thế lịch sử trình duyệt
    return redirect()->route('login')  // Chuyển hướng về trang đăng nhập
                     ->with('message', 'Bạn đã đăng xuất thành công.')  // Tùy chọn thông báo cho người dùng
                     ->header('Cache-Control', 'no-store, no-cache, must-revalidate, proxy-revalidate')  // Ngăn lưu cache
                     ->header('Pragma', 'no-cache')  // Xóa cache trình duyệt
                     ->header('Expires', '0');  // Đảm bảo không có dữ liệu cũ được lưu
}



    // Chuyển hướng đến Google để đăng nhập
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Xử lý callback từ Google
    public function handleGoogleCallback()
{
    try {
        $googleUser = Socialite::driver('google')->user();
    } catch (\Exception $e) {
        return redirect()->route('login')->withErrors(['email' => 'Không thể đăng nhập bằng Google.']);
    }

    // Tìm hoặc tạo người dùng trong cơ sở dữ liệu
    $user = User::where('email', $googleUser->getEmail())->first();

    if (!$user) {
        // Tạo người dùng mới nếu chưa tồn tại
        $user = User::create([
            'name' => $googleUser->getName(),
            'email' => $googleUser->getEmail(),
            'password' => Hash::make(uniqid()), // Tạo mật khẩu ngẫu nhiên
        ]);
    }

    // Đăng nhập người dùng
    Auth::login($user, true);

    return redirect()->route('home.index'); // Điều hướng đến trang chính
}

}