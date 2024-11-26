<?php

use App\Models\Customer;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\SliderControllerView;
use App\Http\Controllers\ProductControllerView;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\Users\LoginController;
use App\Http\Controllers\Customer\CustomerCartController;
use App\Http\Controllers\Customer\MainCustomerController;
use App\Http\Controllers\Customer\LoginCustomerController;

Route::get('admin/users/login', [LoginController::class, 'index'])->name('login');

Route::post('admin/users/login/store', [LoginController::class, 'store']);

Route::get('signout', [LoginController::class, 'signOut'])->name('signout');

Route::middleware(['auth'])->group(function () {

    Route::prefix('admin')->group(function () {

        Route::get('/', [MainController::class, 'index'])->name('admin');
        Route::get('main', [MainController::class, 'index']);

        #Menu
        Route::prefix('menus')->group(function () {
            Route::get('add', [MenuController::class, 'create']);
            Route::post('add', [MenuController::class, 'store']);
            Route::get('list', [MenuController::class, 'index']);
            Route::get('edit/{menu}', [MenuController::class, 'show']);
            Route::post('edit/{menu}', [MenuController::class, 'update']);
            Route::DELETE('destroy', [MenuController::class, 'destroy']);
        });

        #Product
        Route::prefix('products')->group(function () {
            Route::get('add', [ProductController::class, 'create']);
            Route::post('add', [ProductController::class, 'store']);
            Route::get('list', [ProductController::class, 'index']);
            Route::get('edit/{product}', [ProductController::class, 'show']);
            Route::post('edit/{product}', [ProductController::class, 'update']);
            Route::DELETE('destroy', [ProductController::class, 'destroy']);
            Route::get('products/list', [ProductController::class, 'index'])->name('admin.products.list');
            // Route chỉnh sửa sản phẩm
            Route::prefix('admin')->group(function () {
                // Route::get('products/edit/{encrypted_id}', [ProductController::class, 'edit'])->name('admin.products.edit');
                // Route::post('products/update/{encrypted_id}', [ProductController::class, 'update'])->name('admin.products.update');
                // Route::post('/admin/products/update/{encrypted_id}', [ProductController::class, 'update'])->name('admin.products.update');
                Route::get('admin/products/edit/{encrypted_id}', [ProductController::class, 'edit'])->name('admin.products.edit');
                Route::post('admin/products/update/{encrypted_id}', [ProductController::class, 'update'])->name('admin.products.update');
            });
        });

        #Slider
        Route::prefix('sliders')->group(function () {
            Route::get('add', [SliderController::class, 'create']);
            Route::post('add', [SliderController::class, 'store']);
            Route::get('list', [SliderController::class, 'index']);
            Route::get('edit/{slider}', [SliderController::class, 'show']);
            Route::post('edit/{slider}', [SliderController::class, 'update']);
            Route::DELETE('destroy', [SliderController::class, 'destroy']);
        });

        #Upload
        Route::post('upload/services', [\App\Http\Controllers\Admin\UploadController::class, 'store']);

        #Cart
        Route::get('customers', [\App\Http\Controllers\Admin\CartController::class, 'index']);
        Route::get('customers/view/{customer}', [\App\Http\Controllers\Admin\CartController::class, 'show']);
        Route::DELETE('destroyCartAdmin', [\App\Http\Controllers\Admin\CartController::class, 'destroy']);
    });
});

Route::get('/', [App\Http\Controllers\MainController::class, 'index']);
Route::post('/services/load-product', [App\Http\Controllers\MainController::class, 'loadProduct']);

Route::get('danh-muc/{id}-{slug}.html', [App\Http\Controllers\MenuController::class, 'index']);
// Route::get('danh-muc/{id}-{slug}.html', [MenuController::class, 'index'])->name('menu.index');
// Route::get('/admin/menus/edit/{encrypted_id}', [MenuController::class, 'edit'])->name('admin.menus.edit');
// Route::post('/admin/menus/update/{encrypted_id}', [MenuController::class, 'update'])->name('admin.menus.update');
// Route::post('/admin/menus/destroy', [MenuController::class, 'destroy'])->name('admin.menus.destroy');


// Route::get('san-pham/{id}-{slug}.html', [App\Http\Controllers\ProductControllerView::class, 'index']);
Route::get('san-pham/{encrypted_id}-{slug}.html', [App\Http\Controllers\ProductControllerView::class, 'index']);



Route::post('add-cart', [App\Http\Controllers\CartController::class, 'index']);
Route::get('carts', [App\Http\Controllers\CartController::class, 'show']);
Route::post('update-cart', [App\Http\Controllers\CartController::class, 'update']);
Route::get('carts/delete/{id}', [App\Http\Controllers\CartController::class, 'remove']);
Route::post('carts', [App\Http\Controllers\CartController::class, 'addCart']);

Route::get('admin/users/register',[LoginController::class, 'indexRegister'])->name('indexRegister');
Route::post('admin/users/register',[LoginController::class, 'register'])->name('register');


Route::get('admin/users/forget-password',[LoginController::class, 'forgetPassword'])->name('forgetPassword');//Hien thi form quen mat khau
Route::post('admin/users/forget-password',[LoginController::class, 'postForgetPass'])->name('postForgetPass'); // khi submit quen mat khau
Route::get('admin/users/get-password',[LoginController::class, 'getPassword'])->name('getPassword');    // gui link
Route::get('admin/users/get-password/{customer}/{token}',[LoginController::class, 'postGetPassword']);    // nhap lai mat khau 2 lan
Route::get('/search-products', [ProductControllerView::class, 'searchProduct'])->name('search.products');
Route::get('/list', [ProductControllerView::class, 'searchProduct'])->name('list');

//Customer
Route::get('customer/login', [LoginCustomerController::class, 'index'])->name('login.customer');
Route::post('customer/login/store', [LoginCustomerController::class, 'store']);
Route::get('customer/register', [LoginCustomerController::class, 'indexRegister'])->name('indexRegister.customer');
Route::post('customer/register', [LoginCustomerController::class, 'register'])->name('register.customer');
Route::post('signout', [LoginCustomerController::class, 'signOut'])->name('signout.customer');




Route::get('/product/{productId}/reviews', [ReviewController::class, 'index']); // Để hiển thị trang review
Route::post('/product/{productId}/reviews', [ReviewController::class, 'store'])->name('reviews.store'); // Để thêm đánh giá



// Route để thêm sản phẩm vào wishlist
Route::post('/wishlist/{productId}', [WishlistController::class, 'store'])->name('wishlist.store');

// Route để hiển thị danh sách sản phẩm yêu thích
Route::post('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');




Route::middleware(['auth:customer'])->group(function () {

    Route::prefix('customer')->group(function () {

        Route::get('/', [MainCustomerController::class, 'index'])->name('customer');
        Route::post('profile', [MainCustomerController::class, 'profile'])->name('profile.customer');
        Route::get('profile', [MainCustomerController::class, 'profile']);

        Route::get('customers/view/{customer}', [CustomerCartController::class, 'show']);

    });
});
Route::get('mail', [CustomerCartController::class, 'mail']);
