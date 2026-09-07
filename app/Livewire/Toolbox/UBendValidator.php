<?php

namespace App\Livewire\Toolbox;

use Livewire\Component;

/**
 * Componente Livewire: Validador de Viabilidad de Plegado en "U".
 * Revisa en tiempo real si un perfil tipo canal de dos pliegues a 90° colisionará contra la uña del prisma.
 */
class UBendValidator extends Component
{
    // Dimensión de la primera ala lateral (mm)
    public float $wingA = 40.0;

    // Dimensión de la base o alma central (mm)
    public float $baseCenter = 55.0;

    // Dimensión de la segunda ala lateral (mm)
    public float $wingB = 40.0;

    /**
     * Valida si la pestaña cumple con el mínimo de 15mm para el prisma estándar.
     */
    public function getValidMinFlangeProperty(): bool
    {
        return $this->wingA >= 15.0 && $this->wingB >= 15.0;
    }

    /**
     * Valida si el pliegue en "U" es geométricamente ejecutable sin colisión.
     * Regla: La base central debe ser mayor o igual a ambas alas laterales,
     * O una de las alas debe ser sensiblemente menor que la otra para permitir paso.
     */
    public function getIsViableProperty(): bool
    {
        if (!$this->validMinFlange) {
            return false;
        }

        // Si la base es mayor o igual a ambas alas, la uña penetra sin golpear las paredes
        if ($this->baseCenter >= $this->wingA && $this->baseCenter >= $this->wingB) {
            return true;
        }

        // Si un lado es significativamente menor (ej. Ala A=20, Base=55, Ala B=60), se puede doblar primero el lado corto
        if (($this->wingA < $this->baseCenter || $this->wingB < $this->baseCenter)) {
            return true;
        }

        return false;
    }

    /**
     * Genera el diagnóstico técnico explicativo para el proyectista.
     */
    public function getDiagnosticMessageProperty(): string
    {
        if (!$this->validMinFlange) {
            return 'Pestaña inferior a 15 mm. Requerirá cambiar a prisma pequeño (limitado a espesores ≤ 3 mm).';
        }

        if ($this->isViable) {
            if ($this->baseCenter >= $this->wingA && $this->baseCenter >= $this->wingB) {
                return 'Diseño Óptimo: La base central es suficientemente ancha para recibir la uña de la dobladora sin rozar las alas laterales.';
            } else {
                return 'Diseño Asimétrico Viable: Permite doblar primero el ala corta sin que el ala opuesta tropiece contra la herramienta.';
            }
        }

        return 'COLISIÓN DETECTADA: Ambas alas son más largas que la base central. La pieza chocará contra la uña de la dobladora antes de alcanzar los 90°. Se requiere hacer un ala más corta o acanalar uno de los pliegues.';
    }

    public function render()
    {
        return view('livewire.toolbox.u-bend-validator');
    }
}
