<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\TaskController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login',           [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',          [AuthController::class, 'login']);
    Route::get('/register',        [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',       [AuthController::class, 'register']);
});


Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Tasks
    Route::resource('tasks', TaskController::class)->except(['show']);
    Route::patch('tasks/{id}/complete', [TaskController::class, 'complete'])->name('tasks.complete');

    // Categories
    Route::resource('categories', CategoryController::class)->except(['show']);

});
