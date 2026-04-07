<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

/* resource: método que registra automaticamente um conjunto completo
de rotas RESTful (CRUD) para um controlador específico em apenas uma linha.
Ele cria rotas para listar, criar, editar, atualizar e excluir recursos,
mapeando URLs (ex: /fotos) para métodos do controlador (index, create, store, etc.) */
Route::resource('posts', PostController::class);
