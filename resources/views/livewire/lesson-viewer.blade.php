<!-- Visualizador de Lección Técnica -->
<div class="space-y-6">
    
    @if($lesson)
        <!-- Encabezado de Lección -->
        <div class="bg-slate-900 border border-slate-800 rounded-xl p-6 shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-mono-tech font-bold text-orange-500 uppercase tracking-widest block mb-1">
                        {{ $lesson->module->title }}
                    </span>
                    <h2 class="text-2xl font-extrabold text-white tracking-tight">
                        {{ $lesson->title }}
                    </h2>
                </div>
                <button wire:click="$parent.toggleComplete" 
                        class="px-4 py-2 rounded-lg font-mono-tech text-xs font-bold transition-all flex items-center gap-2 border {{ $lesson->isCompletedBy(auth()->id() ?? 1) ? 'bg-emerald-500/20 text-emerald-300 border-emerald-500/40' : 'bg-slate-800 text-slate-300 hover:bg-slate-700 border-slate-700' }}">
                    <span>{{ $lesson->isCompletedBy(auth()->id() ?? 1) ? '✅ LECCIÓN COMPLETADA' : '⭕ MARCAR COMO VISTA' }}</span>
                </button>
            </div>

            <!-- Resumen Teórico -->
            <p class="text-sm text-slate-300 mt-4 leading-relaxed bg-slate-950/60 p-4 rounded-lg border border-slate-800/80">
                {{ $lesson->summary }}
            </p>
        </div>

        <!-- Contenido y Procedimiento Técnico -->
        <div class="bg-slate-900 border border-slate-800 rounded-xl p-6 shadow-xl space-y-4">
            <h3 class="text-sm font-bold text-white font-mono-tech uppercase tracking-wider text-orange-400 flex items-center gap-2">
                <span>📌</span> PROCEDIMIENTO Y REGLAS DE TALLER
            </h3>
            <div class="text-sm text-slate-300 leading-relaxed prose prose-invert max-w-none">
                {{ $lesson->content }}
            </div>
        </div>

        <!-- Matriz de Reglas de Taller -->
        @if($lesson->workshop_rules && count($lesson->workshop_rules) > 0)
            <div class="bg-slate-900 border border-slate-800 rounded-xl p-6 shadow-xl space-y-4">
                <h3 class="text-sm font-bold text-white font-mono-tech uppercase tracking-wider text-amber-400 flex items-center gap-2">
                    <span>📐</span> RESTRICCIONES GEOMÉTRICAS Y DE MANUFACTURA
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @foreach($lesson->workshop_rules as $ruleKey => $ruleValue)
                        <div class="bg-slate-950 border border-slate-800 rounded-lg p-3.5 flex items-start gap-3">
                            <span class="text-orange-500 font-mono-tech font-bold text-sm">►</span>
                            <div>
                                <strong class="text-xs font-mono-tech uppercase text-slate-300 block mb-0.5">{{ str_replace('_', ' ', $ruleKey) }}</strong>
                                <span class="text-xs text-slate-400">{{ $ruleValue }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Tabla de Atajos de Teclado (Shortcuts Cheatsheet) -->
        @if($lesson->shortcuts && count($lesson->shortcuts) > 0)
            <div class="bg-slate-900 border border-slate-800 rounded-xl p-6 shadow-xl space-y-4">
                <h3 class="text-sm font-bold text-white font-mono-tech uppercase tracking-wider text-sky-400 flex items-center gap-2">
                    <span>⌨️</span> ATAJOS DE TECLADO Y COMANDOS RÁPIDOS
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                    @foreach($lesson->shortcuts as $sc)
                        <div class="bg-slate-950 border border-slate-800 rounded-lg p-3 flex items-center justify-between">
                            <span class="text-xs text-slate-300 font-medium">{{ $sc['action'] }}</span>
                            <kbd class="px-2.5 py-1 rounded bg-slate-800 text-orange-400 font-mono-tech font-bold text-xs border border-slate-700 shadow-sm">
                                {{ $sc['key'] }}
                            </kbd>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    @else
        <div class="bg-slate-900 border border-slate-800 rounded-xl p-12 text-center space-y-3">
            <p class="text-slate-400 text-sm">Selecciona una lección en el menú lateral para comenzar.</p>
        </div>
    @endif

</div>
