<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;


Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('register', function () {
    return redirect()->route('login');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
});
