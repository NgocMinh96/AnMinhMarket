<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend;
use App\Http\Controllers\Backend;

Route::get('', [Frontend\ShopController::class, 'index'])->name('frontend.shop.index');
Route::get('cua-hang', [Frontend\ShopController::class, 'index'])->name('frontend.shop.index');
Route::get('san-pham/{id}/{slug}', [Frontend\ShopController::class, 'show'])->name('frontend.shop.show');
Route::get('/modal', [Frontend\ShopController::class, 'modal'])->name('frontend.modal');
Route::get('cua-hang/{slug}/{category_id}', [Frontend\ShopController::class, 'index'])->name('frontend.shop.category');
Route::get('bai-viet', [Frontend\PostController::class, 'index'])->name('frontend.post.index');
Route::get('bai-viet/{id}/{slug}', [Frontend\PostController::class, 'show'])->name('frontend.post.show');
Route::get('lien-he', [Frontend\ContactController::class, 'index'])->name('frontend.contact.index');

Route::get('storeCart', [Frontend\CartController::class, 'store'])->name('frontend.cart.store');
Route::get('updateCart', [Frontend\CartController::class, 'update'])->name('frontend.cart.update');
Route::get('destroyCart', [Frontend\CartController::class, 'destroy'])->name('frontend.cart.destroy');
Route::get('dat-hang', [Frontend\CartController::class, 'index'])->name('frontend.cart.index');
Route::get('appluCoupon', [Frontend\CartController::class, 'applyCoupon'])->name('frontend.cart.applyCoupon');
Route::get('getDistrict', [Frontend\CartController::class, 'getDistrict'])->name('frontend.cart.getDistrict');
Route::get('getWard', [Frontend\CartController::class, 'getWard'])->name('frontend.cart.getWard');
Route::put('storeOrder', [Backend\OrderController::class, 'store'])->name('backend.order.store');
