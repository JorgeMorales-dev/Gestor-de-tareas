<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TaskController;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| Rutas de la API
|--------------------------------------------------------------------------
|
*/

// Mensaje simple
Log::info('Rutas de tareas cargadas correctamente.');

// Rutas CRUD para tareas
Route::apiResource('tasks', TaskController::class)->only([
    'index',   // GET    /api/tasks
    'store',   // POST   /api/tasks
    'update',  // PUT    /api/tasks/{id}
    'destroy'  // DELETE /api/tasks/{id}
]);

// Ruta protegida
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


