<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('register', function () {
    return redirect()->route('login');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::prefix('admin')->name('admin.')->middleware(['web', 'auth'])->group(function () {
    //dashboard
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    //master user
    Route::prefix('users')->name('users.')->group(function () {
        Route::post('apis', [UserController::class, 'apis'])->name('apis');
        Route::get('edit', [UserController::class, 'edit'])->name('edit');
        Route::post('update', [UserController::class, 'update'])->name('update');
        Route::delete('destroy', [UserController::class, 'destroy'])->name('destroy');
    });
    Route::resource('users', UserController::class)->only('index', 'store');
});
