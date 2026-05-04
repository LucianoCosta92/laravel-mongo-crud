<?php

use App\Http\Controllers\Api\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\UserController;

Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::post('/users', [UserController::class, 'store'])->name('users.store');

Route::group(['middleware' => ['auth:sanctum']], function(){

    Route::post('/logout/{user}', [LoginController::class, 'logout'])->name('logout');

    Route::apiResource('tasks', TaskController::class);
    Route::apiResource('categories', CategoryController::class);

    Route::prefix('me')->name('users.')->group(function(){
        Route::get('/', [UserController::class, 'show'])->name('show');
        Route::put('/',    [UserController::class, 'update'])->name('update');
        Route::delete('/', [UserController::class, 'destroy'])->name('destroy');
    });

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
});


?>
