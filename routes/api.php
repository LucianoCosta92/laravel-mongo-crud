<?php

use App\Http\Controllers\Api\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;

// POST - http://127.0.0.1:8000/api/
Route::post('/', [LoginController::class, 'login'])->name('login');
/*
{
"email": "teste@email.com", "password": "123456"
}
*/

Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::apiResource('tasks', TaskController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('users', UserController::class);
    Route::post('/logout/{user}', [LoginController::class, 'logout']);
});




?>
