<?php

use App\Http\Controllers\FrontController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Front\ProgramController;
use App\Http\Controllers\Front\PostController;

use App\Http\Controllers\Admin\PostController as adminPostController;

Auth::routes();

Route::get('register', function () {
	return redirect()->route('login');
});

Route::name('frontend.')->group(function () {
	Route::get('/', [FrontController::class, 'index'])->name('index');
	Route::get('/program', [ProgramController::class, 'index'])->name('program.index');
	Route::get('/program/{slug}', [ProgramController::class, 'show'])->name('program.show');
	Route::get('/profile', [FrontController::class, 'profile'])->name('profile');
	Route::get('/berita', [PostController::class, 'index'])->name('post.index');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::prefix('admin')->name('admin.')->middleware(['web', 'auth'])->group(function () {
	//dashboard
	Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

	//ContentController
	Route::prefix('post')->name('post.')->group(function () {
		Route::get('apis', [adminPostController::class, 'apis'])->name('apis');
		Route::get('post_draft', [adminPostController::class, 'post_draft'])->name('post_draft');
		Route::get('post_all', [adminPostController::class, 'post_all'])->name('post_all');
		Route::get('edit', [adminPostController::class, 'edit'])->name('edit');
		Route::post('update', [adminPostController::class, 'update'])->name('update');
		Route::delete('destroy', [adminPostController::class, 'destroy'])->name('destroy');
		Route::resource('post', adminPostController::class);
	});
	Route::resource('post', adminPostController::class)->only('index', 'store');

	//master user
	Route::prefix('users')->name('users.')->group(function () {
		Route::post('apis', [UserController::class, 'apis'])->name('apis');
		Route::get('edit', [UserController::class, 'edit'])->name('edit');
		Route::post('update', [UserController::class, 'update'])->name('update');
		Route::delete('destroy', [UserController::class, 'destroy'])->name('destroy');
	});
	Route::resource('users', UserController::class)->only('index', 'store');
});
