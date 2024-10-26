<?php

use App\Http\Controllers\FrontController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\Front\ProgramController;
use App\Http\Controllers\Front\MediaController;
use App\Http\Controllers\Front\PostController;

use App\Http\Controllers\Admin\PostController as adminPostController;
use App\Http\Controllers\Admin\MediaController as adminMediaController;
use App\Http\Controllers\Admin\CategoryController as adminCategoryController;
use App\Http\Controllers\Admin\FeedbackController as adminFeedbackController;
use App\Http\Controllers\Admin\SettingController as adminSettingController;

Auth::routes();

Route::get('register', function () {
	return redirect()->route('login');
});

Route::name('frontend.')->group(function () {
	Route::get('/', [FrontController::class, 'index'])->name('index'); //homepage
	Route::get('/profile', [PostController::class, 'profile'])->name('profile');
	Route::get('/program', [ProgramController::class, 'index'])->name('program.index');
	Route::get('/program/{slug}', [ProgramController::class, 'show'])->name('program.show');
	Route::get('/news', [PostController::class, 'index'])->name('news.index');
	Route::get('/news/{slug}', [PostController::class, 'show'])->name('news.show');
	Route::get('/facility', [PostController::class, 'index_facility'])->name('facility.index');
	Route::get('/facility/{slug}', [PostController::class, 'show_facility'])->name('facility.show');
	Route::get('/images-gallery', [MediaController::class, 'index'])->name('images.index');
	Route::get('/images-gallery/{slug}', [MediaController::class, 'show_gallery'])->name('images.show');
});

Route::get('/home', [HomeController::class, 'index'])->name('home'); //login admin page

Route::prefix('admin')->name('admin.')->middleware(['web', 'auth'])->group(function () {
	//dashboard
	Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

	//PostController
	Route::prefix('post')->name('post.')->group(function () {
		Route::get('apis', [adminPostController::class, 'apis'])->name('apis');
		Route::get('postdraft', [adminPostController::class, 'post_draft'])->name('postdraft');
		Route::get('postall', [adminPostController::class, 'post_all'])->name('postall');
		Route::get('edit', [adminPostController::class, 'edit'])->name('edit');
		Route::get('media', [adminPostController::class, 'media'])->name('media');
		Route::post('update', [adminPostController::class, 'update'])->name('update');
		Route::delete('destroy', [adminPostController::class, 'destroy'])->name('destroy');
		Route::resource('post', adminPostController::class);
	});
	Route::resource('post', adminPostController::class)->only('index', 'store');

	//CategoryController
	Route::prefix('category')->name('category.')->group(function () {
		Route::get('apis', [adminCategoryController::class, 'apis'])->name('apis');
		Route::get('edit', [adminCategoryController::class, 'edit'])->name('edit');
		Route::post('update', [adminCategoryController::class, 'update'])->name('update');
		Route::delete('destroy', [adminCategoryController::class, 'destroy'])->name('destroy');
		Route::resource('category', adminCategoryController::class);
	});
	Route::resource('category', adminCategoryController::class)->only('index', 'store');

	//MediaController
	Route::prefix('gallery')->name('gallery.')->group(function () {
		Route::get('apis', [adminMediaController::class, 'apis'])->name('apis');
		Route::get('getVideo', [adminMediaController::class, 'getVideo'])->name('getVideo');
		Route::post('create', [adminMediaController::class, 'store'])->name('store');
		Route::get('edit', [adminMediaController::class, 'edit'])->name('edit');
		Route::get('media', [adminMediaController::class, 'media'])->name('media');
		Route::post('update', [adminMediaController::class, 'update'])->name('update');
		Route::delete('destroy', [adminMediaController::class, 'destroy'])->name('destroy');
	});
	Route::resource('gallery', adminMediaController::class)->only('index', 'store');

	//Feedback Controller
	Route::prefix('feedback')->name('feedback.')->group(function () {
		Route::get('consultation', [adminFeedbackController::class, 'consultation'])->name('consultation');
		Route::get('complaint', [adminFeedbackController::class, 'complaint'])->name('complaint');
		Route::get('apis', [adminFeedbackController::class, 'apis'])->name('apis');
		Route::get('edit', [adminFeedbackController::class, 'edit'])->name('edit');
		Route::get('getReply', [adminFeedbackController::class, 'getReply'])->name('getReply');
		Route::post('update', [adminFeedbackController::class, 'update'])->name('update');
		Route::delete('destroy', [adminFeedbackController::class, 'destroy'])->name('destroy');
		Route::resource('feedback', adminFeedbackController::class);
	});
	Route::resource('feedback', adminFeedbackController::class)->only('index', 'store');

	//Setting Page Controller
	Route::prefix('setting')->name('setting.')->group(function () {
		Route::get('apis', [adminSettingController::class, 'apis'])->name('apis');
		Route::get('edit', [adminSettingController::class, 'edit'])->name('edit');
		Route::get('media', [adminSettingController::class, 'media'])->name('media');
		Route::post('update', [adminSettingController::class, 'update'])->name('update');
		Route::delete('destroy', [adminSettingController::class, 'destroy'])->name('destroy');
		Route::resource('setting', adminSettingController::class);
	});
	Route::resource('setting', adminSettingController::class)->only('index', 'store');

	//Master Users
	Route::prefix('users')->name('users.')->group(function () {
		Route::post('apis', [UserController::class, 'apis'])->name('apis');
		Route::get('edit', [UserController::class, 'edit'])->name('edit');
		Route::post('update', [UserController::class, 'update'])->name('update');
		Route::delete('destroy', [UserController::class, 'destroy'])->name('destroy');
	});
	Route::resource('users', UserController::class)->only('index', 'store');
});
