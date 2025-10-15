<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
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

Route::middleware('web')->group(function () {
    // --- Public Routes (Accessible to everyone) ---
    Route::get('/', [HomeController::class, 'index'])->name('pages.home.index');
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

    // --- Currency Management Routes ---
    Route::post('/change-currency', [CurrencyController::class, 'changeCurrency'])->name('currency.change');
    Route::get('/api/currency/current', [CurrencyController::class, 'getCurrentCurrency'])->name('currency.current');
    Route::get('/api/currency/available', [CurrencyController::class, 'getAvailableCurrencies'])->name('currency.available');
    Route::post('/api/currency/convert', [CurrencyController::class, 'convertPrice'])->name('currency.convert');

    // --- Demo Route ---
    Route::get('/currency-demo', fn () => view('example_usage'))->name('currency.demo');

    // --- Guest Routes (Only for unauthenticated users) ---
    Route::middleware('guest')->group(function () {
        Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
        Route::post('/register', [AuthController::class, 'register']);
        Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AuthController::class, 'login']);
    });

    // --- Cart Management (Available to both guests and authenticated users) ---
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::patch('/cart/update/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{cartItem}', [CartController::class, 'destroy'])->name('cart.destroy');

    // --- Authenticated Routes (Requires user to be logged in) ---
    Route::middleware('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        // Profile
        Route::get('/profile/settings', [AuthController::class, 'showSettingsForm'])->name('profile.settings');

        // Checkout Flow
        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
        Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

        // Order Management
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    });
});
