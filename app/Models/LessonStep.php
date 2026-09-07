<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Eloquent para Representar un Paso Didáctico / Cuestionario de Lección.
 */
class LessonStep extends Model
{
    use HasFactory;

    protected $fillable = [
        'lesson_id',
        'step_number',
        'title',
        'type',
        'content',
        'question',
        'options',
        'correct_answer',
        'explanation',
        'calc_preset',
    ];

    protected $casts = [
        'options' => 'array',
        'calc_preset' => 'array',
    ];

    /**
     * Relación de pertenencia con la lección padre.
     */
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    /**
     * Relación con los registros de progreso de los estudiantes para este paso.
     */
    public function userProgress()
    {
        return $this->hasMany(UserStepProgress::class);
    }

    /**
     * Evalúa si un paso ha sido completado por un usuario específico.
     */
    public function isCompletedBy($userId)
    {
        if (!$userId) return false;

        return $this->userProgress()
            ->where('user_id', $userId)
            ->where('completed', true)
            ->exists();
    }
}
