<?php

use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\MarketingController;
use App\Http\Controllers\PublicStoreController;
use App\Http\Controllers\SellerDashboardController;
use App\Http\Controllers\SellerFormBuilderController;
use App\Http\Controllers\SellerOnboardingController;
use App\Http\Controllers\SellerOrderController;
use App\Http\Controllers\SellerPageBuilderController;
use App\Http\Controllers\SellerPaymentSettingsController;
use App\Http\Controllers\SellerProductController;
use App\Http\Controllers\SellerSubscriptionController;
use Illuminate\Support\Facades\Route;

Route::get('/', MarketingController::class)->name('home');
Route::get('/demo', DemoController::class)->name('demo');

Route::get('/start', [SellerOnboardingController::class, 'create'])->name('seller.start');
Route::post('/start', [SellerOnboardingController::class, 'store'])->name('seller.start.store');

Route::prefix('seller')->name('seller.')->group(function () {
    Route::get('/dashboard', SellerDashboardController::class)->name('dashboard');
    Route::get('/page-builder', [SellerPageBuilderController::class, 'edit'])->name('page-builder');
    Route::post('/page-builder', [SellerPageBuilderController::class, 'update'])->name('page-builder.update');
    Route::get('/products', [SellerProductController::class, 'index'])->name('products.index');
    Route::post('/products', [SellerProductController::class, 'store'])->name('products.store');
    Route::put('/products/{product}', [SellerProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [SellerProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/form-builder', [SellerFormBuilderController::class, 'edit'])->name('form-builder');
    Route::post('/form-builder', [SellerFormBuilderController::class, 'update'])->name('form-builder.update');
    Route::get('/payment', [SellerPaymentSettingsController::class, 'edit'])->name('payment');
    Route::post('/payment', [SellerPaymentSettingsController::class, 'update'])->name('payment.update');
    Route::get('/subscription', [SellerSubscriptionController::class, 'edit'])->name('subscription');
    Route::post('/subscription', [SellerSubscriptionController::class, 'update'])->name('subscription.update');
    Route::get('/orders', [SellerOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [SellerOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}', [SellerOrderController::class, 'update'])->name('orders.update');
});

Route::get('/orders/{order:order_code}/summary', [CustomerOrderController::class, 'summary'])->name('orders.summary');
Route::post('/orders/{order:order_code}/payment-proof', [CustomerOrderController::class, 'uploadProof'])->name('orders.payment-proof');
Route::get('/orders/{order:order_code}/status', [CustomerOrderController::class, 'status'])->name('orders.status');
Route::get('/status', [CustomerOrderController::class, 'lookupForm'])->name('orders.lookup');
Route::post('/status', [CustomerOrderController::class, 'lookup'])->name('orders.lookup.submit');

Route::get('/{seller:slug}', [PublicStoreController::class, 'show'])->name('public.store');
Route::get('/{seller:slug}/order', [CustomerOrderController::class, 'create'])->name('public.order.create');
Route::post('/{seller:slug}/order', [CustomerOrderController::class, 'store'])->name('public.order.store');
