<!-- Dashboard Principal del Curso Interactivo de Diseño 3D -->
<div class="flex-1 flex overflow-hidden">
    
    <!-- Sidebar / Menú Lateral de Módulos y Lecciones -->
    <aside class="w-80 bg-slate-900 border-r border-slate-800 flex flex-col justify-between shrink-0">
        
        <!-- Contenido Navegable del Sidebar -->
        <div class="overflow-y-auto p-4 space-y-5 flex-1">
            
            <!-- Tarjeta de Progreso General del Alumno -->
            <div class="bg-slate-950 border border-slate-800 rounded-xl p-4 space-y-3">
                <div class="flex items-center justify-between text-xs font-mono-tech">
                    <span class="text-slate-400 font-bold">AVANCE DEL ALUMNO</span>
                    <span class="text-orange-400 font-extrabold">{{ $progressPercent }}%</span>
                </div>
                <div class="w-full bg-slate-900 h-2 rounded-full overflow-hidden border border-slate-800">
                    <div class="bg-gradient-to-r from-orange-500 to-amber-500 h-full rounded-full transition-all duration-500" style="width: {{ $progressPercent }}%"></div>
                </div>
                <div class="text-[11px] text-slate-500 font-mono-tech flex justify-between">
                    <span>{{ $completedCount }} de {{ $totalLessons }} completadas</span>
                    <span>Ecotechne CAD</span>
                </div>
            </div>

            <!-- Lista de Módulos y Lecciones -->
            <div class="space-y-4">
                @foreach($modules as $module)
                    <div class="space-y-2">
                        <h3 class="text-xs font-mono-tech font-bold text-slate-400 uppercase tracking-wider px-2 flex items-center justify-between">
                            <span>{{ $module->title }}</span>
                        </h3>
                        <div class="space-y-1">
                            @foreach($module->lessons as $lesson)
                                <button type="button" 
                                        wire:click="selectLesson({{ $lesson->id }})"
                                        class="w-full text-left px-3 py-2.5 rounded-lg text-xs font-medium transition-all flex items-center justify-between group {{ $activeLessonId === $lesson->id ? 'bg-orange-500/15 border border-orange-500/40 text-orange-300 shadow-sm' : 'text-slate-300 hover:bg-slate-800/60 border border-transparent' }}">
                                    <div class="flex items-center space-x-2.5 truncate">
                                        <span class="text-[11px] font-mono-tech font-bold {{ $activeLessonId === $lesson->id ? 'text-orange-400' : 'text-slate-500' }}">
                                            {{ sprintf('%02d', $lesson->order) }}
                                        </span>
                                        <span class="truncate">{{ $lesson->title }}</span>
                                    </div>
                                    @if($lesson->isCompletedBy(auth()->id() ?? 1))
                                        <span class="text-emerald-400 text-xs font-mono-tech">✓</span>
                                    @endif
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

        </div>

        <!-- Footer del Sidebar -->
        <div class="p-4 border-t border-slate-800/80 bg-slate-950 text-center">
            <span class="text-[11px] font-mono-tech text-slate-500">CURSO DE DISEÑO METALMECÁNICO v0.1.0-alpha</span>
        </div>

    </aside>

    <!-- Zona Central de Aprendizaje y Caja de Herramientas (Toolbox) -->
    <section class="flex-1 flex flex-col overflow-y-auto bg-slate-950 p-6 space-y-6">
        
        <!-- Barra de Navegación de Pestañas Interactivas (Toolbox Tabs) -->
        <div class="flex items-center space-x-2 bg-slate-900 p-1.5 rounded-xl border border-slate-800 shrink-0 overflow-x-auto">
            
            <button wire:click="switchTab('leccion')" 
                    class="px-4 py-2 rounded-lg text-xs font-mono-tech font-bold transition-all flex items-center gap-2 whitespace-nowrap {{ $activeTab === 'leccion' ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                <span>📖 LECCIÓN TÉCNICA</span>
            </button>

            <button wire:click="switchTab('calculadora_doblez')" 
                    class="px-4 py-2 rounded-lg text-xs font-mono-tech font-bold transition-all flex items-center gap-2 whitespace-nowrap {{ $activeTab === 'calculadora_doblez' ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                <span>📐 CALCULADORA DOBLEZ (n-180)</span>
            </button>

            <button wire:click="switchTab('validador_u')" 
                    class="px-4 py-2 rounded-lg text-xs font-mono-tech font-bold transition-all flex items-center gap-2 whitespace-nowrap {{ $activeTab === 'validador_u' ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                <span>🔩 VALIDADOR U</span>
            </button>

            <button wire:click="switchTab('tornilleria')" 
                    class="px-4 py-2 rounded-lg text-xs font-mono-tech font-bold transition-all flex items-center gap-2 whitespace-nowrap {{ $activeTab === 'tornilleria' ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                <span>🎨 TORNILLERÍA & ESPESORES</span>
            </button>

            <button wire:click="switchTab('visor_3d')" 
                    class="px-4 py-2 rounded-lg text-xs font-mono-tech font-bold transition-all flex items-center gap-2 whitespace-nowrap {{ $activeTab === 'visor_3d' ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                <span>🧊 VISOR 3D ACCESORIOS</span>
            </button>

        </div>

        <!-- Renderizado dinámico según la pestaña activa -->
        <div class="flex-1">
            @if($activeTab === 'leccion')
                @livewire('interactive-lesson-flow', ['lesson' => $activeLesson], key('flow-'.$activeLessonId))
            @elseif($activeTab === 'calculadora_doblez')
                @livewire('toolbox.fold-calculator')
            @elseif($activeTab === 'validador_u')
                @livewire('toolbox.u-bend-validator')
            @elseif($activeTab === 'tornilleria')
                @livewire('toolbox.screw-calculator')
            @elseif($activeTab === 'visor_3d')
                @livewire('viewers.model-viewer-3d', [
                    'modelUrl' => $activeLesson?->model_3d_path,
                    'modelTitle' => $activeLesson?->title ?? 'Pieza 3D Off-Road'
                ])
            @endif
        </div>

    </section>

</div>
