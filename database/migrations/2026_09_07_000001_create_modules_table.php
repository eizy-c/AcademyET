<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta la migración para crear la tabla 'modules'.
     * Esta tabla agrupa las lecciones en módulos didácticos de diseño y manufactura 4x4.
     */
    public function up(): void
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Nombre o título del módulo (ej: Módulo 1: Fundamentos de SketchUp)
            $table->string('slug')->unique(); // Identificador único para rutas URL
            $table->integer('order')->default(1); // Orden secuencial didáctico
            $table->text('description')->nullable(); // Explicación de los temas cubiertos en el módulo
            $table->timestamps();
        });
    }

    /**
     * Rebobina la migración borrando la tabla de módulos.
     */
    public function down(): void
    {
        Schema::dropIfExists('modules');
    }
};
