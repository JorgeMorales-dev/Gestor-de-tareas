<?php

namespace App\Http\Controllers\Api;

use App\Models\Task;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;

class TaskController extends Controller
{
    /**
     * Listar todas las tareas
     * GET /api/tasks
     */
    public function index()
    {
        // Traemos todas las tareas, las más nuevas primero
        $tasks = Task::orderByDesc('id')->get();

        return response()->json($tasks, 200);
    }

    /**
     * Crear nueva tarea
     * POST /api/tasks
     */
    public function store(StoreTaskRequest $request)
    {
        // Solo datos validados
        $data = $request->validated();

        // Si no viene "completed", lo dejamos en false (pendiente)
        $data['completed'] = $data['completed'] ?? false;

        // Creamos la tarea en la base de datos
        $task = Task::create($data);

        return response()->json($task, 201);
    }

    /**
     * Actualizar
     * PUT /api/tasks/{id}
     */
    public function update(UpdateTaskRequest $request, $id)
    {
        // Buscamos la tarea o fallamos
        $task = Task::findOrFail($id);

        // Actualizamos los datos validados
        $task->update($request->validated());

        return response()->json($task, 200);
    }

    /**
     * Eliminar tarea
     * DELETE /api/tasks/{id}
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return response()->json([
            'message' => 'Tarea eliminada correctamente'
        ], 200);
    }
}
