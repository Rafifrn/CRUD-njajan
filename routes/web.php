<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;


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

use App\Http\Controllers\AdminController;

// Route::middleware(['auth', 'IsAdmin'])->group(function () {
//     Route::get('/admin/home', [LoginController::class, 'index']);
// });
Route::get('/admin/home', [App\Http\Controllers\HomeController::class, 'index'])
    ->middleware(['auth', 'isadmin'])
    ->name('home');

Route::get('/landing', function () {
    return view('landing');
})->middleware(['auth'])->name('landing');

