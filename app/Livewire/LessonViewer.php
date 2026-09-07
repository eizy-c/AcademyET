<?php

namespace App\Livewire;

use App\Models\Lesson;
use Livewire\Component;

/**
 * Componente Livewire: Visualizador de Lección Técnica.
 * Presenta el resumen didáctico, normas de taller, matriz de comandos de teclado y zonas de prácticas.
 */
class LessonViewer extends Component
{
    // Lección activa instanciada
    public ?Lesson $lesson = null;

    public function mount($lesson)
    {
        $this->lesson = $lesson;
    }

    public function render()
    {
        return view('livewire.lesson-viewer');
    }
}
