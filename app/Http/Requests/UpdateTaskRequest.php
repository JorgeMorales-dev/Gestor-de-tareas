<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Permite que cualquier usuario haga la petición.
     * (No estamos usando autenticación en esta prueba)
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación para actualizar una tarea
     */
    public function rules(): array
    {
        return [
            // El título es opcional, pero si viene debe tener mínimo 3 letras
            'title' => 'sometimes|required|string|min:3|max:255',

            // La descripción es opcional
            'description' => 'sometimes|nullable|string',

            // completed debe ser true o false si se envía
            'completed' => 'sometimes|required|boolean',
        ];
    }
}
