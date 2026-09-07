<?php

namespace App\Livewire\Viewers;

use Livewire\Component;

/**
 * Componente Livewire: Visor 3D Interactivo de Piezas Metalmecánicas.
 * Renderiza modelos tridimensionales (.glb) usando <model-viewer> con controles de órbita y zoom.
 */
class ModelViewer3d extends Component
{
    // Ruta del modelo 3D GLB
    public ?string $modelUrl = null;

    // Título o descripción del accesorio u 4x4 seleccionado
    public string $modelTitle = 'Accesorio Metalmecánico 4x4';

    // Estado del modo despiece / desdoblado interactivo
    public bool $isExploded = false;

    public function mount($modelUrl = null, $modelTitle = 'Accesorio 4x4')
    {
        $this->modelUrl = $modelUrl;
        $this->modelTitle = $modelTitle;
    }

    /**
     * Alterna la animación de despiece 2D vs ensamblaje 3D.
     */
    public function toggleExplode()
    {
        $this->isExploded = !$this->isExploded;
    }

    public function render()
    {
        return view('livewire.viewers.model-viewer-3d');
    }
}
