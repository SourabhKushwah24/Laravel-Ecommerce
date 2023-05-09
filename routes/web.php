<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();
// HOME ROUTES



Route::controller(App\Http\Controllers\Frontend\FrontendController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/collections', 'categories');
    Route::get('/collections/{category_slug}', 'product');
    Route::get('/collections/{category_slug}/{product_slug}', 'productView');
    Route::get('/new-arrivals', 'newArrivals');
    Route::get('/featured', 'featuredProduct');
});


Route::middleware(['auth'])->group(function () {

    Route::get('wishlist/', [App\Http\Controllers\Frontend\WishlistController::class, 'index']);
    Route::get('cart/', [App\Http\Controllers\Frontend\CartController::class, 'index']);
    Route::get('checkout/', [App\Http\Controllers\Frontend\CheckoutController::class, 'index']);
    Route::get('order/', [App\Http\Controllers\Frontend\OrderController::class, 'index']);
    Route::get('order/{orderId}', [App\Http\Controllers\Frontend\OrderController::class, 'show']);
});
Route::get('/thank-you', [App\Http\Controllers\Frontend\FrontendController::class, 'thankyou']);


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index']);


    Route::controller(App\Http\Controllers\Admin\SliderController::class)->group(function () {
        Route::get('/slider', 'index');
        Route::get('/slider/create', 'create');
        Route::post('/slider', 'store');
        Route::get('/slider/{slider}/edit', 'edit');
        Route::put('/slider/{slider}/', 'update');
        Route::get('/slider/{slider}/delete', 'delete');
    });
    // Catagory Group Route
    Route::controller(App\Http\Controllers\Admin\CategortController::class)->group(function () {
        Route::get('/category', 'index');
        Route::get('/category/create', 'create');
        Route::post('/category', 'store');

        Route::get('/category/{category}/edit', 'edit');
        Route::put('/category/{category}/', 'update');
    });

    // Curd using Livewire
    Route::get('/brands', App\Http\Livewire\Admin\Brand\Index::class);

    Route::controller(App\Http\Controllers\Admin\ProductController::class)->group(function () {
        Route::get('/product', 'index');
        Route::get('/product/create', 'create');
        Route::post('/product', 'store');
        Route::get('/product/{product}/edit', 'edit');
        Route::put('/product/{product}/', 'update');
        Route::get('/product/{product_id}/delete', 'delete');
        Route::get('/product-image/{product_image_id}/delete', 'destroyImage');
        Route::post('/product-color/{product_color_id}', 'updateProductColorQty');
        Route::get('product-color/{product_color_id}/delete', 'deleteProductColor');
    });

    Route::controller(App\Http\Controllers\Admin\ColorController::class)->group(function () {
        Route::get('/color', 'index');
        Route::get('/color/create', 'create');
        Route::post('/color/', 'store');
        Route::get('/color/{color}/edit', 'edit');
        Route::put('/color/{color_id}/', 'update');
        Route::get('/color/{color_id}/delete', 'delete');
    });
    Route::controller(App\Http\Controllers\Admin\OrderController::class)->group(function () {
        Route::get('/order', 'index');
        Route::get('/order/{orderId}', 'show');
        Route::put('/order/{orderId}', 'updateOrderStatus');
        Route::get('/invoice/{orderId}', 'viewInvoice');
        Route::get('/invoice/{orderId}/generate', 'downloadInvoice');
    });
});
