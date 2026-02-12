<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
   
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas para crear una nueva tarea
     */
    public function rules(): array
    {
        return [
            // El título es obligatorio y debe tener mínimo 3 caracteres
            'title' => 'required|string|min:3|max:255',

            // La descripción es opcional
            'description' => 'nullable|string',

            // completed puede venir o no, pero si viene debe ser true o false
            'completed' => 'nullable|boolean',
        ];
    }
}
