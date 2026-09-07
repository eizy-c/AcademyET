<!-- Visor 3D Interactivo - Google <model-viewer> -->
<div class="bg-slate-900 border border-slate-800 rounded-xl overflow-hidden shadow-2xl relative flex flex-col h-[520px]">
    
    <!-- Barra Superior del Visor 3D -->
    <div class="bg-slate-950 px-4 py-3 border-b border-slate-800 flex items-center justify-between z-10">
        <div class="flex items-center space-x-2">
            <span class="w-3 h-3 rounded-full bg-emerald-500 animate-pulse"></span>
            <h4 class="text-sm font-bold text-white font-mono-tech uppercase tracking-wider">
                {{ $modelTitle }}
            </h4>
        </div>
        <div class="flex items-center space-x-2">
            <button wire:click="toggleExplode" 
                    class="px-3 py-1 rounded bg-orange-500/20 text-orange-400 hover:bg-orange-500/30 text-xs font-mono-tech font-bold border border-orange-500/30 transition-colors">
                {{ $isExploded ? '🔍 MODO ENSAMBLADO 3D' : '💥 ANIMAR DESPIECE 2D' }}
            </button>
        </div>
    </div>

    <!-- Contenedor WebGL / Canvas 3D -->
    <div class="flex-1 relative bg-gradient-to-b from-slate-950 via-slate-900 to-slate-950 flex items-center justify-center overflow-hidden">
        
        @if($modelUrl)
            <!-- Integración con Google <model-viewer> -->
            <model-viewer src="{{ asset($modelUrl) }}"
                          alt="{{ $modelTitle }}"
                          auto-rotate
                          camera-controls
                          shadow-intensity="1.5"
                          exposure="1.0"
                          touch-action="pan-y"
                          class="w-full h-full">
            </model-viewer>
        @else
            <!-- Demostración interactiva en canvas si aún no hay archivo GLB subido -->
            <div class="text-center p-8 space-y-4 max-w-md">
                <div class="w-24 h-24 mx-auto rounded-2xl bg-gradient-to-tr from-orange-500/20 to-amber-500/10 border border-orange-500/30 flex items-center justify-center text-4xl shadow-xl shadow-orange-500/10 animate-bounce">
                    🧊
                </div>
                <div>
                    <h5 class="text-base font-bold text-white">Entorno de Visualización 3D Listo</h5>
                    <p class="text-xs text-slate-400 mt-1 leading-relaxed">
                        Soporta renderizado en tiempo real de archivos <strong>.glb</strong> para parachoques 4x4, racks, estribos y accesorios desplegados.
                    </p>
                </div>
                <div class="pt-2 flex justify-center gap-2">
                    <span class="px-2.5 py-1 rounded bg-slate-800 text-[11px] font-mono-tech text-slate-300">Órbita 360°</span>
                    <span class="px-2.5 py-1 rounded bg-slate-800 text-[11px] font-mono-tech text-slate-300">Zoom Cota</span>
                    <span class="px-2.5 py-1 rounded bg-slate-800 text-[11px] font-mono-tech text-slate-300">Sombras PBR</span>
                </div>
            </div>
        @endif

        <!-- Superposición de Leyenda de Controles -->
        <div class="absolute bottom-3 left-3 bg-slate-950/80 backdrop-blur border border-slate-800 px-3 py-1.5 rounded-lg text-[11px] font-mono-tech text-slate-400 pointer-events-none">
            🖱️ Clic Izquierdo: Rotar 360° | 🖱️ Clic Derecho: Desplazar | 🎡 Rueda: Zoom
        </div>

    </div>

</div>
