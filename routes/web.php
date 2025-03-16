<?php

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


Route::get('/reset-password', function() {
    return view('auth.reset-password');
})->name('reset-password');

Route::get('/forget-password', function() {
    return view('auth.forget-password');
})->name('forget-password');
