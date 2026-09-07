<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Seeder principal para poblar el temario técnico del manual de Ecotechne.
 * Registra módulos, lecciones, reglas de taller y atajos de teclado de SketchUp y AutoCAD.
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
            'description' => 'Aprende el uso del espacio tridimensional (ejes X, Y, Z), configuración de barras de herramientas y atajos de teclado esenciales para el diseño metalmecánico.',
        ]);

        $m2 = Module::create([
            'title' => 'Módulo 2: Despieces y Exportación a AutoCAD',
            'slug' => 'despieces-autocad',
            'order' => 2,
            'description' => 'Metodología para desdoblar piezas 3D en plano 2D, exportación .dwg en proyección paralela y repaso con polilíneas para máquina de plasma CNC.',
        ]);

        $m3 = Module::create([
            'title' => 'Módulo 3: Planos de Doblez y Tolerancias de Plegado',
            'slug' => 'planos-doblez',
            'order' => 3,
            'description' => 'Fórmula del transportador (n - 180), acotado positivo/negativo según cara vista/oculta y reglas geométricas para dobladora CNC.',
        ]);

        $m4 = Module::create([
            'title' => 'Módulo 4: Tornillería y Especificaciones de Taller',
            'slug' => 'tornilleria-taller',
            'order' => 4,
            'description' => 'Conteo de tornillería por diámetro/radio de orificio y selección de material (Hierro negro, Galvanizado, Acero Inoxidable).',
        ]);

        $m5 = Module::create([
            'title' => 'Módulo 5: Principios de Manufactura y Ensamblaje',
            'slug' => 'principios-manufactura',
            'order' => 5,
            'description' => 'Reglas de corte, holgura entre piezas, límites de soldadura en tramo recto (máximo 20cm) y diseño asistido con correderas para instalación.',
        ]);

        $m6 = Module::create([
            'title' => 'Módulo 6: Taller Práctico de Accesorios Off-Road 4x4',
            'slug' => 'taller-practico-4x4',
            'order' => 6,
            'description' => 'Diseño paso a paso de parachoques delantero/trasero, racks de techo, estribos, barras de tiro, bases de winche y petos de protección.',
        ]);

        // 3. Lecciones del Módulo 1
        Lesson::create([
            'module_id' => $m1->id,
            'title' => 'Entorno 3D y Configuración Inicial de SketchUp',
            'slug' => 'entorno-3d-sketchup',
            'order' => 1,
            'summary' => 'Identificación de ejes espaciales (X=Rojo, Y=Verde, Z=Azul) y activación de barras de herramientas.',
            'content' => 'Al abrir SketchUp trabajaremos en milímetros. Activaremos las barras "Conjunto grande de herramientas", "Estilos", "Vistas" y "Sólidos", desactivando "Primeros pasos".',
            'workshop_rules' => [
                'eje_x' => 'Izquierda y derecha (Línea roja)',
                'eje_y' => 'Adelante y atrás (Línea verde)',
                'eje_z' => 'Arriba y abajo (Línea azul)',
                'unidad' => 'Milímetros (1cm = 10mm)',
            ],
            'shortcuts' => [
                ['key' => 'BARRA ESPACIADORA', 'action' => 'Seleccionar entidades'],
                ['key' => 'B', 'action' => 'Bote de pintura (Materiales y colores)'],
                ['key' => 'E', 'action' => 'Borrar (Eraser)'],
                ['key' => 'R', 'action' => 'Dibuja rectángulos (Ejemplo teclado: 50;25)'],
                ['key' => 'L', 'action' => 'Lápiz / Líneas (Bloqueo con Flechas de dirección)'],
                ['key' => 'C', 'action' => 'Círculo (Define radio)'],
                ['key' => 'P', 'action' => 'Extruir / Empujar-Tirar (Push/Pull)'],
                ['key' => 'Q', 'action' => 'Girar / Rotar piezas'],
                ['key' => 'F', 'action' => 'Offset / Equidistancia'],
                ['key' => 'O', 'action' => 'Orbitar cámara 360°'],
            ],
            'model_3d_path' => null,
        ]);

        // 4. Lecciones del Módulo 2
        Lesson::create([
            'module_id' => $m2->id,
            'title' => 'Despieces en Plano y Código de Colores de Espesores',
            'slug' => 'despieces-codigo-colores',
            'order' => 1,
            'summary' => 'Técnica de desdoblado en 3D con la herramienta Girar (Q) y asignación del código de colores oficial de espesor de lámina.',
            'content' => 'Una vez terminado el modelo 3D, se agrupan las caras plegables y se rotan con Girar (Q) hasta aplanar la pieza. Luego se exporta en Vista Planta con Cámara Paralela a formato .dwg.',
            'workshop_rules' => [
                'inicio_corte' => 'Mínimo 5mm de entrada para evitar imperfecciones en el plasma',
                'dobleces_guia' => 'Líneas de 4mm o 5mm como guía visual para el doblador',
                'hueco_minimo' => 'Espacio mínimo entre agujeros adyacentes: 3.5mm',
                'laminado' => 'Separación mínima entre piezas en nido: 5mm a 7mm',
            ],
            'shortcuts' => [
                ['key' => 'Azul', 'action' => 'Espesor de Lámina 2.0 mm'],
                ['key' => 'Rojo', 'action' => 'Espesor de Lámina 2.5 mm'],
                ['key' => 'Amarillo', 'action' => 'Espesor de Lámina 3.0 mm'],
                ['key' => 'Verde', 'action' => 'Espesor de Lámina 4.0 mm'],
                ['key' => 'Naranja', 'action' => 'Espesor de Lámina 5.0 mm'],
                ['key' => 'Magenta', 'action' => 'Espesor de Lámina 6.0 mm'],
                ['key' => 'Cyan', 'action' => 'Espesor de Lámina 12.0 mm'],
            ],
            'model_3d_path' => null,
        ]);

        // 5. Lección del Módulo 3
        Lesson::create([
            'module_id' => $m3->id,
            'title' => 'Cálculo de Ángulos (n - 180) y Viabilidad en "U"',
            'slug' => 'calculo-angulos-viabilidad-u',
            'order' => 1,
            'summary' => 'Medición de dobleces en 3D con el Transportador de SketchUp y validación de colisiones contra la uña de la dobladora.',
            'content' => 'Al medir el ángulo interno n con el transportador, se aplica la fórmula (n - 180). Los dobleces por el lado trasero ("feo") se anotan positivos (+) y los delanteros negativos (-). En dobleces en U, la base debe ser mayor o igual a las alas.',
            'workshop_rules' => [
                'pestana_minima' => '15mm (prisma estándar de la máquina dobladora)',
                'distancia_dobleces_90' => '27mm mínimo entre dobleces a 90°',
                'angulo_maximo' => 'Máximo 100° en máquina (grados mayores requieren acanalado previo)',
                'separacion_hueco_doblez' => 'Distancia mínima de 10mm entre un doblez y cualquier orificio',
            ],
            'shortcuts' => [
                ['key' => 'Transportador', 'action' => 'Mide ángulos en el 3D de SketchUp'],
                ['key' => 'Fórmula Doblez', 'action' => 'Resultado = n - 180'],
            ],
            'model_3d_path' => null,
        ]);

        // 6. Lección del Módulo 4
        Lesson::create([
            'module_id' => $m4->id,
            'title' => 'Tabla de Tornillería y Selección de Materiales',
            'slug' => 'tabla-tornilleria-materiales',
            'order' => 1,
            'summary' => 'Cálculo de diámetros de orificios en chapa y especificaciones de tornillería según exposición intemperie.',
            'content' => 'Cada orificio en SketchUp corresponde a un radio/diámetro estándar. La tornillería vista debe ser Acero Inoxidable, la interna Galvanizada y la soldada de Hierro Negro.',
            'workshop_rules' => [
                'tornillo_6mm' => 'Radio hueco: 3.0mm | Diámetro: 6.0mm',
                'tornillo_8mm' => 'Radio hueco: 4.0mm | Diámetro: 8.0mm',
                'tornillo_3/8' => 'Radio hueco: 5.5mm | Diámetro: 11.0mm',
                'tornillo_7/16' => 'Radio hueco: 6.0mm | Diámetro: 12.0mm',
                'tornillo_1/2' => 'Radio hueco: 7.0mm | Diámetro: 14.0mm',
                'sobrepaso' => 'El tornillo debe sobresalir mínimo 5mm después de la tuerca',
            ],
            'shortcuts' => [],
            'model_3d_path' => null,
        ]);

        // 7. Lección del Módulo 6 (Taller Práctico)
        Lesson::create([
            'module_id' => $m6->id,
            'title' => 'Diseño de Parachoques Delantero y Bumper Winch',
            'slug' => 'parachoques-delantero-bumper-winch',
            'order' => 1,
            'summary' => 'Toma de medidas X,Y,Z en vehículo real mediante plomada/tirro y diseño de base reforzada para winche.',
            'content' => 'Levantamiento topográfico de la línea de carrocería proyectando puntos al suelo con plomada. Construcción de base de winche con pliegues a 45° y pletina de traba inferior fijada al chasis.',
            'workshop_rules' => [
                'winche_refuerzo' => 'Pliegues a 45° para evitar flexión vertical',
                'fijacion' => 'Anclaje directo a largueros del chasis',
                'holgura' => 'Tolerancia de vibración de carrocería',
            ],
            'shortcuts' => [
                ['key' => 'Plomada + Tirro', 'action' => 'Proyección vertical de puntos X,Y al piso'],
                ['key' => 'Metro', 'action' => 'Medición de alturas Z desde el piso'],
            ],
            'model_3d_path' => null,
        ]);
    }
}
