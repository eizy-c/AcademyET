# Acadenvit — Plataforma Web Educativa e Interactiva de Diseño 3D & Fabricación Metalmecánica Off-Road (Ecotechne)

Plataforma educativa para el curso técnico: **"Diseño 3D en SketchUp y AutoCAD para Fabricación Metalmecánica y Accesorios Off-Road"**.

A diferencia de los modelos de aprendizaje pasivo en video, esta aplicación prioriza la interacción didáctica mediante **calculadoras de taller**, **validadores geométricos en tiempo real** y **visualización 3D WebGL** de piezas metálicas desdobladas y ensambladas.

---

## 🛠️ STACK TECNOLÓGICO

- **Backend / Reactividad:** Laravel 12 + Livewire v4.
- **Frontend / UI:** Tailwind CSS v4 (Estética industrial/ingeniería oscura, colores Slate/Amber/Orange, fuentes monoespaciadas para cotas numéricas).
- **Interactividad / 3D:** Alpine.js + Google `<model-viewer>` Web Component para renderizado 3D `.glb`.
- **Base de Datos:** SQLite / MySQL relacional ligera para el seguimiento del progreso de alumnos.

---

## 📂 ESTRUCTURA DE ARQUITECTURA DE CARPETAS

```text
f:/SOFTWARE/TEMPLADE/Acadenvit/
├── app/
│   ├── Http/
│   │   └── Livewire/
│   │       ├── CourseDashboard.php         // Dashboard principal y control de avance del alumno
│   │       ├── LessonViewer.php            // Renderizado de lecciones y reglas técnicas
│   │       ├── Toolbox/
│   │       │   ├── FoldCalculator.php      // Calculadora de grados (n - 180) y signos +/-
│   │       │   ├── UBendValidator.php      // Validador geométrico de plegado en U y colisiones
│   │       │   └── ScrewCalculator.php     // Tabla de tornillería y código de colores de espesores
│   │       └── Viewers/
│   │           └── ModelViewer3d.php       // Visor 3D interactivo WebGL con <model-viewer>
│   └── Models/
│       ├── Module.php                      // Módulo pedagógico (Fundamentos, Despieces, Planos)
│       ├── Lesson.php                      // Lección individual con metadatos técnicos
│       └── UserProgress.php                // Progreso de lecciones por usuario
├── database/
│   ├── migrations/
│   │   ├── 2026_09_07_000001_create_modules_table.php
│   │   ├── 2026_09_07_000002_create_lessons_table.php
│   │   └── 2026_09_07_000003_create_user_progress_table.php
│   └── seeders/
│       └── CourseSeeder.php                // Carga inicial del temario Ecotechne
├── resources/
│   ├── views/
│   │   ├── components/layouts/
│   │   │   └── app.blade.php               // Layout industrial oscuro (Inter & JetBrains Mono)
│   │   └── livewire/
│   │       ├── course-dashboard.blade.php
│   │       ├── lesson-viewer.blade.php
│   │       ├── toolbox/
│   │       │   ├── fold-calculator.blade.php
│   │       │   ├── u-bend-validator.blade.php
│   │       │   └── screw-calculator.blade.php
│   │       └── viewers/
│   │           └── model-viewer-3d.blade.php
│   └── js/
│       └── app.js                          // Web components y assets
└── routes/
    └── web.php                             // Rutas públicas de la plataforma
```

---

## 🗄️ ESQUEMA DE BASE DE DATOS

### 1. Tabla `modules`
| Campo | Tipo | Descripción |
|---|---|---|
| `id` | BigIncrements | Identificador único del módulo |
| `title` | String | Título didáctico (ej: "Módulo 1: Fundamentos 3D") |
| `slug` | String (Unique) | Slug URL amigable |
| `order` | Integer | Orden de secuencia pedagógica |
| `description` | Text | Descripción del módulo |

### 2. Tabla `lessons`
| Campo | Tipo | Descripción |
|---|---|---|
| `id` | BigIncrements | Identificador único de la lección |
| `module_id` | ForeignId | Relación con la tabla `modules` |
| `title` | String | Nombre de la lección |
| `slug` | String (Unique) | Slug único de lección |
| `order` | Integer | Número correlativo |
| `summary` | Text | Resumen introductorio |
| `content` | Text | Explicación teórica y procedimiento de taller |
| `workshop_rules` | JSON | Matriz de tolerancias geométricas y holguras |
| `shortcuts` | JSON | Lista de comandos de teclado de SketchUp/AutoCAD |
| `model_3d_path` | String (Nullable) | Ruta relativa al archivo 3D `.glb` |

