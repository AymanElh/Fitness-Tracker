<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function() {
    return view('admin.dashboard');
});

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
