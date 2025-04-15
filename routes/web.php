<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\SliderController as AdminSliderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Front-end routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');

// Product routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/category/{slug}', [ProductController::class, 'category'])->name('category.products');

// Cart routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::post('/cart/apply-coupon', [CartController::class, 'applyCoupon'])->name('cart.apply.coupon');
Route::get('/cart/remove-coupon', [CartController::class, 'removeCoupon'])->name('cart.remove-coupon');
Route::get('/cart/count', [CartController::class, 'getCount'])->name('cart.count');
Route::get('/cart/fix-images', [CartController::class, 'fixCartImages'])->name('cart.fix-images');

// Contact routes
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Authenticated user routes
Route::middleware('auth')->group(function () {
    // User profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // User dashboard
    Route::get('/my-account', [UserProfileController::class, 'index'])->name('user.account');
    Route::get('/my-orders', [UserProfileController::class, 'orders'])->name('user.orders');
    Route::get('/order/{id}', [UserProfileController::class, 'orderDetail'])->name('user.order.detail');
    
    // Favorites
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/add/{product}', [FavoriteController::class, 'add'])->name('favorites.add');
    Route::delete('/favorites/remove/{product}', [FavoriteController::class, 'remove'])->name('favorites.remove');
    Route::post('/favorites/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
    Route::post('/favorites/check', [FavoriteController::class, 'check'])->name('favorites.check');
    
    // Reviews
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    
    // Checkout routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
});

// Admin routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Admin User management
    Route::resource('users', UserController::class, ['as' => 'admin']);
    Route::get('users/{id}/details', [UserController::class, 'getUserDetails'])->name('admin.users.details');
    
    // Admin Category management
    Route::resource('categories', AdminCategoryController::class, ['as' => 'admin']);
    
    // Admin Product management
    Route::resource('products', AdminProductController::class, ['as' => 'admin']);
    Route::post('/products/upload-image', [AdminProductController::class, 'uploadImage'])->name('admin.products.upload-image');
    
    // Admin Order management
    Route::resource('orders', AdminOrderController::class, ['as' => 'admin']);
    Route::get('/orders/status/{status}', [AdminOrderController::class, 'ordersByStatus'])->name('admin.orders.status');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    
    // Admin Slider management
    Route::resource('sliders', AdminSliderController::class, ['as' => 'admin']);
    
    // Admin Contact management
    Route::resource('contacts', AdminContactController::class, ['as' => 'admin']);
    Route::get('/contacts/{contact}/reply', [AdminContactController::class, 'replyForm'])->name('admin.contacts.reply');
    Route::post('/contacts/{contact}/send-reply', [AdminContactController::class, 'sendReply'])->name('admin.contacts.send-reply');
    Route::patch('/contacts/{contact}/update-status', [AdminContactController::class, 'updateStatus'])->name('admin.contacts.update-status');
    
    // Admin Coupon management
    Route::resource('coupons', AdminCouponController::class, ['as' => 'admin']);
});

require __DIR__.'/auth.php';
