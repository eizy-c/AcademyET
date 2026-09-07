<!-- Tabla de Tornillería y Código de Colores de Espesores -->
<div class="space-y-6">
    
    <!-- Seccion 1: Código Oficial de Colores por Espesor de Lámina -->
    <div class="bg-slate-900 border border-slate-800 rounded-xl p-6 shadow-xl">
        <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-800">
            <div>
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <span class="text-sky-400 font-mono-tech">🎨</span> Código de Colores para Espesor de Lámina (AutoCAD / Plasma CNC)
                </h3>
                <p class="text-xs text-slate-400 mt-1">Colores requeridos en las polilíneas de AutoCAD para identificar el calibre del material a cortar</p>
            </div>
            <span class="px-2.5 py-1 rounded-md text-xs font-mono-tech font-bold bg-sky-500/10 text-sky-400 border border-sky-500/20">
                CAPAS DE CORTE
            </span>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-7 gap-3">
            @foreach($colorCodes as $code)
                <div class="bg-slate-950 border border-slate-800 rounded-lg p-3 text-center transition-all hover:border-slate-700">
                    <div class="w-full h-3 rounded-full mb-2.5 shadow-inner" style="background-color: {{ $code['color'] }}"></div>
                    <span class="block text-sm font-extrabold font-mono-tech text-white">{{ $code['thickness'] }}</span>
                    <span class="block text-xs font-bold font-mono-tech mt-0.5" style="color: {{ $code['color'] }}">{{ $code['name'] }}</span>
                    <span class="block text-[10px] text-slate-400 mt-1 leading-tight">{{ $code['usage'] }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Sección 2: Tabla de Tornillería y Diámetros de Orificio -->
    <div class="bg-slate-900 border border-slate-800 rounded-xl p-6 shadow-xl">
        <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-800">
            <div>
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <span class="text-amber-500 font-mono-tech">🔩</span> Tabla de Conteo de Tornillería y Orificios
                </h3>
                <p class="text-xs text-slate-400 mt-1">Cálculo de radios y diámetros para perforaciones en chapa según tornillo a instalar</p>
            </div>
            <span class="px-2.5 py-1 rounded-md text-xs font-mono-tech font-bold bg-amber-500/10 text-amber-400 border border-amber-500/20">
                NORMAS DE MONTAJE
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs font-mono-tech">
                <thead class="bg-slate-950 text-slate-400 uppercase tracking-wider text-[11px]">
                    <tr>
                        <th class="p-3 rounded-l-lg">Tornillo</th>
                        <th class="p-3">Radio Hueco (SketchUp)</th>
                        <th class="p-3">Diámetro Hueco (Corte)</th>
                        <th class="p-3 rounded-r-lg">Material Recomendado</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 text-slate-200">
                    @foreach($screwsData as $screw => $info)
                        <tr class="hover:bg-slate-800/30 transition-colors">
                            <td class="p-3 font-extrabold text-orange-400 text-sm">{{ $screw }}</td>
                            <td class="p-3 text-amber-300 font-bold">{{ $info['radius'] }}</td>
                            <td class="p-3 text-emerald-400 font-bold">{{ $info['diameter'] }}</td>
                            <td class="p-3 text-slate-300">{{ $info['material'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Criterio de Selección de Material de Tornillos -->
        <div class="mt-5 p-4 rounded-xl bg-slate-950 border border-slate-800 text-xs space-y-2 text-slate-300">
            <strong class="text-orange-400 font-mono-tech block">CRITERIOS DE SELECCIÓN DE MATERIAL DE TORNILLOS (MANUAL):</strong>
            <ul class="grid grid-cols-1 md:grid-cols-3 gap-3 text-[11px] list-disc list-inside">
                <li><strong class="text-white">Acero Inoxidable:</strong> Para tornillos expuestos a simple vista.</li>
                <li><strong class="text-white">Galvanizados:</strong> Para uniones internas no visibles.</li>
                <li><strong class="text-white">Hierro Negro:</strong> Solo cuando se van a soldar a la pieza (resiste mejor la soldadura).</li>
            </ul>
        </div>
    </div>

</div>
