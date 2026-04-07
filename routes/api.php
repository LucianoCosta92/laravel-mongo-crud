<?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\CategoryController;
    use App\Http\Controllers\TaskController;

    Route::apiResource('tasks', TaskController::class);
    Route::apiResource('categories', CategoryController::class);


?>
