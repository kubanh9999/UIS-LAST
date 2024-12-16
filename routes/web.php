<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admins\AdminCategoryController;
use App\Http\Controllers\Admins\AdminProductController;
use App\Http\Controllers\Admins\AdminUserController;
use App\Http\Controllers\Admins\AdminPostController;
use App\Http\Controllers\Admins\DashboardController;
use App\Http\Controllers\Admins\DiscountController;
use App\Http\Controllers\Admins\AdminOrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ZaloController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\AccountManagementController;
use App\Http\Controllers\Admins\AdminCommentController;
use App\Http\Controllers\Admins\BannerController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\LocationController;
use App\Models\Product; 
Route::get('reset', [AuthController::class, 'resetPasswordForm'])->name('reset');

Route::post('/reset/passwork', [AuthController::class, 'resetPassword'])->name('reset.password');
Route::post('/sendPasswok', [AuthController::class, 'sendPasswok'])->name('sendPasswok');
Route::get('/delete-category/{categoryId}', [ProductController::class, 'deleteCategory'])->name('category.delete');

Route::get('/api/product-count', function() {
    return response()->json(['count' => Product::count()]);
});
Route::get('/api/order-stats', [DashboardController::class, 'getOrderStats']);


Route::get('/api/products', action: function() {
    return response()->json(['products' => Product::all()]);
});
/* Route::get('/api/product-stock', function() {
    $productsInStock = Product::where('stock', '>', 0)
    return response()->json(['stock' => $productsInStock]);
}); */
Route::get('/get-districts/{provinceId}', [LocationController::class, 'getDistricts']);
Route::get('/get-provinces', [LocationController::class, 'getProvinces']);

Route::get('/get-wards/{districtId}', [LocationController::class, 'getWards']);

// gửi gmail check otp
Route::post('/send-verification-code', [AuthController::class, 'sendVerificationCode'])->name('verification.send');
Route::post('/verify-code', [AuthController::class, 'verifyCode'])->name('verification.verify');

Route::put('/admin/updateCategory/{id}', [AdminPostController::class, 'updateCategory'])->name('admin.post.updateCategory');
Route::get('/post/{id}/editCategory', [AdminPostController::class, 'editCategory'])->name('admin.post.editCategory');
Route::get('/post/delete/{id}', [AdminPostController::class, 'deletePost'])->name('admin.post.delete');
Route::get('admin/index/post', [AdminPostController::class, 'index_categories'])->name('admin.indexCategory.post');
Route::get('admin/create/post', [AdminPostController::class, 'createCategory'])->name('admin.createCategory.post');
Route::post('admin/index/store', [AdminPostController::class, 'storeCategory'])->name('admin.storeCategory.post');


/* kết thúc post */
/*tìm kiếm giỏ quà */
Route::get('/search-fruits', [ProductController::class, 'searchFruits'])->name('search.fruits');
/* in hóa đơn */

Route::get('/orders/print/{id}', [OrderController::class, 'printInvoice'])->name('order.print');
/* load sp dm home */
Route::get('/products/category/{categoryName}', [HomeController::class, 'getProductsByCategory'])->name('products.category.name');
/*gửi gmail concact */
Route::post('/submit_form', [ContactController::class, 'sendEmail'])->name('contact.send');

Route::get('/admin/products/gift', [AdminProductController::class, 'gift'])->name('admin.products.gift');


// use Laravel\Socialite\Facades\Socialite;
// use App\Http\Controllers\Auth\LoginController;

// Route::get('/login/facebook', [LoginController::class, 'redirectToFacebook']);
// Route::get('/login/facebook/callback', [LoginController::class, 'handleFacebookCallback']);
// Route::get('/chat', [ChatController::class, 'index'])->middleware('auth'); // Chỉ cho phép người dùng đã đăng nhập
// Route::post('/send-message', [ChatController::class, 'sendMessage'])->middleware('auth'); // Route gửi tin nhắn


Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

Route::get('/products/categorys/{category}', [ProductController::class, 'showByCategory'])->name('products.byCategory');

// Route::get('/notifications', [HomeController::class, 'index'])->name('notifications.index');
// Route::post('/notifications/{id}/read', [HomeController::class, 'markAsRead'])->name('notifications.read');
Route::get('/product', [ProductController::class, 'index'])->name('products.index');

Route::get('/product/{id}', [ProductController::class, 'detail'])->name('product.detail');

// Comment
Route::post('/products/{productId}/comments', [CommentController::class, 'post_comment'])->name('product.comment');
Route::post('/comments/{id}/like', [CommentController::class, 'like'])->name('comment.like');
// Route::post('/comments/{id}/unlike', [CommentController::class, 'unlike'])->name('comment.unlike');
Route::post('/comments/{id}/reply', [CommentController::class, 'reply'])->name('comment.reply');
Route::delete('/comments/{id}', [CommentController::class, 'delete'])->name('comment.delete');

