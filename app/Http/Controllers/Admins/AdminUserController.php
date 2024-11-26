<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::where('role', '!=', 1) 
        ->orderBy('id', 'desc')
        ->get();

        return view('admin.users.index',compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'), // Đảm bảo có trường này trong migration
            'password' => Hash::make($request->input('password')), // Mã hóa mật khẩu
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'role' => $request->input('role'),
        ]);
        return redirect()->route('admin.users.index')->with('success', 'User đã được thêm thành công!');
    }

    /**
     * Display the specified resource.
     */
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id); // Lấy người dùng theo ID
        return view('admin.users.edit', compact('user')); // Trả về view với thông tin người dùng
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id); 
        $user->name = $request->input('name');
        $user->email = $request->input('email');
    
        if ($request->filled('password')) { 
            $user->password = Hash::make($request->input('password'));
        }
    
        $user->phone = $request->input('phone');
        $user->address = $request->input('address');
        $user->role = $request->input('role');
        $user->save();
    
        return redirect()->route('admin.users.index')->with('success', 'User đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Tìm người dùng theo ID, nếu không tìm thấy sẽ ném ra 404
        $user = User::findOrFail($id);
        
        // Xóa người dùng
        $user->delete();
        
        // Chuyển hướng về trang danh sách người dùng với thông báo thành công
        return redirect()->route('admin.users.index')->with('success', 'User đã được xóa thành công!');
    }

    // UserController.php

    public function toggleStatus(Request $request)
    {
        $user = User::find($request->id);
        $user->status = $request->status; // Cập nhật trạng thái
        $user->save();

        return response()->json(['success' => true]);
    }
    

}
