<!DOCTYPE html>
<html lang="es" class="dark h-full bg-slate-950 text-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Acadenvit — Curso de Diseño 3D & Fabricación Metalmecánica 4x4' }}</title>

    <!-- Tipografía Industrial: Inter & JetBrains Mono para datos numéricos y cotas -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Carga de Tailwind CSS & JS con Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Importación de Google <model-viewer> para visualización 3D interactiva WebGL -->
    <script type="module" src="https://ajax.googleapis.com/ajax/libs/model-viewer/3.4.0/model-viewer.min.js"></script>

    <!-- Estilos en línea para tipografías industriales y temas oscuros -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .font-mono-tech {
            font-family: 'JetBrains Mono', monospace;
        }
        /* Custom Scrollbar Industrial */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #090d16;
        }
        ::-webkit-scrollbar-thumb {
            background: #1e293b;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #334155;
        }
    </style>

    @livewireStyles
</head>
<body class="h-full flex flex-col antialiased bg-slate-950 text-slate-100 selection:bg-orange-500 selection:text-white">

    <!-- Encabezado Superior (Header Industrial) -->
    <header class="bg-slate-900/90 border-b border-slate-800 backdrop-blur sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            
            <!-- Logotipo & Marca -->
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-orange-500 to-amber-600 flex items-center justify-center font-bold text-white shadow-lg shadow-orange-500/20 font-mono-tech text-xl border border-orange-400/30">
                    3D
                </div>
                <div>
                    <h1 class="text-lg font-extrabold tracking-tight text-white flex items-center gap-2">
                        ACADENVIT <span class="text-xs px-2 py-0.5 rounded bg-orange-500/20 text-orange-400 border border-orange-500/30 font-mono-tech font-semibold">ECOTECHNE 4X4</span>
                    </h1>
                    <p class="text-xs text-slate-400 font-medium">Plataforma Técnica de Diseño Metalmecánico & CAD</p>
                </div>
            </div>

            <!-- Acciones de Cabecera -->
            <div class="flex items-center space-x-4">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span> MVP v0.1.0-alpha
                </span>
            </div>

        </div>
    </header>

    <!-- Contenido Principal -->
    <main class="flex-1 flex flex-col overflow-hidden">
        {{ $slot }}
    </main>

    @livewireScripts
</body>
</html>
