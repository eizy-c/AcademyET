<?php

namespace App\Livewire\Toolbox;

use Livewire\Component;

/**
 * Componente Livewire: Calculadora de Tornillería y Referencia de Código de Colores de Espesores.
 * Muestra diámetros/radios de orificios en chapa según tornillo y código de colores oficial de corte plasma.
 */
class ScrewCalculator extends Component
{
    // Tornillo seleccionado por el alumno
    public string $selectedScrew = '8mm';

    // Tabla de especificaciones de tornillería del manual Ecotechne
    public array $screwsData = [
        '6mm' => ['radius' => '3.0 mm', 'diameter' => '6.0 mm', 'material' => 'Hierro Negro / Galvanizado'],
        '8mm' => ['radius' => '4.0 mm', 'diameter' => '8.0 mm', 'material' => 'Galvanizado / Acero Inox'],
        '3/8' => ['radius' => '5.5 mm', 'diameter' => '11.0 mm', 'material' => 'Galvanizado (Grado 5 / 8)'],
        '7/16' => ['radius' => '6.0 mm', 'diameter' => '12.0 mm', 'material' => 'Galvanizado (Chasis y Anclajes)'],
        '1/2' => ['radius' => '7.0 mm', 'diameter' => '14.0 mm', 'material' => 'Acero Inoxidable / Alta Resistencia'],
    ];

    // Código de colores oficial para espesor de lámina en AutoCAD / Plasma CNC
    public array $colorCodes = [
        ['thickness' => '2.0 mm', 'color' => '#3B82F6', 'name' => 'Azul', 'usage' => 'Tapas secundarias y acopladores livianos'],
        ['thickness' => '2.5 mm', 'color' => '#EF4444', 'name' => 'Rojo', 'usage' => 'Cajas de protección y carcasas pequeñas'],
        ['thickness' => '3.0 mm', 'color' => '#EAB308', 'name' => 'Amarillo', 'usage' => 'Laterales de Racks, Estribos y Petos'],
        ['thickness' => '4.0 mm', 'color' => '#22C55E', 'name' => 'Verde', 'usage' => 'Estructura principal de parachoques'],
        ['thickness' => '5.0 mm', 'color' => '#F97316', 'name' => 'Naranja', 'usage' => 'Refuerzos internos y soporte de grilletes'],
        ['thickness' => '6.0 mm', 'color' => '#D946EF', 'name' => 'Magenta', 'usage' => 'Bases de barra de tiro y anclajes de winche'],
        ['thickness' => '12.0 mm', 'color' => '#06B6D4', 'name' => 'Cyan', 'usage' => 'Ganchos de rescate directos al chasis'],
    ];

    public function render()
    {
        return view('livewire.toolbox.screw-calculator');
    }
}
