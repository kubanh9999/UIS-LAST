<?php
namespace App\Http\Middleware;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Middleware\TrustProxies as Middleware;

class TrustProxies extends Middleware
{
    protected $proxies = '*'; // Để cho phép tất cả các nguồn
    protected $headers = Request::HEADER_X_FORWARDED_ALL;

    public function handle($request, \Closure $next)
    {
        return $next($request);
    }
}
