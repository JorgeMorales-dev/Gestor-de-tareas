<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        // Borramos todas las tareas antes de crear las de ejemplo
        Task::truncate();

        // Tareas de ejemplo para probar la aplicación
        Task::create([
            'title' => 'Aprender Vue 3',
            'description' => 'Repasar Composition API',
            'completed' => false,
        ]);

        Task::create([
            'title' => 'Conectar con Laravel',
            'description' => 'Probar GET, POST, PUT y DELETE',
            'completed' => false,
        ]);

        Task::create([
            'title' => 'Preparar prueba técnica',
            'description' => 'Validaciones y diseño final',
            'completed' => true,
        ]);
    }
}
