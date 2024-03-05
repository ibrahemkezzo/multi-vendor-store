<?php

use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\front\auth\TwoFactorController;
use App\Http\Controllers\front\CartController;
use App\Http\Controllers\front\CheckoutController;
use App\Http\Controllers\front\CurrencyConverterController;
use App\Http\Controllers\front\HomeController;
use App\Http\Controllers\front\PaymentController;
use App\Http\Controllers\front\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StripeWebhookController;
use Illuminate\Support\Facades\Route;

/*
|---------'-----------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])
    ->name('front.home');

Route::get('/product', [ProductController::class, 'index'])
    ->name('product.index');

Route::get('/product/{product:slug}', [ProductController::class, 'show'])
    ->name('product.show');

Route::get('/auth/user/two-factor', [TwoFactorController::class, 'index'])
    ->name('front.2fa');

Route::get('/auth/{provider}/redirect', [SocialLoginController::class, 'redirect'])
    ->name('auth.social.redirect');

Route::get('/auth/{provider}/callback', [SocialLoginController::class, 'callback'])
    ->name('auth.social.callback');

Route::get('/orders/{order}/payment', [PaymentController::class, 'create'])
    ->name('order.payment.create');

Route::post('/orders/{order}/stripe/payment-intent', [PaymentController::class, 'createStripePaymentIntent'])
    ->name('create.stripe.payment-intent');

Route::get('/orders/{order}/stripe/callback', [PaymentController::class, 'confirm'])
    ->name('stripe.return');

Route::resource('/cart', CartController::class);

Route::get('/checkout', [CheckoutController::class, 'create'])
    ->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'store']);

Route::post('/currency', [CurrencyConverterController::class, 'store'])
    ->name('currency.store');

Route::any('/stripe/webhook',[StripeWebhookController::class,'handle'])
    ->name('stripe.webhook');

Route::middleware('auth')->group(function () {
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/dashboard.php';
// require __DIR__.'/auth.php';
