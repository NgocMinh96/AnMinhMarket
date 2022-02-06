<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth;
use App\Http\Controllers\Backend;

Route::group(['middleware' => ['guest:admin']], function () {
    Route::match(['get', 'post'], '/admin', [Auth\AdminLogin::class, 'login'])->name('backend.login');
});

Route::prefix('filemanager')->middleware('auth:admin')->group(function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

Route::prefix('admin')->name('backend.')->group(function () {

    Route::post('logout', [Auth\AdminLogin::class, 'logout'])->name('logout');

    Route::group(['middleware' => ['auth:admin']], function () {
        Route::get('dashboard', [Backend\Dashboard::class, 'index'])->name('dashboard');

        Route::prefix('userinfo')->name('userinfo.')->group(function () {
            Route::get('', [Backend\UserInfoController::class, 'index'])->name('index');
            Route::put('{update_for}', [Backend\UserInfoController::class, 'update'])->name('update');
        });

        Route::prefix('user')->name('user.')->group(function () {
            Route::get('', [Backend\UserController::class, 'index'])
                ->middleware('permission:user-view')->name('index');
            Route::get('create', [Backend\UserController::class, 'create'])
                ->middleware('permission:user-store')->name('create');
            Route::post('', [Backend\UserController::class, 'store'])
                ->middleware('permission:user-store')->name('store');
            Route::get('{id}/edit', [Backend\UserController::class, 'edit'])
                ->middleware('permission:user-update')->name('edit');
            Route::put('{id}', [Backend\UserController::class, 'update'])
                ->middleware('permission:user-update')->name('update');
            Route::delete('{id}', [Backend\UserController::class, 'destroy'])
                ->middleware('permission:user-destroy')->name('destroy');
        });

        Route::prefix('role')->name('role.')->group(function () {
            Route::get('', [Backend\RoleController::class, 'index'])
                ->middleware('permission:role-view')->name('index');
            Route::get('create', [Backend\RoleController::class, 'create'])
                ->middleware('permission:role-store')->name('create');
            Route::post('', [Backend\RoleController::class, 'store'])
                ->middleware('permission:role-store')->name('store');
            Route::get('{id}/edit', [Backend\RoleController::class, 'edit'])
                ->middleware('permission:role-update')->name('edit');
            Route::put('{id}', [Backend\RoleController::class, 'update'])
                ->middleware('permission:role-update')->name('update');
            Route::delete('{id}', [Backend\RoleController::class, 'destroy'])
                ->middleware('permission:role-destroy')->name('destroy');
        });

        Route::prefix('post-list')->name('postlist.')->group(function () {
            Route::get('', [Backend\PostListController::class, 'index'])
                ->middleware('permission:post-list-view')->name('index');
            Route::get('create', [Backend\PostListController::class, 'create'])
                ->middleware('permission:post-list-store')->name('create');
            Route::post('', [Backend\PostListController::class, 'store'])
                ->middleware('permission:post-list-store')->name('store');
            Route::get('{id}/edit', [Backend\PostListController::class, 'edit'])
                ->middleware('permission:post-list-update')->name('edit');
            Route::put('{id}', [Backend\PostListController::class, 'update'])
                ->middleware('permission:post-list-update')->name('update');
            Route::delete('{id}', [Backend\PostListController::class, 'destroy'])
                ->middleware('permission:post-list-destroy')->name('destroy');
        });

        Route::prefix('product-category')->name('productcategory.')->group(function () {
            Route::get('', [Backend\ProductCategoryController::class, 'index'])
                ->middleware('permission:product-category-view')->name('index');
            Route::get('create', [Backend\ProductCategoryController::class, 'create'])
                ->middleware('permission:product-category-store')->name('create');
            Route::post('', [Backend\ProductCategoryController::class, 'store'])
                ->middleware('permission:product-category-store')->name('store');
            Route::get('{id}/edit', [Backend\ProductCategoryController::class, 'edit'])
                ->middleware('permission:product-category-update')->name('edit');
            Route::put('{id}', [Backend\ProductCategoryController::class, 'update'])
                ->middleware('permission:product-category-update')->name('update');
            Route::delete('{id}', [Backend\ProductCategoryController::class, 'destroy'])
                ->middleware('permission:product-category-destroy')->name('destroy');
        });

        Route::prefix('product-list')->name('productlist.')->group(function () {
            Route::get('', [Backend\ProductListController::class, 'index'])
                ->middleware('permission:product-list-view')->name('index');
            Route::get('create', [Backend\ProductListController::class, 'create'])
                ->middleware('permission:product-list-store')->name('create');
            Route::post('store', [Backend\ProductListController::class, 'store'])
                ->middleware('permission:product-list-store')->name('store');
            Route::get('{id}/edit', [Backend\ProductListController::class, 'edit'])
                ->middleware('permission:product-list-update')->name('edit');
            Route::put('{id}', [Backend\ProductListController::class, 'update'])
                ->middleware('permission:product-list-update')->name('update');
            Route::delete('{id}', [Backend\ProductListController::class, 'destroy'])
                ->middleware('permission:product-list-destroy')->name('destroy');
        });

        Route::prefix('product-image')->name('productimage.')->group(function () {
            Route::get('{product_id}', [Backend\ProductImageController::class, 'index'])
                ->middleware('permission:product-image-view')->name('index');
            Route::put('{product_id}', [Backend\ProductImageController::class, 'store'])
                ->middleware('permission:product-image-store')->name('store');
            Route::patch('{image_id}/{product_id}', [Backend\ProductImageController::class, 'update'])
                ->middleware('permission:product-image-update')->name('update');
            Route::delete('{image_id}/{product_id}', [Backend\ProductImageController::class, 'destroy'])
                ->middleware('permission:product-image-destroy')->name('destroy');
        });

        Route::prefix('settings')->name('setting.')->group(function () {
            Route::get('', [Backend\SettingController::class, 'index'])
                ->middleware(['permission:setting-view'])->name('index');
            Route::put('{update_for}', [Backend\SettingController::class, 'update'])
                ->middleware(['permission:setting-update'])->name('update');
        });

        Route::prefix('coupons')->name('coupon.')->group(function () {
            Route::get('', [Backend\CouponController::class, 'index'])
                ->middleware(['permission:coupon-view'])
                ->name('index');
            Route::get('create', [Backend\CouponController::class, 'create'])
                ->middleware(['permission:coupon-store'])
                ->name('create');
            Route::post('store', [Backend\CouponController::class, 'store'])
                ->middleware(['permission:coupon-store'])
                ->name('store');
            Route::get('{id}/edit', [Backend\CouponController::class, 'edit'])
                ->middleware(['permission:coupon-update'])
                ->name('edit');
            Route::put('{id}', [Backend\CouponController::class, 'update'])
                ->middleware(['permission:coupon-update'])
                ->name('update');
            Route::delete('{id}', [Backend\CouponController::class, 'destroy'])
                ->middleware(['permission:coupon-destroy'])
                ->name('destroy');
        });

        Route::prefix('orders')->name('order.')->group(function () {
            Route::get('', [Backend\OrderController::class, 'index'])
                ->middleware(['permission:order-view'])
                ->name('index');
            Route::get('{id}/show', [Backend\OrderController::class, 'show'])
                ->middleware(['permission:order-invoice'])
                ->name('show');
            Route::delete('{id}', [Backend\OrderController::class, 'destroy'])
                ->middleware(['permission:order-destroy'])
                ->name('destroy');
            Route::put('changePaymentStatus', [Backend\OrderController::class, 'changePaymentStatus'])
                ->middleware(['permission:order-change-status'])
                ->name('changePaymentStatus');
            Route::put('changeOrderStatus', [Backend\OrderController::class, 'changeOrderStatus'])
                ->middleware(['permission:order-change-status'])
                ->name('changeOrderStatus');
        });

        // Route::resource('user', Backend\UserController::class)->except('show');
        // Route::resource('role', Backend\RoleController::class)->except('show');
        // Route::resource('permission', Backend\PermissionController::class)->except('show');
        // Route::resource('post', Backend\PostController::class)->except('show');
        // Route::resource('category', Backend\ProductCategoryController::class)->except('show');
        // Route::resource('product', Backend\ProductListController::class)->except('show');
    });
});
