<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class ContactController extends Controller
{
    
    public function index()
    {
        return view('pages.contact');
    }

    /**
     * Show the form for creating a new resource.
     */





     public function sendEmail(Request $request)
     {
       /*  dd($request->all()); */
         // Xác thực dữ liệu từ form
         $request->validate([
            'category' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|regex:/^[0-9]{10,11}$/',
            'message' => 'required|min:10',
        ], [
            'category.required' => 'Vui lòng chọn danh mục.',
            'name.required' => 'Vui lòng nhập họ và tên của bạn.',
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Email không đúng định dạng. Vui lòng nhập lại.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.regex' => 'Số điện thoại chỉ được chứa 10 đến 11 chữ số.',
            'message.required' => 'Vui lòng nhập nội dung tin nhắn.',
            'message.min' => 'Nội dung tin nhắn phải có ít nhất 10 ký tự.',
        ]);
     
         // Dữ liệu từ form
         $data = [
             'category' => $request->category,
             'name' => $request->name,
             'email' => $request->email,
             'phone' => $request->phone,
             'message' => $request->message,
         ];
     
         // Gửi mail
         try {
            Mail::raw("Họ tên: {$data['name']}\nEmail: {$data['email']}\nSố điện thoại: {$data['phone']}\nNội dung: {$data['message']}", function ($message) use ($data) {
                $message->to('theanhdzno1st@gmail.com')
                        ->subject('Liên hệ từ khách hàng: ' . $data['name'])
                        ->replyTo($data['email']);
            });
        
            return redirect()->back()->with('success', 'Email của bạn đã được gửi thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi gửi email: ' . $e->getMessage());
        }
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
