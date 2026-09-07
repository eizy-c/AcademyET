<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Eloquent para representar los Módulos del Curso.
 * Agrupa temas didácticos (Fundamentos, Despieces, Planos, Accesorios).
 */
class Module extends Model
{
    use HasFactory;

    // Campos asignables masivamente
    protected $fillable = [
        'title',
        'slug',
        'order',
        'description',
    ];

    /**
     * Relación de uno a muchos con las lecciones del módulo.
     * Retorna la colección de lecciones ordenadas cronológicamente.
     */
    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('order', 'asc');
    }
}
