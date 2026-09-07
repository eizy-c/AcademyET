<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta la migración para crear la tabla 'user_step_progress'.
     * Mantiene el registro de pasos y cuestionarios aprobados por cada alumno.
     */
    public function up(): void
    {
        Schema::create('user_step_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Estudiante
            $table->foreignId('lesson_step_id')->constrained('lesson_steps')->onDelete('cascade'); // Paso de lección evaluado
            $table->boolean('completed')->default(false); // Estado de cumplimiento
            $table->string('user_answer')->nullable(); // Respuesta dada por el alumno
            $table->timestamp('completed_at')->nullable(); // Marca de tiempo
            $table->timestamps();

            $table->unique(['user_id', 'lesson_step_id']);
        });
    }

    /**
     * Revierte la migración borrando la tabla.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_step_progress');
    }
};