// Tìm kiếm sản phẩm
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search'); 

//Giới thiệu
Route::get('/introduction', [HomeController::class, 'introduction'])->name('home.introduction'); 
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index'); 
//b à i v i ế t
Route::get('posts', [PostController::class, 'index'])->name('posts.index');
Route::get('posts/{id}', [PostController::class, 'show'])->name('post.show');

// Hiển thị giỏ hàng
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::put('/cart/update/{id}', [CartController::class, 'updateCart'])->name('cart.update');
Route::delete('/cart/delete/{id}', [CartController::class, 'delete'])->name('cart.delete');
Route::delete('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');


// chi tiết giỏ quà
Route::get('/gift/{id}', [HomeController::class, 'giftDetail'])->name('product.giftDetail');
//chi tiết từng thành phần trong giỏ quà
Route::get('/basket/select-fruits/{id}', [HomeController::class, 'selectFruits'])->name('basket.selectFruits');
Route::post('/cart/add-gift-basket/{basket_id}', [CartController::class, 'addGiftBasketToCart'])->name('cart.addGiftBasketToCart');

// Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'checkout'])->name('checkout.process');
Route::post('/checkout/complete', [CheckoutController::class, 'completeCheckout'])->name('checkout.complete');
Route::get('/checkout/success', [CheckoutController::class, 'completeCheckout'])->name('checkout.success');
Route::get('/confirmOrder/{token}', [CheckoutController::class, 'confirmOrder'])->name('confirm.order');
Route::post('/apply-discount', [CheckoutController::class, 'applyDiscount'])->name('applyDiscount');

