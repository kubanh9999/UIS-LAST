<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

use App\Models\UserTimeLog;
class AuthController extends Controller
{
    // Hiển thị form đăng ký
    public function showRegisterForm()
    {
        return view('pages.register');
    }

    // Xử lý đăng ký
    public function register(Request $request)
    {
        // Validate dữ liệu từ form
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', // Validate mật khẩu
            'phone' => 'required|string|max:15', // Validate số điện thoại
            'address' => 'nullable|string|max:255', // Validate địa chỉ (không bắt buộc)

        ], [
            // Các thông báo lỗi tùy chỉnh
            'email.unique' => 'Email này đã được đăng ký.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',

        ]);
    
        // Tạo người dùng mới
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'role' => 0
        ]);
    
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
        Auth::logout();
        return redirect()->route('home.index'); // Điều hướng về trang login
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