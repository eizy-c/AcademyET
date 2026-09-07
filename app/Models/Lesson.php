<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Eloquent para representar las Lecciones del Curso.
 * Contiene metadatos técnicos de taller, atajos de teclado y modelos 3D.
 */
class Lesson extends Model
{
    use HasFactory;

    // Campos asignables masivamente
    protected $fillable = [
        'module_id',
        'title',
        'slug',
        'order',
        'summary',
        'content',
        'workshop_rules',
        'shortcuts',
        'model_3d_path',
    ];

    // Casteo automático de estructuras JSON a Arrays de PHP
    protected $casts = [
        'workshop_rules' => 'array',
        'shortcuts' => 'array',
    ];

    /**
     * Relación inversa de pertenencia con el módulo padre.
     */
    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    /**
     * Relación con el registro de progreso de los usuarios.
     */
    public function userProgress()
    {
        return $this->hasMany(UserProgress::class);
    }

    /**
     * Evalúa si una lección específica está completada para un usuario dado.
     *
     * @param int $userId ID del usuario
     * @return bool Estado de finalización
     */
    public function isCompletedBy($userId)
    {
        if (!$userId) {
            return false;
        }

        return $this->userProgress()
            ->where('user_id', $userId)
            ->where('completed', true)
            ->exists();
    }
}
