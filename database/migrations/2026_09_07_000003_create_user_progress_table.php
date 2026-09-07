<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta la migración para crear la tabla 'user_progress'.
     * Mantiene el registro de las lecciones completadas por cada estudiante registrado.
     */
    public function up(): void
    {
        Schema::create('user_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Identificador del estudiante
            $table->foreignId('lesson_id')->constrained('lessons')->onDelete('cascade'); // Lección evaluada o completada
            $table->boolean('completed')->default(false); // Estado de finalización
            $table->timestamp('completed_at')->nullable(); // Marca de tiempo del cumplimiento
            $table->timestamps();

            // Garantiza que un usuario solo tenga un registro único por lección
            $table->unique(['user_id', 'lesson_id']);
        });
    }

    /**
     * Rebobina la migración borrando la tabla de progreso de usuario.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_progress');
    }
};
