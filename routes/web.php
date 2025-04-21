<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExerciseController;
use App\Http\Controllers\Admin\FoodController;
use App\Http\Controllers\Admin\MealController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\FrontOffice\NutritionPlanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('frontoffice.pages.home');
});

Route::get('/exercises', [\App\Http\Controllers\FrontOffice\ExerciseController::class, 'index'])->name('exercises.index');
Route::get('/exercises/{exercise}', [\App\Http\Controllers\FrontOffice\ExerciseController::class, 'show'])->name('exercises.show');

Route::get('/meals', [\App\Http\Controllers\FrontOffice\MealsController::class, 'index'])->name('meals.index');
Route::get('/meals/{meal}', [\App\Http\Controllers\FrontOffice\MealsController::class, 'show'])->name('meals.show');

Route::get('/foods', [\App\Http\Controllers\FrontOffice\FoodsController::class, 'index'])->name('foods.index');
Route::get('/foods/{food}', [\App\Http\Controllers\FrontOffice\FoodsController::class, 'show'])->name('foods.show');

Route::get('/dashboard', function() {
    return view('admin.dashboard');
})->name('dashboard');

Route::get('/admin/users', function() {
    return view('admin.users.index');
})->name('admin.users.index');

Route::get('/admin/users/create', function() {
    return view('admin.users.create');
})->name('admin.users.create');


//Route::get('/admin/exercises', function() {
//    return view('admin.exercises.index');
//})->name('admin.exercises');

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


Route::middleware('auth')->group(function() {
    Route::prefix('/admin/foods')->name('admin.foods.')->group(function() {
        Route::get('/', function() {
            return view('admin.foods.index');
        })->name('index');
        Route::get('/{food}', [FoodController::class, 'show'])->name('show');
    });

    Route::prefix('/admin')->name('admin.')->group(function() {
        // Meal routes
        Route::get('/meals', [MealController::class, 'index'])->name('meals.index');
        Route::post('/meals/store', [MealController::class, 'store'])->name('meals.store');
        Route::get('/meals/stats/refresh', [MealController::class, 'getStats'])->name('meals.stats.refresh');
        Route::get('/meals/search-foods', [MealController::class, 'searchFoods'])->name('meals.search-foods');
        Route::get('/meals/{meal}', [MealController::class, 'show'])->name('meals.show');
        Route::put('/meals/{meal}', [MealController::class, 'update'])->name('meals.update');
        Route::delete('/meals/{meal}', [MealController::class, 'destroy'])->name('meals.destroy');
    });

    Route::middleware('role:admin')->group(function() {
        //Route::resource('/admin/roles', RoleController::class);
        Route::get('/admin/roles', [RoleController::class, 'index'])->name('roles.index');
        Route::get('/admin/roles/{role}', [RoleController::class, 'show'])->name('roles.show');
        Route::post('/admin/roles', [RoleController::class, 'store'])->name('roles.store');
        Route::get('/admin/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
        Route::put('/admin/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
        Route::delete('/admin/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
        Route::resource('/admin/permissions', PermissionController::class);

    });

    Route::middleware('role:admin')->prefix('/admin')->name('admin.')->group(function() {
        Route::resource('/exercises', ExerciseController::class);
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Exercise Plans routes
    Route::get('/exercise-plans', [App\Http\Controllers\FrontOffice\ExercisePlanController::class, 'index'])->name('exercise-plans.index');
    Route::get('/exercise-plans/create', [App\Http\Controllers\FrontOffice\ExercisePlanController::class, 'create'])->name('exercise-plans.create');
    Route::post('/exercise-plans', [App\Http\Controllers\FrontOffice\ExercisePlanController::class, 'store'])->name('exercise-plans.store');
    Route::get('/exercise-plans/{plan}', [App\Http\Controllers\FrontOffice\ExercisePlanController::class, 'show'])->name('exercise-plans.show');
    Route::get('/exercise-plans/{plan}/edit', [App\Http\Controllers\FrontOffice\ExercisePlanController::class, 'edit'])->name('exercise-plans.edit');
    Route::put('/exercise-plans/{plan}', [App\Http\Controllers\FrontOffice\ExercisePlanController::class, 'update'])->name('exercise-plans.update');
    Route::delete('/exercise-plans/{plan}', [App\Http\Controllers\FrontOffice\ExercisePlanController::class, 'destroy'])->name('exercise-plans.destroy');


    Route::post('/exercise-plans/{plan}/days', [App\Http\Controllers\FrontOffice\ExercisePlanController::class, 'addDay'])->name('exercise-plans.days.store');
    Route::put('/exercise-plan-days/{day}', [App\Http\Controllers\FrontOffice\ExercisePlanController::class, 'updateDay'])->name('exercise-plans.days.update');
    Route::delete('/exercise-plan-days/{day}', [App\Http\Controllers\FrontOffice\ExercisePlanController::class, 'deleteDay'])->name('exercise-plans.days.destroy');


    Route::post('/exercise-plan-days/{day}/exercises', [App\Http\Controllers\FrontOffice\ExercisePlanController::class, 'addExercise'])->name('exercise-plans.exercises.store');
    Route::put('/exercise-plan-items/{item}', [App\Http\Controllers\FrontOffice\ExercisePlanController::class, 'updateExercise'])->name('exercise-plans.exercises.update');
    Route::delete('/exercise-plan-items/{item}', [App\Http\Controllers\FrontOffice\ExercisePlanController::class, 'deleteExercise'])->name('exercise-plans.exercises.destroy');

    // Nutrition plans routes
    Route::resource('nutrition-plans', NutritionPlanController::class);
});


Route::get('/admin/user', function () {
    return "Users Page";
})->name('users.index');

Route::get('/admin/user/create', function() {
    return "create user";
})->name('users.create');

Route::get('/admin/users/{user}', function () {
    return "users show";
})->name('users.show');
//Route::get('/reset-password', function() {
//    return view('auth.reset-password');
//})->name('reset-password');
//
//Route::get('/forget-password', function() {
//    return view('auth.forget-password');
//})->name('forget-password');


//Route::get('/foods', [FoodController::class, 'index'])->name('food-items.index');
//Route::get('/food-items/search', [FoodController::class, 'search'])->name('food-items.search');
//Route::post('/food-items', [FoodController::class, 'store'])->name('food-items.store');




// api routes
Route::get('/api/foods', [FoodController::class, 'index']);
Route::post('/api/foods', [FoodController::class, 'store']);
Route::get('/api/foods/{id}', [FoodController::class, 'getFoodData']);
Route::post('/api/foods/{id}', [FoodController::class, 'update']);
Route::delete('/api/foods/{id}', [FoodController::class, 'destroy']);
