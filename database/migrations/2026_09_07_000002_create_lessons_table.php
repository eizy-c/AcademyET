<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta la migración para crear la tabla 'lessons'.
     * Almacena las lecciones del curso, restricciones de taller, comandos y modelos 3D asociados.
     */
    public function up(): void
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->constrained('modules')->onDelete('cascade'); // Relación con el módulo padre
            $table->string('title'); // Título de la lección técnica
            $table->string('slug')->unique(); // Slug para enlaces amigables
            $table->integer('order')->default(1); // Número correlativo de lección
            $table->text('summary')->nullable(); // Resumen didáctico introductorio
            $table->text('content')->nullable(); // Explicación profunda y procedimiento técnico
            $table->json('workshop_rules')->nullable(); // Reglas geométricas de taller (espesores, holguras, radios)
            $table->json('shortcuts')->nullable(); // Lista de atajos de teclado asociados (ej: Q=Girar, P=Extruir)
            $table->string('model_3d_path')->nullable(); // Ruta del archivo GLB 3D para el visor interativo
            $table->timestamps();
        });
    }

    /**
     * Rebobina la migración borrando la tabla de lecciones.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
