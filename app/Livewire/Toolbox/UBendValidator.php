<?php

namespace App\Livewire\Toolbox;

use Livewire\Component;
use Livewire\Attributes\Computed;

/**
 * Componente Livewire: Validador de Viabilidad de Plegado en "U".
 * Revisa en tiempo real si un perfil tipo canal de dos pliegues a 90° colisionará contra la uña del prisma.
 * Compatible con sintaxis Livewire v4 (#[Computed]).
 */
class UBendValidator extends Component
{
    // Dimensión de la primera ala lateral (mm)
    public $wingA = 40;

    // Dimensión de la base o alma central (mm)
    public $baseCenter = 55;

    // Dimensión de la segunda ala lateral (mm)
    public $wingB = 40;

    /**
     * Valida si la pestaña cumple con el mínimo de 15mm para el prisma estándar.
     */
    #[Computed]
    public function validMinFlange(): bool
    {
        $a = (float) $this->wingA;
        $b = (float) $this->wingB;
        return $a >= 15.0 && $b >= 15.0;
    }

    /**
     * Valida si el pliegue en "U" es geométricamente ejecutable sin colisión.
     * Regla: La base central debe ser mayor o igual a ambas alas laterales,
     * O una de las alas debe ser menor que la base central para permitir doblado en orden.
     */
    #[Computed]
    public function isViable(): bool
    {
        if (!$this->validMinFlange) {
            return false;
        }

        $a = (float) $this->wingA;
        $base = (float) $this->baseCenter;
        $b = (float) $this->wingB;

        // Si la base es mayor o igual a ambas alas, la uña penetra sin golpear las paredes
        if ($base >= $a && $base >= $b) {
            return true;
        }

        // Si un lado es menor que la base (ej. Ala A=20, Base=55, Ala B=60), se puede doblar primero el lado corto
        if ($a < $base || $b < $base) {
            return true;
        }

        return false;
    }

    /**
     * Genera el diagnóstico técnico explicativo para el proyectista.
     */
    #[Computed]
    public function diagnosticMessage(): string
    {
        if (!$this->validMinFlange) {
            return 'Pestaña inferior a 15 mm. Requerirá cambiar a prisma pequeño (limitado a espesores ≤ 3 mm).';
        }

        $a = (float) $this->wingA;
        $base = (float) $this->baseCenter;
        $b = (float) $this->wingB;

        if ($this->isViable) {
            if ($base >= $a && $base >= $b) {
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
