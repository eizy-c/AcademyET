<?php

namespace App\Livewire\Toolbox;

use Livewire\Component;
use Livewire\Attributes\Computed;

/**
 * Componente Livewire: Calculadora de Grados de Doblez de Taller.
 * Implementa la fórmula (n - 180) para convertir mediciones de transportador 3D en cotas para AutoCAD.
 * Compatible con sintaxis Livewire v4 (#[Computed]).
 */
class FoldCalculator extends Component
{
    // Ángulo n medido con el transportador en el modelo 3D de SketchUp (grados)
    public $angleN = 146;

    // Cara del doblez: 'trasero' (lado feo/oculto) o 'frontal' (cara vista)
    public string $foldSide = 'trasero';

    /**
     * Calcula reactivamente el ángulo resultante para la cota de plano de AutoCAD.
     * Fórmula: Absoluto(n - 180) con signo positivo (+) para cara posterior y negativo (-) para cara vista.
     */
    #[Computed]
    public function calculatedAngle(): float
    {
        $n = (float) $this->angleN;
        return round(abs($n - 180), 2);
    }

    /**
     * Retorna el texto acotado formateado para colocar en AutoCAD.
     * Ejemplo: "+34°" o "-34°"
     */
    #[Computed]
    public function formattedCota(): string
    {
        $sign = $this->foldSide === 'trasero' ? '+' : '-';
        return $sign . $this->calculatedAngle . '°';
    }

    /**
     * Evalúa si el grado de doblez excede los 100° permitidos por el prisma estándar de la dobladora.
     */
    #[Computed]
    public function exceedsMachineLimit(): bool
    {
        return $this->calculatedAngle > 100.0;
    }

    public function render()
    {
        return view('livewire.toolbox.fold-calculator');
    }
}
