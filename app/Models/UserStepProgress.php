<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Eloquent para el Progreso Paso a Paso de Alumnos por Cuestionario.
 */
class UserStepProgress extends Model
{
    use HasFactory;

    protected $table = 'user_step_progress';

    protected $fillable = [
        'user_id',
        'lesson_step_id',
        'completed',
        'user_answer',
        'completed_at',
    ];

    protected $casts = [
        'completed' => 'boolean',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lessonStep()
    {
        return $this->belongsTo(LessonStep::class);
    }
}
