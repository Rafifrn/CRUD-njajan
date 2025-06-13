<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\MakananController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\Admin\MinumanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenusController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Models\Makanan;
use App\Models\Minuman;

Route::get('/', function () {
    return view('landing');
});

// route::get('post', function () {
//     return view('post');
// });

route::get('/about', function () {
    return view('about');
});

route::get('/menu', function () {
    return view('menu');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::view('/', 'landing')->middleware(['auth', 'verified'])->name('landing');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// Route::middleware(['auth', 'IsAdmin'])->group(function () {
//     Route::get('/admin/home', [LoginController::class, 'index']);
// });
Route::get('/admin/home', [App\Http\Controllers\HomeController::class, 'index'])
    ->middleware(['auth', 'admin'])
    ->name('home');

Route::get('/landing', function () {
    return view('landing');
})->middleware(['auth'])->name('landing');

Route::get('/pesan/{kategori}/{id}', [MenuController::class, 'create'])->name('pesan');

Route::get('/menu', function () {
    $makanans = Makanan::all();
    $minumans = Minuman::all();

    // Ambil semua region dari makanan & minuman
    $regions = collect($makanans)
        ->merge($minumans)
        ->pluck('region')
        ->filter()
        ->unique()
        ->sort()
        ->values();

    return view('menu', compact('makanans', 'minumans', 'regions'));
});

Route::get('/item/{kategori}/{id}', [MenuController::class, 'getItemData']);


Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/makanan', [MakananController::class, 'index'])->name('admin.makanan.index');
    Route::get('/makanan/create', [MakananController::class, 'create'])->name('admin.makanan.create'); // ← ini penting
    Route::post('/makanan', [MakananController::class, 'store'])->name('admin.makanan.store');
    Route::get('/makanan/{id}/edit', [MakananController::class, 'edit'])->name('admin.makanan.edit');
    Route::put('/makanan/{id}', [MakananController::class, 'update'])->name('admin.makanan.update');
    Route::delete('/makanan/{id}', [MakananController::class, 'destroy'])->name('admin.makanan.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/minuman', [MinumanController::class, 'index'])->name('admin.minuman.index');
    Route::get('/minuman/create', [MinumanController::class, 'create'])->name('admin.minuman.create');
    Route::post('/minuman', [MinumanController::class, 'store'])->name('admin.minuman.store');
    Route::get('/minuman/{id}/edit', [MinumanController::class, 'edit'])->name('admin.minuman.edit');
    Route::put('/minuman/{id}', [MinumanController::class, 'update'])->name('admin.minuman.update');
    Route::delete('/minuman/{id}', [MinumanController::class, 'destroy'])->name('admin.minuman.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/pages', [OrderController::class, 'index'])->name('admin.pages');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show'); // ⬅️ INI
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    
});   

Route::get('/home', [DashboardController::class, 'index'])
    ->middleware(['auth', 'admin'])
    ->name('admin.home');

Route::get('/admin/menus', [MenusController::class, 'index'])->name('admin.menus.index')->middleware(['auth', 'admin']);

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Tampilkan form
    Route::get('/usersCreate', [UserController::class, 'create'])->name('usersCreate');

    // Simpan user baru (⬅️ INI YANG PENTING)
    Route::post('/usersStore', [UserController::class, 'store'])->name('usersStore');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/usersIndex', [UserController::class, 'index'])->name('usersIndex');
});