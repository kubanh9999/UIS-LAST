<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use App\Models\Product; 
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
{
    $productCount = Product::count();
    View::share('productCount', $productCount);
}

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
