<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\RegisterController;
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

/*
 * Guest authentication routes.
 */
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');

    Route::get('/forgot-password', [PasswordResetController::class, 'request'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'email'])->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'reset'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'update'])->name('password.update');
});

/*
 * Authenticated routes (login required, email not necessarily verified).
 */
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::get('/email/verify', [EmailVerificationController::class, 'notice'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
    Route::post('/email/verification-notification', [EmailVerificationController::class, 'resend'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
});

/*
 * Seller management area (login + verified email required).
 */
Route::middleware(['auth', 'verified'])->group(function () {
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
});

/*
 * Public customer-facing routes.
 */
Route::get('/orders/{order:order_code}/summary', [CustomerOrderController::class, 'summary'])->name('orders.summary');
Route::post('/orders/{order:order_code}/payment-proof', [CustomerOrderController::class, 'uploadProof'])->name('orders.payment-proof');
Route::get('/orders/{order:order_code}/status', [CustomerOrderController::class, 'status'])->name('orders.status');
Route::get('/status', [CustomerOrderController::class, 'lookupForm'])->name('orders.lookup');
Route::post('/status', [CustomerOrderController::class, 'lookup'])->name('orders.lookup.submit');

Route::get('/{seller:slug}', [PublicStoreController::class, 'show'])->name('public.store');
Route::get('/{seller:slug}/order', [CustomerOrderController::class, 'create'])->name('public.order.create');
Route::post('/{seller:slug}/order', [CustomerOrderController::class, 'store'])->name('public.order.store');
