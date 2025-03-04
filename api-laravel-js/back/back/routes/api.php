<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UserController;

Route::get('/users', [UserController::class, 'index']); // Obtener todos los usuarios
Route::post('/users', [UserController::class, 'store']); // Crear un nuevo usuario
Route::get('/users/{id}', [UserController::class, 'show']); // Obtener un solo usuario por ID
Route::put('/users/{id}', [UserController::class, 'update']); // Actualizar un usuario
Route::delete('/users/{id}', [UserController::class, 'destroy']); // Eliminar un usuario


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
