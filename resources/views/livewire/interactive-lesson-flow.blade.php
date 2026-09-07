<!-- Componente de Clase Guiada Paso a Paso con Cuestionarios Interactivas -->
<div class="space-y-6 max-w-4xl mx-auto">
    
    @if($this->currentStep)
        <!-- Barra de Progreso de Etapas (Stepper) -->
        <div class="bg-slate-900/90 border border-slate-800 rounded-xl p-4 shadow-xl backdrop-blur">
            <div class="flex items-center justify-between mb-3 text-xs font-mono-tech">
                <span class="text-slate-400 font-bold uppercase tracking-wider">
                    {{ $lesson->title }} — ETAPA {{ $currentStepIndex + 1 }} DE {{ $this->steps->count() }}
                </span>
                <span class="text-orange-400 font-extrabold">
                    {{ round((($currentStepIndex + 1) / max(1, $this->steps->count())) * 100) }}% COMPLETADO
                </span>
            </div>

            <!-- Nodos del Stepper -->
            <div class="grid grid-cols-{{ max(1, $this->steps->count()) }} gap-2">
                @foreach($this->steps as $index => $s)
                    @php
                        $isCompleted = $s->isCompletedBy(auth()->id() ?? 1);
                        $isActive = $currentStepIndex === $index;
                    @endphp
                    <button type="button" 
                            wire:click="jumpToStep({{ $index }})"
                            class="h-2 rounded-full transition-all duration-300 {{ $isActive ? 'bg-orange-500 ring-2 ring-orange-500/50 shadow-md shadow-orange-500/30' : ($isCompleted ? 'bg-emerald-500' : 'bg-slate-800') }}">
                    </button>
                @endforeach
            </div>

            <!-- Etiquetas de Navegación de Etapas -->
            <div class="flex justify-between items-center mt-3 overflow-x-auto text-[11px] font-mono-tech gap-2 pt-1 border-t border-slate-800/60">
                @foreach($this->steps as $index => $s)
                    <button type="button" 
                            wire:click="jumpToStep({{ $index }})"
                            class="px-2.5 py-1 rounded transition-colors whitespace-nowrap {{ $currentStepIndex === $index ? 'bg-orange-500/20 text-orange-300 font-bold border border-orange-500/30' : 'text-slate-400 hover:text-white' }}">
                        Etapa {{ $index + 1 }}: {{ Str::limit($s->title, 20) }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Tarjeta Principal de la Etapa / Cuestionario -->
        <div class="bg-slate-900/90 border border-slate-700/60 rounded-2xl p-6 sm:p-8 shadow-2xl backdrop-blur space-y-6 relative overflow-hidden">
            
            <!-- Resplandor Neón de Fondo -->
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-orange-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <!-- Encabezado de la Etapa Activa -->
            <div class="flex items-center justify-between pb-4 border-b border-slate-800">
                <div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-mono-tech font-bold bg-orange-500/10 text-orange-400 border border-orange-500/20">
                        @if($this->currentStep->type === 'theory')
                            📖 TEORÍA DIDÁCTICA
                        @elseif($this->currentStep->type === 'quiz')
                            ❓ CUESTIONARIO EVALUATIVO
                        @elseif($this->currentStep->type === 'shortcut_challenge')
                            ⌨️ DESAFÍO DE ATAJO DE TECLADO
                        @elseif($this->currentStep->type === 'interactive_calc')
                            📐 PRÁCTICA CON CALCULADORA
                        @endif
                    </span>
                    <h3 class="text-xl sm:text-2xl font-extrabold text-white tracking-tight mt-2">
                        {{ $this->currentStep->title }}
                    </h3>
                </div>
            </div>

            <!-- CONTENIDO SEGÚN TIPO DE ETAPA -->

            <!-- 1. TIPO TEORÍA -->
            @if($this->currentStep->type === 'theory')
                <div class="space-y-4">
                    <div class="text-sm text-slate-200 leading-relaxed bg-slate-950/80 p-5 rounded-xl border border-slate-800 space-y-3 prose prose-invert max-w-none">
                        {!! $this->currentStep->content !!}
                    </div>

                    <div class="pt-4 flex justify-end">
                        <button type="button" 
                                wire:click="submitAnswer('entendido')"
                                class="px-6 py-3 rounded-xl bg-gradient-to-r from-orange-500 to-amber-600 hover:from-orange-600 hover:to-amber-700 text-white font-mono-tech font-bold text-xs uppercase tracking-wider shadow-lg shadow-orange-500/20 transition-all flex items-center gap-2">
                            <span>COMPRENDIDO — CONTINUAR A LA EVALUACIÓN</span>
                            <span>➔</span>
                        </button>
                    </div>
                </div>

            <!-- 2. TIPO CUESTIONARIO DE OPCIÓN MÚLTIPLE O DESAFÍO -->
            @elseif($this->currentStep->type === 'quiz' || $this->currentStep->type === 'shortcut_challenge')
                <div class="space-y-6">
                    
                    <!-- Pregunta del Cuestionario -->
                    <div class="p-5 rounded-xl bg-slate-950 border border-slate-800 space-y-2">
                        <span class="text-xs font-mono-tech font-bold text-orange-400 uppercase tracking-wider block">PREGUNTA DE EVALUACIÓN:</span>
                        <h4 class="text-base sm:text-lg font-bold text-white leading-snug">
                            {{ $this->currentStep->question }}
                        </h4>
                    </div>

                    <!-- Opciones de Respuesta en Tarjetas Seleccionables -->
                    <div class="grid grid-cols-1 gap-3">
                        @foreach(($this->currentStep->options ?? []) as $opt)
                            @php
                                $isSelected = $selectedAnswer === $opt;
                            @endphp
                            <button type="button" 
                                    wire:click="submitAnswer('{{ addslashes($opt) }}')"
                                    class="w-full text-left p-4 rounded-xl border text-sm font-medium transition-all flex items-center justify-between group {{ $isSelected ? ($isCorrect ? 'bg-emerald-500/20 border-emerald-500 text-emerald-200 shadow-lg shadow-emerald-500/10' : 'bg-rose-500/20 border-rose-500 text-rose-200 shadow-lg shadow-rose-500/10') : 'bg-slate-950 border-slate-800 text-slate-300 hover:border-orange-500/50 hover:bg-slate-800/60' }}">
                                <div class="flex items-center space-x-3">
                                    <span class="w-6 h-6 rounded-full border flex items-center justify-center text-xs font-mono-tech font-bold {{ $isSelected ? ($isCorrect ? 'border-emerald-400 bg-emerald-500/30 text-emerald-300' : 'border-rose-400 bg-rose-500/30 text-rose-300') : 'border-slate-700 text-slate-500 group-hover:border-orange-400 group-hover:text-orange-400' }}">
                                        {{ chr(65 + $loop->index) }}
                                    </span>
                                    <span>{{ $opt }}</span>
                                </div>
                                @if($isSelected)
                                    <span class="text-base font-bold font-mono-tech">
                                        {{ $isCorrect ? '✓ CORRECTO' : '✗ REPETIR' }}
                                    </span>
                                @endif
                            </button>
                        @endforeach
                    </div>

                    <!-- Caja de Retroalimentación Pedagógica -->
                    @if($isAnswered)
                        <div class="p-4 rounded-xl border {{ $isCorrect ? 'bg-emerald-500/10 border-emerald-500/30 text-emerald-300' : 'bg-rose-500/10 border-rose-500/30 text-rose-300' }} text-xs space-y-1 animate-fadeIn">
                            <strong class="font-bold flex items-center gap-1 font-mono-tech text-sm {{ $isCorrect ? 'text-emerald-400' : 'text-rose-400' }}">
                                {{ $isCorrect ? '🎉 ¡RESPUESTA CORRECTA!' : '⚠️ RESPUESTA INCORRECTA' }}
                            </strong>
                            <p class="leading-relaxed opacity-95 text-xs">{{ $feedbackMessage }}</p>
                        </div>
                    @endif

                </div>

            <!-- 3. TIPO PRÁCTICA CON CALCULADORA INTERACTIVA -->
            @elseif($this->currentStep->type === 'interactive_calc')
                <div class="space-y-6">
                    <div class="p-4 rounded-xl bg-slate-950 border border-slate-800 text-xs text-slate-300">
                        <strong class="text-orange-400 font-mono-tech block mb-1">CONSIGNA PRÁCTICA:</strong>
                        <p>{{ $this->currentStep->question }}</p>
                    </div>

                    <!-- Calculadora Integrada -->
                    @livewire('toolbox.fold-calculator')

                    <div class="pt-2 flex justify-end">
                        <button type="button" 
                                wire:click="submitAnswer('calculadora_completada')"
                                class="px-6 py-3 rounded-xl bg-gradient-to-r from-orange-500 to-amber-600 hover:from-orange-600 text-white font-mono-tech font-bold text-xs uppercase tracking-wider shadow-lg shadow-orange-500/20 transition-all flex items-center gap-2">
                            <span>PRÁCTICA FINALIZADA — SIGUIENTE ETAPA</span>
                            <span>➔</span>
                        </button>
                    </div>
                </div>
            @endif

            <!-- BARRA DE NAVEGACIÓN INFERIOR (ANTERIOR / SIGUIENTE PASO) -->
            <div class="pt-6 border-t border-slate-800 flex items-center justify-between">
                <button type="button" 
                        wire:click="prevStep" 
                        @if($currentStepIndex === 0) disabled @endif
                        class="px-4 py-2.5 rounded-xl border border-slate-800 bg-slate-950 text-xs font-mono-tech font-bold text-slate-400 hover:text-white hover:border-slate-700 disabled:opacity-40 disabled:cursor-not-allowed transition-all">
                    ⬅ ETAPA ANTERIOR
                </button>

                @if($isAnswered && $isCorrect)
                    <button type="button" 
                            wire:click="nextStep"
                            class="px-6 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-slate-950 font-mono-tech font-extrabold text-xs uppercase tracking-wider shadow-lg shadow-emerald-500/20 transition-all flex items-center gap-2">
                        <span>SIGUIENTE ETAPA</span>
                        <span>➔</span>
                    </button>
                @else
                    <span class="text-xs font-mono-tech text-slate-500 italic">
                        Responde el cuestionario correctamente para avanzar
                    </span>
                @endif
            </div>

        </div>
    @else
        <div class="bg-slate-900 border border-slate-800 rounded-xl p-12 text-center text-slate-400">
            No hay pasos registrados para esta lección.
        </div>
    @endif

</div>
