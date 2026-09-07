<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta la migración para crear la tabla 'lesson_steps'.
     * Estructura las lecciones en secuencias didácticas paso a paso (teoría corta + cuestionarios/desafíos).
     */
    public function up(): void
    {
        Schema::create('lesson_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained('lessons')->onDelete('cascade'); // Lección a la que pertenece el paso
            $table->integer('step_number')->default(1); // Número correlativo del paso dentro de la lección
            $table->string('title'); // Título descriptivo de la etapa (ej: "Paso 1: Definición de Ejes X, Y, Z")
            $table->enum('type', ['theory', 'quiz', 'shortcut_challenge', 'interactive_calc'])->default('theory'); // Tipo de paso
            $table->text('content')->nullable(); // Texto didáctico explicativo
            $table->string('question')->nullable(); // Pregunta del cuestionario o consigna del desafío
            $table->json('options')->nullable(); // Opciones de respuesta para quizzes (JSON array)
            $table->string('correct_answer')->nullable(); // Respuesta correcta esperada
            $table->text('explanation')->nullable(); // Retroalimentación pedagógica al responder
            $table->json('calc_preset')->nullable(); // Datos preconfigurados para prácticas con calculadoras
            $table->timestamps();
        });
    }

    /**
     * Revierte la migración borrando la tabla de pasos de lección.
     */
    public function down(): void
    {
        Schema::dropIfExists('lesson_steps');
    }
};
