<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\MakananController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\Admin\MinumanController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\XenditWebhookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Models\Makanan;
use App\Models\Minuman;
use App\Models\Tenant;

/*
|--------------------------------------------------------------------------
| Halaman publik
|--------------------------------------------------------------------------
*/

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Auth::routes(['login' => false]);

/*
|--------------------------------------------------------------------------
| Webhook Xendit (tanpa CSRF, lihat bootstrap/app.php)
|--------------------------------------------------------------------------
*/

Route::post('/xendit/webhook', XenditWebhookController::class)->name('xendit.webhook');

/*
|--------------------------------------------------------------------------
| Halaman user (pelanggan) — perlu login
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    // HOME: daftar tenant UMKM
    Route::get('/home', function () {
        $tenants = Tenant::where('is_active', true)->withCount(['makanans', 'minumen'])->get();
        return view('user.home', compact('tenants'));
    })->name('home');

    // ORDER: etalase semua makanan & minuman + filter
    Route::get('/order', function () {
        $makanans = Makanan::with('tenant')->where('is_available', true)->get();
        $minumans = Minuman::with('tenant')->where('is_available', true)->get();
        $tenants = Tenant::where('is_active', true)->get();
        return view('user.order', compact('makanans', 'minumans', 'tenants'));
    })->name('order');

    // PESANAN: status order user yang login
    Route::get('/pesanan', [OrderController::class, 'myOrders'])->name('pesanan');

    // HISTORY: histori semua order user
    Route::get('/history', [OrderController::class, 'history'])->name('history');

    // Struk digital
    Route::get('/struk/{groupCode}', [PaymentController::class, 'struk'])->name('struk');

    // Checkout multi-tenant (AJAX)
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout');

    // Detail item (dipakai menu order)
    Route::get('/item/{kategori}/{id}', [MenuController::class, 'getItemData']);
});

/*
|--------------------------------------------------------------------------
| Redirect setelah login berdasarkan role (fallback)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    if (Auth::check()) {
        return match (Auth::user()->role) {
            'admin' => redirect('/admin/dashboard'),
            'tenant' => redirect('/tenant/orders'),
            default => redirect('/home'),
        };
    }
    return redirect('/login');
});

Route::get('/landing', function () {
    return redirect('/home');
})->name('landing');

/*
|--------------------------------------------------------------------------
| Halaman tenant (kasir) — Livewire, perlu role tenant
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'tenant'])->prefix('tenant')->group(function () {
    Route::view('/', 'tenant.orders')->name('tenant.orders');
    Route::view('/orders', 'tenant.orders')->name('tenant.orders.page');
    Route::view('/products', 'tenant.products')->name('tenant.products');
});

/*
|--------------------------------------------------------------------------
| Halaman admin — Livewire, perlu role admin
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::view('/dashboard', 'admin.dashboard')->name('admin.dashboard');
    Route::view('/tenants', 'admin.tenants')->name('admin.tenants');
    Route::view('/orders', 'admin.orders')->name('admin.orders');
    Route::view('/users', 'admin.users')->name('admin.users');

    // CRUD makanan & minuman (legacy blade, tetap berfungsi)
    Route::get('/makanan', [MakananController::class, 'index'])->name('admin.makanan.index');
    Route::get('/makanan/create', [MakananController::class, 'create'])->name('admin.makanan.create');
    Route::post('/makanan', [MakananController::class, 'store'])->name('admin.makanan.store');
    Route::get('/makanan/{id}/edit', [MakananController::class, 'edit'])->name('admin.makanan.edit');
    Route::put('/makanan/{id}', [MakananController::class, 'update'])->name('admin.makanan.update');
    Route::delete('/makanan/{id}', [MakananController::class, 'destroy'])->name('admin.makanan.destroy');

    Route::get('/minuman', [MinumanController::class, 'index'])->name('admin.minuman.index');
    Route::get('/minuman/create', [MinumanController::class, 'create'])->name('admin.minuman.create');
    Route::post('/minuman', [MinumanController::class, 'store'])->name('admin.minuman.store');
    Route::get('/minuman/{id}/edit', [MinumanController::class, 'edit'])->name('admin.minuman.edit');
    Route::put('/minuman/{id}', [MinumanController::class, 'update'])->name('admin.minuman.update');
    Route::delete('/minuman/{id}', [MinumanController::class, 'destroy'])->name('admin.minuman.destroy');

    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('admin.orders.show');
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
});

/*
|--------------------------------------------------------------------------
| Pembayaran (redirect dari Xendit)
|--------------------------------------------------------------------------
*/

Route::get('/payment/{groupCode}/success', [CheckoutController::class, 'success'])
    ->middleware('auth')
    ->name('payment.success');
Route::get('/payment/{groupCode}/failed', [CheckoutController::class, 'failed'])
    ->middleware('auth')
    ->name('payment.failed');
