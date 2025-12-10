<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\MerchantController;
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

    // --- Legal Pages ---
    Route::get('/terms-and-conditions', function () {
        return view('pages.legal.terms');
    })->name('legal.terms');
    Route::get('/privacy-policy', function () {
        return view('pages.legal.privacy');
    })->name('legal.privacy');

    // --- Currency & Location Management Routes ---
    Route::post('/change-currency', [CurrencyController::class, 'changeCurrency'])->name('currency.change');
    Route::post('/change-location', [LocationController::class, 'change'])->name('location.change');
    Route::get('/api/currency/current', [CurrencyController::class, 'getCurrentCurrency'])->name('currency.current');
    Route::get('/api/currency/available', [CurrencyController::class, 'getAvailableCurrencies'])->name('currency.available');
    Route::post('/api/currency/convert', [CurrencyController::class, 'convertPrice'])->name('currency.convert');

    // --- Demo Route ---
    Route::get('/currency-demo', fn() => view('example_usage'))->name('currency.demo');

    // --- Guest Routes (Only for unauthenticated users) ---
    Route::middleware('guest')->group(function () {
        Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
        Route::post('/register', [AuthController::class, 'register']);
        Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AuthController::class, 'login']);

        // Password Reset Routes
        Route::get('/forgot-password', [\App\Http\Controllers\Auth\PasswordResetLinkController::class, 'create'])->name('password.request');
        Route::post('/forgot-password', [\App\Http\Controllers\Auth\PasswordResetLinkController::class, 'store'])->name('password.email');
        Route::get('/reset-password/{token}', [\App\Http\Controllers\Auth\NewPasswordController::class, 'create'])->name('password.reset');
        Route::post('/reset-password', [\App\Http\Controllers\Auth\NewPasswordController::class, 'store'])->name('password.store');
    });

    // --- Cart Management (Available to both guests and authenticated users) ---
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::patch('/cart/update/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{cartItem}', [CartController::class, 'destroy'])->name('cart.destroy');

    // --- Authenticated Routes (Requires user to be logged in) ---
    Route::middleware('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        // --- User (Buyer) Specific Routes ---
        Route::prefix('user')->group(function () {
            // Profile
            Route::get('/settings', [AuthController::class, 'showSettingsForm'])->name('profile.settings');
            Route::put('/settings', [AuthController::class, 'updateProfile'])->name('profile.update');

            // Password Update
            Route::get('/settings/password', [\App\Http\Controllers\Auth\PasswordController::class, 'edit'])->name('password.edit');
            Route::put('/settings/password', [\App\Http\Controllers\Auth\PasswordController::class, 'update'])->name('password.update');

            // Checkout Flow
            Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
            Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
            Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

            // Orders
            Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        });

        // --- Redirect Logic for Legacy /admin ---
        Route::get('/admin', function () {
            if (auth()->user()->isAdmin()) {
                return redirect()->route('superadmin.merchants.index');
            }
            if (auth()->user()->isMerchant()) {
                // Todo: Redirect to merchant.dashboard when ready, for now products
                return redirect()->route('merchant.dashboard');
            }
            return redirect('/');
        });

        // --- SuperAdmin (Platform) Routes ---
        Route::prefix('superadmin')->name('superadmin.')->middleware('superadmin')->group(function () {
            // Will create MerchantController here next
            Route::get('/merchants', [\App\Http\Controllers\SuperAdmin\MerchantController::class, 'index'])->name('merchants.index');
            Route::post('/merchants/{user}/approve', [\App\Http\Controllers\SuperAdmin\MerchantController::class, 'approve'])->name('merchants.approve');
            Route::post('/merchants/{user}/reject', [\App\Http\Controllers\SuperAdmin\MerchantController::class, 'reject'])->name('merchants.reject');
        });

        // --- Merchant (Tenant) Routes ---
        Route::prefix('merchant')->name('merchant.')->middleware('merchant')->group(function () {
            // Dashboard
            Route::get('/dashboard', [\App\Http\Controllers\Merchant\DashboardController::class, 'index'])->name('dashboard');

            // Product Management
            Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
            Route::resource('branches', \App\Http\Controllers\Admin\BranchController::class);
            Route::resource('halal-certifications', \App\Http\Controllers\Admin\HalalCertificationController::class);
        });

        // --- Legacy/Deprecated Admin Routes (Kept temporarily or aliases) ---
        Route::prefix('admin')->name('admin.')->middleware(\App\Http\Middleware\AdminMiddleware::class)->group(function () {
            // Deprecated: These should now be accessed via /merchant or /superadmin
            // Keeping temporarily if needed, but the plan is to fully cut over.
            // For now, let's point aliases to the new controllers if needed 
            // OR simply rely on the domain separation above. 
            // Given strict instruction, we rely on above.
        });
    });
});
