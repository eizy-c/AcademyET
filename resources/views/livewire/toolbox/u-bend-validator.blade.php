<!-- Validador de Viabilidad de Plegado en U -->
<div class="bg-slate-900 border border-slate-800 rounded-xl p-6 shadow-xl">
    
    <!-- Encabezado de la Herramienta -->
    <div class="flex items-center justify-between pb-4 mb-6 border-b border-slate-800">
        <div>
            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                <span class="text-orange-500 font-mono-tech">🔩</span> Validador de Plegado en "U" (Canal)
            </h3>
            <p class="text-xs text-slate-400 mt-1">Verificación geométrica para evitar colisión de la uña de la dobladora contra alas laterales a 90°</p>
        </div>
        <span class="px-2.5 py-1 rounded-md text-xs font-mono-tech font-bold bg-purple-500/10 text-purple-400 border border-purple-500/20">
            GEOMETRÍA DE MÁQUINA
        </span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Inputs de Medidas en mm -->
        <div class="space-y-4 md:col-span-2">
            
            <div class="grid grid-cols-3 gap-4">
                
                <!-- Ala A -->
                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">
                        Ala Lateral A (mm):
                    </label>
                    <input type="number" step="1" min="5" wire:model.live="wingA" 
                           class="w-full bg-slate-950 border border-slate-700 rounded-lg px-3 py-2.5 text-base font-mono-tech font-bold text-white focus:border-orange-500 focus:outline-none">
                    <p class="text-[10px] text-slate-500 mt-1">Mínimo ideal: 15mm</p>
                </div>

                <!-- Base Central -->
                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">
                        Base Central (mm):
                    </label>
                    <input type="number" step="1" min="5" wire:model.live="baseCenter" 
                           class="w-full bg-slate-950 border border-slate-700 rounded-lg px-3 py-2.5 text-base font-mono-tech font-bold text-amber-400 focus:border-orange-500 focus:outline-none">
                    <p class="text-[10px] text-slate-500 mt-1">Ancho del alma en U</p>
                </div>

                <!-- Ala B -->
                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">
                        Ala Lateral B (mm):
                    </label>
                    <input type="number" step="1" min="5" wire:model.live="wingB" 
                           class="w-full bg-slate-950 border border-slate-700 rounded-lg px-3 py-2.5 text-base font-mono-tech font-bold text-white focus:border-orange-500 focus:outline-none">
                    <p class="text-[10px] text-slate-500 mt-1">Mínimo ideal: 15mm</p>
                </div>

            </div>

            <!-- Esquema Ilustrativo del Perfil en U -->
            <div class="bg-slate-950 border border-slate-800 rounded-lg p-4 flex items-center justify-center min-h-[120px]">
                <div class="flex items-end gap-1 font-mono-tech text-xs">
                    <!-- Ala A -->
                    <div class="border-l-2 border-t-2 border-orange-500 text-orange-400 px-2 py-6 flex items-center justify-center font-bold" style="height: {{ min(120, max(40, $wingA * 1.2)) }}px">
                        A: {{ $wingA }}mm
                    </div>
                    <!-- Base -->
                    <div class="border-b-2 border-amber-400 text-amber-300 px-6 py-2 font-bold text-center" style="width: {{ min(200, max(60, $baseCenter * 1.5)) }}px">
                        Base: {{ $baseCenter }}mm
                    </div>
                    <!-- Ala B -->
                    <div class="border-r-2 border-t-2 border-orange-500 text-orange-400 px-2 py-6 flex items-center justify-center font-bold" style="height: {{ min(120, max(40, $wingB * 1.2)) }}px">
                        B: {{ $wingB }}mm
                    </div>
                </div>
            </div>

        </div>

        <!-- Panel de Resultado y Diagnóstico -->
        <div class="bg-slate-950 border border-slate-800 rounded-xl p-5 flex flex-col justify-between">
            
            <div class="space-y-4">
                <span class="text-xs font-mono-tech uppercase tracking-wider text-slate-400 font-bold block">
                    DIAGNÓSTICO DE FABRICACIÓN:
                </span>

                <!-- Indicador de Estado -->
                @if($this->isViable)
                    <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-300">
                        <div class="flex items-center gap-2 text-emerald-400 font-extrabold text-base mb-1">
                            <span>✅</span> <span>PLEGADO VIABLE</span>
                        </div>
                        <p class="text-xs leading-relaxed opacity-90">{{ $this->diagnosticMessage }}</p>
                    </div>
                @else
                    <div class="p-4 rounded-xl bg-rose-500/10 border border-rose-500/30 text-rose-300">
                        <div class="flex items-center gap-2 text-rose-400 font-extrabold text-base mb-1">
                            <span>❌</span> <span>COLISIÓN INVIABLE</span>
                        </div>
                        <p class="text-xs leading-relaxed opacity-90">{{ $this->diagnosticMessage }}</p>
                    </div>
                @endif

                <!-- Regla Geometría Manual Ecotechne -->
                <div class="bg-slate-900 border border-slate-800 rounded-lg p-3 space-y-2 text-xs">
                    <strong class="text-slate-300 font-mono-tech block font-semibold">REGLAS DEL MANUAL:</strong>
                    <ul class="space-y-1 text-slate-400 text-[11px] list-disc list-inside">
                        <li>Pestaña mín = 15 mm (evita cambio de prisma).</li>
                        <li>Base Central ≥ Alas (evita tropiezo en la uña).</li>
                        <li>Si la pieza es inviable, hacer un ala más corta o acanalar.</li>
                    </ul>
                </div>
            </div>

        </div>

    </div>

</div>
