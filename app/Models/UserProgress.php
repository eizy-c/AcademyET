<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Eloquent para el Seguimiento del Progreso de Alumnos por Lección.
 */
class UserProgress extends Model
{
    use HasFactory;

    protected $table = 'user_progress';

    protected $fillable = [
        'user_id',
        'lesson_id',
        'completed',
        'completed_at',
    ];

    protected $casts = [
        'completed' => 'boolean',
        'completed_at' => 'datetime',
    ];

    /**
     * Relación con el usuario propietario del avance.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con la lección correspondiente.
     */
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
