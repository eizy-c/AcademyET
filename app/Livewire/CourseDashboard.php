<?php

namespace App\Livewire;

use App\Models\Module;
use App\Models\Lesson;
use App\Models\UserProgress;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

/**
 * Componente Livewire para el Dashboard Principal del Curso.
 * Gestiona la navegación entre módulos, cálculo de porcentaje de avance y selección de lecciones.
 */
class CourseDashboard extends Component
{
    // ID de la lección seleccionada actualmente
    public $activeLessonId = null;

    // Pestaña o herramienta activa en la caja de herramientas ('leccion', 'calculadora_doblez', 'validador_u', 'tornilleria', 'visor_3d')
    public $activeTab = 'leccion';

    /**
     * Ciclo de vida inicial del componente.
     */
    public function mount($lessonSlug = null)
    {
        if ($lessonSlug) {
            $lesson = Lesson::where('slug', $lessonSlug)->first();
            if ($lesson) {
                $this->activeLessonId = $lesson->id;
            }
        }

        // Si no hay lección activa seleccionada, cargamos la primera lección por defecto
        if (!$this->activeLessonId) {
            $firstLesson = Lesson::orderBy('order', 'asc')->first();
            $this->activeLessonId = $firstLesson?->id;
        }
    }

    /**
     * Cambia la lección activa al hacer clic en el menú lateral.
     *
     * @param int $lessonId ID de la lección destino
     */
    public function selectLesson($lessonId)
    {
        $this->activeLessonId = $lessonId;
        $this->activeTab = 'leccion';
    }

    /**
     * Cambia de pestaña activa en el panel central (Lección o Herramienta de Taller).
     *
     * @param string $tab Nombre de la pestaña
     */
    public function switchTab($tab)
    {
        $this->activeTab = $tab;
    }

    /**
     * Marca la lección activa como completada o no completada por el alumno.
     */
    public function toggleComplete()
    {
        $userId = Auth::id() ?? 1; // Para el MVP usamos usuario autenticado o ID 1
        if (!$this->activeLessonId) return;

        $progress = UserProgress::firstOrNew([
            'user_id' => $userId,
            'lesson_id' => $this->activeLessonId,
        ]);

        $progress->completed = !$progress->completed;
        $progress->completed_at = $progress->completed ? now() : null;
        $progress->save();
    }

    /**
     * Renderiza la vista Blade del Dashboard.
     */
    public function render()
    {
        $modules = Module::with(['lessons'])->orderBy('order', 'asc')->get();
        $activeLesson = Lesson::find($this->activeLessonId);
        $userId = Auth::id() ?? 1;

        // Cálculo global de progreso
        $totalLessons = Lesson::count();
        $completedLessonsCount = UserProgress::where('user_id', $userId)
            ->where('completed', true)
            ->count();

        $progressPercent = $totalLessons > 0 ? round(($completedLessonsCount / $totalLessons) * 100) : 0;

        return view('livewire.course-dashboard', [
            'modules' => $modules,
            'activeLesson' => $activeLesson,
            'progressPercent' => $progressPercent,
            'completedCount' => $completedLessonsCount,
            'totalLessons' => $totalLessons,
            'isCurrentCompleted' => $activeLesson ? $activeLesson->isCompletedBy($userId) : false,
        ])->layout('components.layouts.app');
    }
}