//User
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('login/google', [AuthController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('login.google.callback');
Route::get('/account/info', [AccountManagementController::class, 'showUserInfo'])->name('account.info');
Route::post('/account/update', [AccountManagementController::class, 'updateUserInfo'])->name('account.update');

// Gửi mail
Route::post('/subscribe', [SubscriberController::class, 'store'])->name('subscribe');


// User Management
Route::get('/account/management', [AccountManagementController::class, 'management'])->name('account.management');
Route::get('/change-password', [AccountManagementController::class, 'changePassword'])->name('change-password');
Route::post('/change-password', [AccountManagementController::class, 'updatePassword'])->name('update-password');
Route::get('/account/management/order/detail/{id}', [AccountManagementController::class, 'orderDetail'])->name('account.management.order.detail');
// Route hủy đơn hàng
Route::post('/account/order/{orderId}/cancel', [AccountManagementController::class, 'cancelOrder'])->name('account.order.cancel');
// Route xác nhận đơn hàng
Route::post('/account/order/confirm/{orderId}', [AccountManagementController::class, 'completeOrder'])->name('order.confirm');


//Admin
Route::get('/admin/product/edit/{id}', [AdminProductController::class, 'editGift'])->name('admin.gift.edit');
Route::put('/admin/product/update/{id}', [AdminProductController::class, 'updateGift'])->name('admin.gift.update');
Route::delete('/admin/gift-baskets/{id}', [AdminProductController::class, 'destroyGift'])->name('admin.gift_baskets.destroy');

Route::prefix('admin')->middleware('checkAdmin')->group(function () {

    // Route chính cho trang dashboard
    Route::get('/', [DashboardController::class, '__invoke'])->name('admin.dashboard.index');

    // Route cho các chức năng trong dashboard
    Route::prefix('dashboard')->group(function () {

        // Route lấy danh sách người dùng
        Route::get('/get-users', [DashboardController::class, 'getUsers'])->name('admin.dashboard.getUsers');

        // Route lấy danh sách sản phẩm
        Route::get('/get-products', [DashboardController::class, 'getProducts'])->name('admin.dashboard.getProducts');

        // Route lấy danh sách đơn hàng
        Route::get('/get-orders', [DashboardController::class, 'getOrder'])->name('admin.dashboard.getOrders');

        // Route lấy danh sách khuyến mãi
        Route::get('/get-discounts', [DashboardController::class, 'getDiscounts'])->name('admin.dashboard.getDiscounts');

    });
});


    Route::post('/admin/products/update-field', [AdminProductController::class, 'updateField']);

    Route::post('/admin/orders/update-status', [AdminProductController::class, 'updateStatus'])->name('admin.orders.updateStatus');

    Route::resource('admin/products', AdminProductController::class)->names([
        'index' => 'admin.products.index',
        'create' => 'admin.products.create',
        'store' => 'admin.products.store',
        'show' => 'admin.products.show',
        'edit' => 'admin.products.edit',
        'update' => 'admin.products.update',
        'destroy' => 'admin.products.destroy',
    ]);
   

    Route::put('/admin/categories/update/full/{id}', [AdminCategoryController::class, 'update1'])->name('admin.categories.update.full');
    Route::resource('admin/categories', AdminCategoryController::class)->names([
        'index' => 'admin.categories.index',
        'create' => 'admin.categories.create',
        'store' => 'admin.categories.store',
        'show' => 'admin.categories.show',
        'edit' => 'admin.categories.edit',
        'update' => 'admin.categories.update',
        'destroy' => 'admin.categories.destroy',
    ]);

    Route::post('/admin/users/toggle-status', [AdminUserController::class, 'toggleStatusq'])->name('users.toggleStatus');
    Route::resource('users', AdminUserController::class)->names([
        'index' => 'admin.users.index',
        'create' => 'admin.users.create',
        'store' => 'admin.users.store',
        'show' => 'admin.users.show',
        'edit' => 'admin.users.edit',
        'update' => 'admin.users.update',
        'destroy' => 'admin.users.destroy',
    ]);
    Route::post('/admin/posts/upload', [PostController::class, 'upload'])->name('admin.posts.upload');

    Route::resource('admin/post', AdminPostController::class)->names([
        'index' => 'admin.post.index',
        'create' => 'admin.post.create',
        'store' => 'admin.post.store',
        'show' => 'admin.post.show',
        'edit' => 'admin.post.edit',
        'update' => 'admin.post.update',
        'destroy' => 'admin.post.destroy',
    ]);
   Route::put('/admin/updateDiscount/{id}', [DiscountController::class, 'updateDiscount'])->name('admin.discount.updateDiscount');
    Route::resource('admin/discount', DiscountController::class)->names([
        'index' => 'admin.discount.index',
        'create' => 'admin.discount.create',
        'store' => 'admin.discount.store',
        'show' => 'admin.discount.show',
        'edit' => 'admin.discount.edit',
        'update' => 'admin.discount.update',
        'destroy' => 'admin.discount.destroy',
    ]);

    Route::resource('admin/order', AdminOrderController::class)->names([
        'index' => 'admin.orders.index',
        'show' => 'admin.orders.details',
        'create' => 'admin.orders.create',
        'store' => 'admin.orders.store',
        'show' => 'admin.orders.show',
        'edit' => 'admin.orders.edit',
        'update' => 'admin.orders.update',
        'destroy' => 'admin.orders.destroy',
    ]);


Route::post('/vnpay_payment', [CheckoutController::class, 'payment'])->name('vnpay_payment');
Route::post('momo', [CheckoutController::class, 'momo'])->name('momo');
Route::post('/momo/ipn', [CheckoutController::class, 'ipn']);

Route::prefix('zaloApi')->group(function () {
    Route::get('api/products', [ZaloController::class, 'index'])->name('zalo.product.index');
    Route::get('api/categories', [ZaloController::class, 'categories'])->name('zalo.cart.index');
    Route::get('api/checkout', [ZaloController::class, 'checkout'])->name('zalo.checkout.index');
    Route::get('api/productsByCategory', [ZaloController::class, 'productsByCategory'])->name('zalo.productsByCategory.index');
});

// Quản lý Bình luận
Route::prefix('admin/comments')->group(function(){
    Route::get('/management', [AdminCommentController::class, 'index'])->name('admin.comments.management');
    Route::get('/detail/{id}', [AdminCommentController::class, 'detail'])->name('admin.comments.detail');
    Route::get('/approve/{id}', [AdminCommentController::class, 'approveComment'])->name('admin.comments.approve');
    Route::put('/hide/{id}', [AdminCommentController::class, 'hideComment'])->name('admin.comments.hide');
    Route::post('/unhide/{id}', [AdminCommentController::class, 'unhideComment'])->name('admin.comments.unhide');
    Route::delete('/delete/{id}', [AdminCommentController::class, 'confirmDelete'])->name('admin.comments.delete');
    // Quản lí chi tiết bình luận con
    Route::delete('/replies/delete/{id}', [AdminCommentController::class, 'deleteReply'])->name('admin.comments.replies.delete');
    Route::put('/replies/hide/{id}', [AdminCommentController::class, 'hideReply'])->name('admin.comments.replies.hide');
    Route::put('/replies/unhide/{id}', [AdminCommentController::class, 'unhideReply'])->name('admin.comments.replies.unhide');
    Route::put('/admin/comments/replies/approve/{id}', [AdminCommentController::class, 'approveReply'])->name('admin.comments.replies.approve');

});

Route::prefix('admin/banners')->group(function () {
    Route::get('/management', [BannerController::class, 'index'])->name('admin.banners.management');
    Route::get('/create', [BannerController::class, 'create'])->name('admin.banners.create');
    Route::post('/store', [BannerController::class, 'store'])->name('admin.banners.store');
    Route::get('/edit/{id}', [BannerController::class, 'edit'])->name('admin.banners.edit');
    Route::put('/update/{id}', [BannerController::class, 'update'])->name('admin.banners.update');
    Route::delete('/destroy/{id}', [BannerController::class, 'destroy'])->name('admin.banners.destroy');
});
