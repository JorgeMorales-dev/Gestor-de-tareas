<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta la migración (crea la tabla)
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {

            $table->id(); // ID automático

            $table->string('title'); // Título de la tarea

            $table->text('description')->nullable(); // Descripción (opcional)

            $table->boolean('completed')->default(false);
            // false = pendiente, true = completada

            $table->timestamps(); // created_at y updated_at automáticos
        });
    }

    /**
     * Revierte la migración (borra la tabla)
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
