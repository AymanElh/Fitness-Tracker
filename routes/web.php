<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExerciseController;
use App\Http\Controllers\Admin\FoodController;
use App\Http\Controllers\Admin\MealController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SessionController;
use App\Http\Controllers\FrontOffice\NutritionPlanController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\FrontOffice\HomeController::class, 'index'])->name('home');

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);

    Route::get('/login', [SessionController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [SessionController::class, 'login']);


    Route::get('/password/reset', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('password.request');
    Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');

    Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [SessionController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('role:admin');

    Route::middleware('role:admin')->prefix('/admin')->name('admin.')->group(function () {
        // Foods routes
        Route::get('/foods', function () {
            return view('admin.foods.index');
        })->name('foods.index');
        Route::get('/foods/{food}', [FoodController::class, 'show'])->name('foods.show');

        // Meals routes
        Route::get('/meals', [MealController::class, 'index'])->name('meals.index');
        Route::post('/meals/store', [MealController::class, 'store'])->name('meals.store');
        Route::get('/meals/stats/refresh', [MealController::class, 'getStats'])->name('meals.stats.refresh');
        Route::get('/meals/search-foods', [MealController::class, 'searchFoods'])->name('meals.search-foods');
        Route::get('/meals/{meal}', [MealController::class, 'show'])->name('meals.show');
        Route::put('/meals/{meal}', [MealController::class, 'update'])->name('meals.update');
        Route::delete('/meals/{meal}', [MealController::class, 'destroy'])->name('meals.destroy');

        // Roles routes
        Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
        Route::get('/roles/{role}', [RoleController::class, 'show'])->name('roles.show');
        Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
        Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
        Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
        Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');

        // Permission routes
        Route::resource('/permissions', PermissionController::class);

        // Exercise routes
        Route::resource('/exercises', ExerciseController::class);

        // Users route
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::patch('/users/{user}/ban', [UserController::class, 'ban'])->name('users.ban');
        Route::patch('/users/{user}/reinstate', [UserController::class, 'reinstate'])->name('users.reinstate');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

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

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/password', [ProfileController::class, 'editPassword'])->name('profile.password.edit');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])->name('profile.photo.delete');
});


// Front office pages
Route::get('/exercises', [\App\Http\Controllers\FrontOffice\ExerciseController::class, 'index'])->name('exercises.index');
Route::get('/exercises/{exercise}', [\App\Http\Controllers\FrontOffice\ExerciseController::class, 'show'])->name('exercises.show');

Route::get('/meals', [\App\Http\Controllers\FrontOffice\MealsController::class, 'index'])->name('meals.index');
Route::get('/meals/{meal}', [\App\Http\Controllers\FrontOffice\MealsController::class, 'show'])->name('meals.show');

Route::get('/foods', [\App\Http\Controllers\FrontOffice\FoodsController::class, 'index'])->name('foods.index');
Route::get('/foods/{food}', [\App\Http\Controllers\FrontOffice\FoodsController::class, 'show'])->name('foods.show');




// api routes
Route::get('/api/foods', [FoodController::class, 'index']);
Route::post('/api/foods', [FoodController::class, 'store']);
Route::get('/api/foods/{id}', [FoodController::class, 'getFoodData']);
Route::post('/api/foods/{id}', [FoodController::class, 'update']);
Route::delete('/api/foods/{id}', [FoodController::class, 'destroy']);
