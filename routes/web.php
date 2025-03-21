<?php

use App\Http\Controllers\Admin\RoleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function() {
    return view('admin.dashboard');
})->name('dashboard');

Route::get('/admin/users', function() {
    return view('admin.users.index');
})->name('admin.users');

Route::get('/admin/users/create', function() {
    return view('admin.users.create');
})->name('admin.users.create');

Route::get('/admin/meals', function() {
    return view('admin.users.index');
})->name('admin.meals.index');

Route::get('/admin/exercises', function() {
    return view('admin.exercises.index');
})->name('admin.exercises');

Route::get('/admin/exercises/create', function() {
    return view('/admin/exercises/create');
})->name('admin.exercises.create');

// Auth
Route::get('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('register', [\App\Http\Controllers\Auth\RegisterController::class, 'register']);

Route::get('/login', [\App\Http\Controllers\Auth\SessionController::class, 'showLoginForm'])->name('login');
Route::post('/login', [\App\Http\Controllers\Auth\SessionController::class, 'login']);

Route::get('/password/reset', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'showForgetPasswordForm'])->name('password.request');
Route::post('/password/email', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLink'])->name('password.email');

Route::get('/password/reset/{token}', [\App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [\App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');


Route::resource('/admin/roles', RoleController::class);
Route::get('/admin/permissions', function() {
    return view('admin.permissions.index');
});
//Route::get('/reset-password', function() {
//    return view('auth.reset-password');
//})->name('reset-password');
//
//Route::get('/forget-password', function() {
//    return view('auth.forget-password');
//})->name('forget-password');