### 3. Tabla `user_progress`
| Campo | Tipo | Descripción |
|---|---|---|
| `id` | BigIncrements | Identificador único de progreso |
| `user_id` | ForeignId | Relación con el alumno (`users.id`) |
| `lesson_id` | ForeignId | Relación con la lección (`lessons.id`) |
| `completed` | Boolean | Estado (true = completada, false = pendiente) |
| `completed_at` | Timestamp | Fecha y hora de finalización |

---

## 📐 LÓGICAS Y ECUACIONES DE TALLER INTEGRADAS

### 1. Calculadora de Grados de Doblez: Fórmula `(n - 180)`
- **Entrada:** Ángulo $n$ medido con el transportador 3D en SketchUp.
- **Ecuación:** $\text{Resultado} = |n - 180|$
- **Cota en AutoCAD:**
  - **Lado Posterior / "Feo":** Cota **POSITIVA (+)**
  - **Lado Frente / Vista:** Cota **NEGATIVA (-)**
- **Restricción física:** Alerta en rojo si la cota es superior a **100°** (límite físico de la dobladora de prensa antes de acanalar).

### 2. Validador Geométrico de Plegado en "U" (Canal)
- **Entradas:** Ala A ($\text{mm}$), Base Central ($\text{mm}$), Ala B ($\text{mm}$).
- **Regla de Pestaña Mínima:** $Ala \, A \ge 15\text{mm}$ y $Ala \, B \ge 15\text{mm}$ (para trabajar con prisma estándar).
- **Regla de Colisión:** $Base \, Central \ge Ala \, A$ y $Base \, Central \ge Ala \, B$.
  - Si no se cumple, la uña de la dobladora chocará contra las alas antes de llegar a los 90°. Recomienda asimetría de alas o acanalado.

### 3. Matriz de Tornillería y Orificios en Chapa
| Tornillo | Radio Hueco (SketchUp) | Diámetro Hueco (Corte) | Material Recomendado |
|---|---|---|---|
| 6 mm | 3.0 mm | 6.0 mm | Hierro Negro / Galvanizado |
| 8 mm | 4.0 mm | 8.0 mm | Galvanizado / Acero Inoxidable |
| 3/8" | 5.5 mm | 11.0 mm | Galvanizado Grado 5 / 8 |
| 7/16" | 6.0 mm | 12.0 mm | Galvanizado (Chasis) |
| 1/2" | 7.0 mm | 14.0 mm | Acero Inoxidable / Alta Resistencia |

### 4. Código Oficial de Colores para Espesores de Lámina (Plasma CNC)
- 🔵 **Azul:** 2.0 mm
- 🔴 **Rojo:** 2.5 mm
- 🟡 **Amarillo:** 3.0 mm
- 🟢 **Verde:** 4.0 mm
- 🟠 **Naranja:** 5.0 mm
- 🟣 **Magenta:** 6.0 mm
- 🩵 **Cyan:** 12.0 mm

---

## 🚦 RUTAS REGISTRADAS

- `GET /` — Dashboard principal con sidebar de lecciones, barra de progreso y pestañas interactivas (`course.dashboard`).
- `GET /leccion/{lessonSlug}` — Acceso directo a una lección específica por slug (`course.lesson`).

---

## 🏷️ HITOS Y HISTORIAL DE VERSIONES (GIT RELEASES)

### Release `v0.1.0-alpha` (Hito MVP Inicial)
- Inicialización de la arquitectura Laravel + Livewire + Tailwind CSS + `<model-viewer>`.
- Implementación del Dashboard interactivo con progreso en tiempo real del estudiante.
- Creación de los componentes de herramientas de taller: `FoldCalculator`, `UBendValidator`, `ScrewCalculator` y `ModelViewer3d`.
- Carga completa del temario del manual Ecotechne mediante `CourseSeeder`.
- Documentación integral y comentarios técnicos en español.
