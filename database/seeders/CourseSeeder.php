<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\Lesson;
use App\Models\LessonStep;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Seeder principal para poblar el temario técnico del manual de Ecotechne.
 * Incluye lecciones paso a paso con cuestionarios e interacciones didácticas.
 */
class CourseSeeder extends Seeder
{
    /**
     * Ejecuta las semillas en la base de datos.
     */
    public function run(): void
    {
        // 1. Crear usuario Administrador / Instructor por defecto
        $user = User::firstOrCreate(
            ['email' => 'admin@ecotechne.com'],
            [
                'name' => 'Instructor Ecotechne',
                'password' => bcrypt('password123'),
            ]
        );

        // 2. Módulos Temáticos
        $m1 = Module::create([
            'title' => 'Módulo 1: Fundamentos 3D y Herramientas de SketchUp',
            'slug' => 'fundamentos-sketchup',
            'order' => 1,
            'description' => 'Espacio tridimensional (ejes X, Y, Z), herramientas de dibujo y atajos de teclado esenciales.',
        ]);

        $m2 = Module::create([
            'title' => 'Módulo 2: Despieces y Exportación a AutoCAD',
            'slug' => 'despieces-autocad',
            'order' => 2,
            'description' => 'Desdoblado de piezas 3D en plano 2D, exportación .dwg y código oficial de colores de corte plasma.',
        ]);

        $m3 = Module::create([
            'title' => 'Módulo 3: Planos de Doblez y Tolerancias de Plegado',
            'slug' => 'planos-doblez',
            'order' => 3,
            'description' => 'Fórmula del transportador (n - 180), cotas positivo/negativo y viabilidad en plegadora de prensa.',
        ]);

        $m4 = Module::create([
            'title' => 'Módulo 4: Tornillería y Especificaciones de Taller',
            'slug' => 'tornilleria-taller',
            'order' => 4,
            'description' => 'Conteo de tornillería por diámetro/radio de orificio y selección de material (Hierro negro, Galvanizado, Inox).',
        ]);

        $m5 = Module::create([
            'title' => 'Módulo 5: Principios de Manufactura y Ensamblaje',
            'slug' => 'principios-manufactura',
            'order' => 5,
            'description' => 'Reglas de corte, holgura entre piezas, límites de soldadura en tramo recto (máximo 20cm) e instalación con correderas.',
        ]);

        $m6 = Module::create([
            'title' => 'Módulo 6: Taller Práctico de Accesorios Off-Road 4x4',
            'slug' => 'taller-practico-4x4',
            'order' => 6,
            'description' => 'Diseño paso a paso de parachoques delantero/trasero, racks de techo, estribos, barras de tiro, bases de winche y petos.',
        ]);

        // ==========================================
        // LECCIÓN 1: Entorno 3D y Ejes Espaciales
        // ==========================================
        $l1 = Lesson::create([
            'module_id' => $m1->id,
            'title' => 'Entorno 3D y Ejes Espaciales (X, Y, Z)',
            'slug' => 'entorno-3d-sketchup',
            'order' => 1,
            'summary' => 'Identificación del sistema de ejes 3D y configuración de barras de herramientas.',
            'content' => 'Al diseñar accesorios para camionetas 4x4 trabajaremos siempre en milímetros (1cm = 10mm). SketchUp utiliza 3 ejes espaciales: X (Línea roja = Izquierda/Derecha), Y (Línea verde = Adelante/Atrás), y Z (Línea azul = Arriba/Abajo).',
            'workshop_rules' => [
                'eje_x' => 'Izquierda y derecha (Línea roja)',
                'eje_y' => 'Adelante y atrás (Línea verde)',
                'eje_z' => 'Arriba y abajo (Línea azul)',
                'unidad' => 'Milímetros (1cm = 10mm)',
            ],
            'shortcuts' => [
                ['key' => 'BARRA ESPACIADORA', 'action' => 'Seleccionar'],
                ['key' => 'R', 'action' => 'Rectángulo'],
                ['key' => 'L', 'action' => 'Lápiz / Líneas'],
                ['key' => 'P', 'action' => 'Extruir (Push/Pull)'],
                ['key' => 'Q', 'action' => 'Girar'],
                ['key' => 'O', 'action' => 'Orbitar 360°'],
            ],
            'model_3d_path' => null,
        ]);

        // Pasos Guiados y Cuestionarios de Lección 1
        LessonStep::create([
            'lesson_id' => $l1->id,
            'step_number' => 1,
            'title' => 'Etapa 1: Los 3 Ejes Espaciales en SketchUp',
            'type' => 'theory',
            'content' => 'Al abrir SketchUp verás tres líneas de color que se cruzan en el origen: 
<br><br>
• <strong class="text-rose-400">Eje X (Línea Roja):</strong> Representa el ancho del vehículo (Izquierda / Derecha).
<br>
• <strong class="text-emerald-400">Eje Y (Línea Verde):</strong> Representa el largo o profundidad (Adelante / Atrás).
<br>
• <strong class="text-sky-400">Eje Z (Línea Azul):</strong> Representa la altura desde el piso (Arriba / Abajo).',
            'explanation' => 'Es crucial no confundir los ejes para no deformar las medidas de la camioneta.',
        ]);

        LessonStep::create([
            'lesson_id' => $l1->id,
            'step_number' => 2,
            'title' => 'Etapa 2: Cuestionario sobre los Ejes Espaciales',
            'type' => 'quiz',
            'question' => '¿Qué eje espacial de SketchUp representa la ALTURA (Arriba y Abajo) desde el piso?',
            'options' => [
                'Eje X (Línea Roja)',
                'Eje Y (Línea Verde)',
                'Eje Z (Línea Azul)',
                'Eje W (Línea Amarilla)'
            ],
            'correct_answer' => 'Eje Z (Línea Azul)',
            'explanation' => '¡Correcto! El eje Z (línea azul) controla la dimensión vertical y altura de los modelos en SketchUp.',
        ]);

        LessonStep::create([
            'lesson_id' => $l1->id,
            'step_number' => 3,
            'title' => 'Etapa 3: Desafío de Atajo de Teclado',
            'type' => 'shortcut_challenge',
            'question' => '¿Cuál es la tecla rápida para activar la herramienta SELECCIONAR en SketchUp?',
            'options' => ['Barra Espaciadora', 'Tecla S', 'Tecla Enter', 'Tecla Tab'],
            'correct_answer' => 'Barra Espaciadora',
            'explanation' => '¡Excelente! La Barra Espaciadora es el atajo universal para seleccionar entidades.',
        ]);

        // ==========================================
        // LECCIÓN 2: Despieces y Código de Colores
        // ==========================================
        $l2 = Lesson::create([
            'module_id' => $m2->id,
            'title' => 'Despieces en Plano y Código de Colores de Espesores',
            'slug' => 'despieces-codigo-colores',
            'order' => 1,
            'summary' => 'Técnica de desdoblado con Girar (Q) y asignación del código oficial de colores de lámina.',
            'content' => 'Una vez terminado el accesorio en 3D, agruparás las caras que se pueden doblar juntas y las desdoblarás con la herramienta Girar (Q) hasta dejarlas completamente en plano.',
            'workshop_rules' => [
                'inicio_corte' => 'Mínimo 5mm de entrada para evitar imperfecciones',
                'dobleces_guia' => 'Líneas de 4mm o 5mm como guía para el doblador',
                'hueco_minimo' => 'Espacio mínimo entre agujeros: 3.5mm',
            ],
            'shortcuts' => [
                ['key' => 'Azul', 'action' => 'Espesor 2.0 mm'],
                ['key' => 'Rojo', 'action' => 'Espesor 2.5 mm'],
                ['key' => 'Amarillo', 'action' => 'Espesor 3.0 mm'],
                ['key' => 'Verde', 'action' => 'Espesor 4.0 mm'],
                ['key' => 'Naranja', 'action' => 'Espesor 5.0 mm'],
                ['key' => 'Magenta', 'action' => 'Espesor 6.0 mm'],
                ['key' => 'Cyan', 'action' => 'Espesor 12.0 mm'],
            ],
            'model_3d_path' => null,
        ]);

        LessonStep::create([
            'lesson_id' => $l2->id,
            'step_number' => 1,
            'title' => 'Etapa 1: Código Oficial de Colores para Plasma CNC',
            'type' => 'theory',
            'content' => 'Para mandar a cortar las piezas en la máquina de plasma CNC, se debe asignar un código de colores específico en la polilínea de AutoCAD:
<br><br>
• <strong class="text-blue-400">Azul:</strong> Lámina 2.0 mm
<br>
• <strong class="text-red-400">Rojo:</strong> Lámina 2.5 mm
<br>
• <strong class="text-yellow-400">Amarillo:</strong> Lámina 3.0 mm (Racks y Estribos)
<br>
• <strong class="text-green-400">Verde:</strong> Lámina 4.0 mm (Parachoques)
<br>
• <strong class="text-orange-400">Naranja:</strong> Lámina 5.0 mm (Refuerzos)
<br>
• <strong class="text-purple-400">Magenta:</strong> Lámina 6.0 mm (Bases de Winche y Barras de Tiro)
<br>
• <strong class="text-cyan-400">Cyan:</strong> Lámina 12.0 mm (Ganchos de rescate)',
            'explanation' => 'El código de colores le indica al operador del corte plasma qué tipo de lámina colocar en la mesa de trabajo.',
        ]);

        LessonStep::create([
            'lesson_id' => $l2->id,
            'step_number' => 2,
            'title' => 'Etapa 2: Cuestionario sobre Código de Colores',
            'type' => 'quiz',
            'question' => '¿De qué color debe marcarse la polilínea en AutoCAD para indicar una lámina de 4.0 mm de espesor?',
            'options' => [
                'Azul (2.0 mm)',
                'Amarillo (3.0 mm)',
                'Verde (4.0 mm)',
                'Magenta (6.0 mm)'
            ],
            'correct_answer' => 'Verde (4.0 mm)',
            'explanation' => '¡Correcto! El color Verde representa el espesor estándar de 4.0 mm para piezas de carrocería en Ecotechne.',
        ]);

        // ==========================================
        // LECCIÓN 3: Fórmula de Doblez (n - 180)
        // ==========================================
        $l3 = Lesson::create([
            'module_id' => $m3->id,
            'title' => 'Fórmula de Grados (n - 180) y Plegado en U',
            'slug' => 'calculo-angulos-viabilidad-u',
            'order' => 1,
            'summary' => 'Medición con transportador 3D y evaluación de colisiones en la plegadora.',
            'content' => 'Para obtener el ángulo que se anotará en el plano de AutoCAD, se mide el ángulo interno n con el transportador en SketchUp y se le resta 180°: (n - 180).',
            'workshop_rules' => [
                'pestana_minima' => '15mm (prisma estándar)',
                'distancia_dobleces_90' => '27mm mínimo entre dobleces a 90°',
                'angulo_maximo' => 'Máximo 100° en máquina',
            ],
            'shortcuts' => [],
            'model_3d_path' => null,
        ]);

        LessonStep::create([
            'lesson_id' => $l3->id,
            'step_number' => 1,
            'title' => 'Etapa 1: La Fórmula de Taller (n - 180)',
            'type' => 'theory',
            'content' => 'Al medir el ángulo $n$ con la herramienta Transportador en el 3D de SketchUp, debes aplicar la resta:
<br><br>
<div class="p-3 bg-slate-950 rounded-lg text-center font-mono-tech text-orange-400 text-lg font-bold">
    Resultado = (n - 180)
</div>
<br>
• Si el doblez es por la cara <strong>POSTERIOR (Lado "Feo" u Oculto)</strong> ➔ Cota <strong>POSITIVA (+)</strong>.
<br>
• Si el doblez es por la cara <strong>FRONTAL (Cara Vista / Frente)</strong> ➔ Cota <strong>NEGATIVA (-)</strong>.',
            'explanation' => 'El signo le indica al doblador si debe doblar la pieza hacia arriba o hacia abajo en la prensa.',
        ]);

        LessonStep::create([
            'lesson_id' => $l3->id,
            'step_number' => 2,
            'title' => 'Etapa 2: Cuestionario de Cálculo de Ángulo',
            'type' => 'quiz',
            'question' => 'Si mides un ángulo n = 146° en SketchUp por la cara POSTERIOR (lado feo), ¿qué cota anotarás en AutoCAD?',
            'options' => [
                '+34°',
                '-34°',
                '+146°',
                '-180°'
            ],
            'correct_answer' => '+34°',
            'explanation' => '¡Exacto! |146 - 180| = 34°. Al ser por el lado posterior (lado feo), la cota va POSITIVA (+34°).',
        ]);

        LessonStep::create([
            'lesson_id' => $l3->id,
            'step_number' => 3,
            'title' => 'Etapa 3: Práctica Interactiva con la Calculadora',
            'type' => 'interactive_calc',
            'question' => 'Utiliza la Calculadora de Doblez a continuación para verificar el resultado:',
            'explanation' => 'Prueba ingresar diferentes ángulos y cambiar entre cara vista y posterior.',
        ]);

    }
}
