<!-- Calculadora de Grados de Doblez - Manual Ecotechne -->
<div class="bg-slate-900 border border-slate-800 rounded-xl p-6 shadow-xl">
    
    <!-- Encabezado de la Herramienta -->
    <div class="flex items-center justify-between pb-4 mb-6 border-b border-slate-800">
        <div>
            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                <span class="text-orange-500 font-mono-tech">📐</span> Calculadora de Grados de Doblez
            </h3>
            <p class="text-xs text-slate-400 mt-1">Fórmula oficial de taller: <code class="bg-slate-950 px-1.5 py-0.5 rounded text-orange-400 font-mono-tech font-semibold">(n - 180)</code> para acotado en AutoCAD</p>
        </div>
        <span class="px-2.5 py-1 rounded-md text-xs font-mono-tech font-bold bg-orange-500/10 text-orange-400 border border-orange-500/20">
            FÓRMULA SKETCHUP
        </span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <!-- Panel de Entradas de Datos -->
        <div class="space-y-5">
            
            <!-- Campo: Ángulo n del Transportador -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">
                    Ángulo $n$ medido con Transportador (°):
                </label>
                <div class="relative">
                    <input type="number" step="0.5" min="0" max="180" wire:model.live="angleN" 
                           class="w-full bg-slate-950 border border-slate-700 rounded-lg px-4 py-3 text-lg font-mono-tech font-bold text-orange-400 focus:outline-none focus:border-orange-500 transition-colors">
                    <span class="absolute right-4 top-3.5 text-slate-500 font-mono-tech font-bold">° DEG</span>
                </div>
                <p class="text-xs text-slate-500 mt-1.5">Medido colocando el transportador sobre la arista del doblez en SketchUp 3D.</p>
            </div>

            <!-- Campo: Cara del Doblez (Positiva o Negativa) -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">
                    Orientación / Cara del Doblez:
                </label>
                <div class="grid grid-cols-2 gap-3">
                    <button type="button" wire:click="$set('foldSide', 'trasero')" 
                            class="px-4 py-3 rounded-lg border text-xs font-bold transition-all text-left flex items-center justify-between {{ $foldSide === 'trasero' ? 'bg-orange-500/20 border-orange-500 text-orange-300 shadow-md shadow-orange-500/10' : 'bg-slate-950 border-slate-800 text-slate-400 hover:border-slate-700' }}">
                        <span>
                            <strong class="block text-white text-sm">Posterior / Lado "Feo"</strong>
                            <span class="text-[11px] font-mono-tech font-normal text-slate-400">Cota POSITIVA (+)</span>
                        </span>
                        <span class="text-lg">➕</span>
                    </button>

                    <button type="button" wire:click="$set('foldSide', 'frontal')" 
                            class="px-4 py-3 rounded-lg border text-xs font-bold transition-all text-left flex items-center justify-between {{ $foldSide === 'frontal' ? 'bg-sky-500/20 border-sky-500 text-sky-300 shadow-md shadow-sky-500/10' : 'bg-slate-950 border-slate-800 text-slate-400 hover:border-slate-700' }}">
                        <span>
                            <strong class="block text-white text-sm">Frente / Lado Vista</strong>
                            <span class="text-[11px] font-mono-tech font-normal text-slate-400">Cota NEGATIVA (-)</span>
                        </span>
                        <span class="text-lg">➖</span>
                    </button>
                </div>
            </div>

            <!-- Slider Rápido -->
            <div>
                <div class="flex justify-between text-xs font-mono-tech text-slate-400 mb-1">
                    <span>0° (Cerrado)</span>
                    <span>90° (Ángulo Recto)</span>
                    <span>180° (Plano)</span>
                </div>
                <input type="range" min="80" max="180" step="1" wire:model.live="angleN" 
                       class="w-full accent-orange-500 bg-slate-950 h-2 rounded-lg cursor-pointer">
            </div>

        </div>

        <!-- Panel de Resultados & Previsualización -->
        <div class="bg-slate-950 border border-slate-800 rounded-xl p-5 flex flex-col justify-between relative overflow-hidden">
            
            <div class="space-y-4">
                <span class="text-xs font-mono-tech uppercase tracking-wider text-slate-400 font-bold block">
                    RESULTADO PARA ANOTAR EN AUTOCAD:
                </span>

                <!-- Valor de Cota Calculado -->
                <div class="bg-slate-900 border border-slate-800 rounded-lg p-4 text-center">
                    <div class="text-4xl font-extrabold font-mono-tech tracking-tight {{ $foldSide === 'trasero' ? 'text-emerald-400' : 'text-sky-400' }}">
                        {{ $this->formattedCota }}
                    </div>
                    <p class="text-xs text-slate-400 mt-2">
                        Fórmula: <span class="font-mono-tech">|{{ $angleN }} - 180| = {{ $this->calculatedAngle }}°</span>
                    </p>
                </div>

                <!-- Alerta de Capacidad de Máquina Dobladora -->
                @if($this->exceedsMachineLimit)
                    <div class="p-3.5 rounded-lg bg-rose-500/10 border border-rose-500/30 text-rose-300 text-xs space-y-1">
                        <strong class="font-bold flex items-center gap-1 text-rose-400">
                            ⚠️ EXCEDE CAPACIDAD DE MÁQUINA DOBLEZ (> 100°)
                        </strong>
                        <p>La dobladora de taller dobla máximo a <strong>100°</strong>. Un ángulo mayor requerirá realizar un acanalado mecánico previo en la lámina.</p>
                    </div>
                @else
                    <div class="p-3 rounded-lg bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 text-xs flex items-center gap-2">
                        <span>✅</span>
                        <span>Ángulo ejecutable en dobladora Estándar de taller (≤ 100°).</span>
                    </div>
                @endif
            </div>

            <!-- Esquema Gráfico del Doblez -->
            <div class="mt-6 pt-4 border-t border-slate-900 text-center">
                <p class="text-[11px] text-slate-400 font-mono-tech">
                    [Cota en plano 2D AutoCAD]: <strong class="text-orange-400">{{ $this->formattedCota }}</strong>
                </p>
            </div>

        </div>

    </div>

</div>
