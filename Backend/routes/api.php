<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\InterfaceAdapters\Controllers\TaskController;

// Obtiene todas las tareas
Route::get('/tasks', [TaskController::class, 'index']);
// Crea una nueva tarea
Route::post('/tasks', [TaskController::class, 'store']);
// Obtiene una tarea por ID
Route::get('/tasks/{id}', [TaskController::class, 'show']);
// Actualiza una tarea existente
Route::put('/tasks/{id}', [TaskController::class, 'update']);
// Elimina una tarea
Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);
// Cuenta el total de tareas
Route::get('/tasks/count', [TaskController::class, 'count']);
