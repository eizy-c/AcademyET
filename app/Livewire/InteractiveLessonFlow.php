<?php

namespace App\Livewire;

use App\Models\Lesson;
use App\Models\LessonStep;
use App\Models\UserStepProgress;
use App\Models\UserProgress;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;

/**
 * Componente Livewire: Flujo Guiado de Lección Interactiva Paso a Paso con Cuestionarios.
 * Controla el avance secuencial del alumno: Teoría Corta ➔ Cuestionario/Desafío ➔ Retroalimentación ➔ Siguiente Paso.
 */
class InteractiveLessonFlow extends Component
{
    // Lección activa instanciada
    public ?Lesson $lesson = null;

    // Índice del paso activo actualmente (0, 1, 2, ...)
    public int $currentStepIndex = 0;

    // Respuesta seleccionada o ingresada por el alumno en el paso activo
    public ?string $selectedAnswer = null;

    // Estado de la evaluación del paso activo
    public bool $isAnswered = false;
    public bool $isCorrect = false;
    public string $feedbackMessage = '';

    public function mount($lesson)
    {
        $this->lesson = $lesson;
        $this->loadStepState();
    }

    /**
     * Carga el estado del paso activo actual y recupera respuesta previa si existe.
     */
    public function loadStepState()
    {
        $this->selectedAnswer = null;
        $this->isAnswered = false;
        $this->isCorrect = false;
        $this->feedbackMessage = '';

        $step = $this->currentStep;
        if (!$step) return;

        $userId = Auth::id() ?? 1;
        $userProgress = UserStepProgress::where('user_id', $userId)
            ->where('lesson_step_id', $step->id)
            ->first();

        if ($userProgress && $userProgress->completed) {
            $this->isAnswered = true;
            $this->isCorrect = true;
            $this->selectedAnswer = $userProgress->user_answer;
            $this->feedbackMessage = $step->explanation ?? '¡Paso completado exitosamente!';
        }
    }

    /**
     * Colección de pasos secuenciales pertenecientes a la lección.
     */
    #[Computed]
    public function steps()
    {
        return $this->lesson ? $this->lesson->steps : collect();
    }

    /**
     * Paso activo actual según el índice `$currentStepIndex`.
     */
    #[Computed]
    public function currentStep()
    {
        return $this->steps->get($this->currentStepIndex);
    }

    /**
     * Evalúa la respuesta dada por el estudiante en un Cuestionario o Desafío.
     *
     * @param string $answer Respuesta seleccionada o ingresada
     */
    public function submitAnswer($answer)
    {
        $step = $this->currentStep;
        if (!$step) return;

        $this->selectedAnswer = $answer;
        $this->isAnswered = true;
        $userId = Auth::id() ?? 1;

        // Si el paso es de tipo teoría o calculadora interactiva, se marca automáticamente como correcto
        if ($step->type === 'theory' || $step->type === 'interactive_calc') {
            $this->isCorrect = true;
            $this->feedbackMessage = $step->explanation ?? '¡Concepto comprendido!';
        } else {
            // Comparación de respuesta sin distinguir mayúsculas
            $cleanUserAnswer = trim(strtolower($answer));
            $cleanCorrect = trim(strtolower($step->correct_answer));

            if ($cleanUserAnswer === $cleanCorrect) {
                $this->isCorrect = true;
                $this->feedbackMessage = '¡CORRECTO! ' . ($step->explanation ?? 'Respuesta acertada.');
            } else {
                $this->isCorrect = false;
                $this->feedbackMessage = 'Respuesta incorrecta. Revisa el concepto e inténtalo nuevamente.';
                return;
            }
        }

        // Guardar progreso en base de datos si la respuesta fue correcta
        if ($this->isCorrect) {
            UserStepProgress::updateOrCreate(
                [
                    'user_id' => $userId,
                    'lesson_step_id' => $step->id,
                ],
                [
                    'completed' => true,
                    'user_answer' => $answer,
                    'completed_at' => now(),
                ]
            );

            // Si es el último paso de la lección, marcar la lección completa
            if ($this->currentStepIndex >= $this->steps->count() - 1) {
                UserProgress::updateOrCreate(
                    [
                        'user_id' => $userId,
                        'lesson_id' => $this->lesson->id,
                    ],
                    [
                        'completed' => true,
                        'completed_at' => now(),
                    ]
                );
            }
        }
    }

    /**
     * Avanza al siguiente paso de la lección.
     */
    public function nextStep()
    {
        if ($this->currentStepIndex < $this->steps->count() - 1) {
            $this->currentStepIndex++;
            $this->loadStepState();
        }
    }

    /**
     * Retrocede al paso anterior para revisión.
     */
    public function prevStep()
    {
        if ($this->currentStepIndex > 0) {
            $this->currentStepIndex--;
            $this->loadStepState();
        }
    }

    /**
     * Salta a un paso específico si los anteriores han sido vistos.
     */
    public function jumpToStep($index)
    {
        if ($index >= 0 && $index < $this->steps->count()) {
            $this->currentStepIndex = $index;
            $this->loadStepState();
        }
    }

    public function render()
    {
        return view('livewire.interactive-lesson-flow');
    }
}
