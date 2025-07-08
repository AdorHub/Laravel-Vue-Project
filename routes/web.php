<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\EmailVerificationController;

Route::get('/', [ListingController::class, 'index'])->name('home');
Route::resource('listing', ListingController::class)->except('index');

Route::middleware('guest')->group(function () {
	//authentication
	Route::get('/register', [RegisterController::class, 'index'])->name('register');
	Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
	Route::get('/login', [LoginController::class, 'index'])->name('login');
	Route::post('/login', [LoginController::class, 'store'])->name('login.store');
	//reset password
	Route::get('/forgot-password', [ResetPasswordController::class, 'request'])->name('password.request');
	Route::post('/forgot-password', [ResetPasswordController::class, 'sendEmail'])->name('password.email');
	Route::get('/reset-password/{token}', [ResetPasswordController::class, 'resetForm'])->name('password.reset');
	Route::post('/reset-password', [ResetPasswordController::class, 'resetHandler'])->name('password.update');
});

Route::middleware('auth')->group(function () {
	//logout
	Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
	//email verification
	Route::get('/email/verify', [EmailVerificationController::class, 'notice'])->name('verification.notice');
	Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'handle'])->middleware('signed')->name('verification.verify');
	Route::post('/email/verification-notification', [EmailVerificationController::class, 'resend'])->middleware('throttle:6,1')->name('verification.send');
	//confirm password
	Route::get('/confirm-password', [ConfirmPasswordController::class, 'create'])->name('password.confirm');
	Route::post('/confirm-password', [ConfirmPasswordController::class, 'store'])->middleware('throttle:6,1');
});

Route::middleware('auth')->group(function () {
	//dashboard
	Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('verified')->name('dashboard');
	//profile
	Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
	Route::patch('/profile', [ProfileController::class, 'updateInfo'])->name('profile.info');
	Route::put('/profile', [ProfileController::class, 'updatePassword'])->name('profile.password');
	Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified', 'admin'])->controller(AdminController::class)->group(function () {
	Route::get('/admin', 'index')->name('admin.index');
	Route::get('/admin/users/{user}', 'show')->name('admin.user.show');
	Route::put('/admin/{user}/type', 'type')->name('admin.type');
	Route::put('/admin/listing/{listing}/approve', 'approve')->name('admin.approve');
});

