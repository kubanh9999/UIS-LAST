<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebhookController extends Controller
{
   // app/Http/Controllers/WebhookController.php
   public function handleWebhook(Request $request)
   {
    dd( $request->get('hub_challenge'));
       // Kiểm tra dữ liệu POST
       \Log::info('Received Webhook:', $request->all());

       // Nếu là yêu cầu GET từ Facebook xác minh webhook
       if ($request->get('hub_mode') === 'subscribe' && 
           $request->get('hub_verify_token') === env('WEBHOOK_VERIFY_TOKEN')) {
           return response($request->get('hub_challenge'), 200);
       }

       // Xử lý POST request
       \Log::info('POST Data:', $request->all()); // Ghi lại dữ liệu POST

       return response('xin lỗi', 200);
   }
}
