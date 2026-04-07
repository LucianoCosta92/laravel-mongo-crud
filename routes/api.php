<?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\CategoryController;
    use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;

    Route::apiResource('tasks', TaskController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('users', UserController::class);


?>
