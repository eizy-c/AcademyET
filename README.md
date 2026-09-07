# Acadenvit — Plataforma Web Educativa e Interactiva de Diseño 3D & Fabricación Metalmecánica Off-Road (Ecotechne)

Plataforma educativa interactiva para el curso técnico: **"Diseño 3D en SketchUp y AutoCAD para Fabricación Metalmecánica y Accesorios Off-Road"**.

La plataforma prioriza el **aprendizaje guiado paso a paso (modo wizard)** con teoría corta, cuestionarios evaluativos interactivos en cada lección, retroalimentación técnica inmediata, **calculadoras de taller**, **validadores geométricos de plegado** y **visualización 3D WebGL** de accesorios 4x4.

---

## 🛠️ STACK TECNOLÓGICO

- **Backend / Reactividad:** Laravel 12 + Livewire v4 (`#[Computed]`).
- **Frontend / UI:** Tailwind CSS v4 (Estética industrial/ingeniería oscura, colores Slate/Amber/Orange, fuentes monoespaciadas para cotas numéricas).
- **Interactividad / 3D:** Alpine.js + Google `<model-viewer>` Web Component para renderizado 3D `.glb`.
- **Base de Datos:** SQLite / MySQL relacional para seguimiento persistente de progreso del estudiante por paso y lección.

---

## 📂 ESTRUCTURA DE ARQUITECTURA DE CARPETAS

```text
f:/SOFTWARE/TEMPLADE/Acadenvit/
├── app/
│   ├── Http/
│   │   └── Livewire/
│   │       ├── CourseDashboard.php         // Dashboard principal y control de avance del alumno
│   │       ├── InteractiveLessonFlow.php   // Flujo guiado paso a paso con cuestionarios y retroalimentación
│   │       ├── LessonViewer.php            // Renderizado de lecciones y reglas técnicas
│   │       ├── Toolbox/
│   │       │   ├── FoldCalculator.php      // Calculadora de grados (n - 180) y cotas +/-
│   │       │   ├── UBendValidator.php      // Validador geométrico de plegado en U y colisiones
│   │       │   └── ScrewCalculator.php     // Tabla de tornillería y código de colores de espesores
│   │       └── Viewers/
│   │           └── ModelViewer3d.php       // Visor 3D interactivo WebGL con <model-viewer>
│   └── Models/
│       ├── Module.php                      // Módulo pedagógico (Fundamentos, Despieces, Planos)
│       ├── Lesson.php                      // Lección individual con metadatos técnicos
│       ├── LessonStep.php                  // Pasos secuenciales y cuestionarios por lección
│       ├── UserStepProgress.php            // Registro de respuestas y pasos completados
│       └── UserProgress.php                // Progreso global de lecciones por usuario
├── database/
│   ├── migrations/
│   │   ├── 2026_09_07_000001_create_modules_table.php
│   │   ├── 2026_09_07_000002_create_lessons_table.php
│   │   ├── 2026_09_07_000003_create_user_progress_table.php
│   │   ├── 2026_09_07_000004_create_lesson_steps_table.php
│   │   └── 2026_09_07_000005_create_user_step_progress_table.php
│   └── seeders/
│       └── CourseSeeder.php                // Carga inicial del temario y cuestionarios Ecotechne
├── resources/
│   ├── views/
│   │   ├── components/layouts/
│   │   │   └── app.blade.php               // Layout industrial oscuro (Inter & JetBrains Mono)
│   │   └── livewire/
│   │       ├── course-dashboard.blade.php
│   │       ├── interactive-lesson-flow.blade.php
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

### 1. Tabla `lesson_steps` (Pasos y Cuestionarios por Lección)
| Campo | Tipo | Descripción |
|---|---|---|
| `id` | BigIncrements | Identificador del paso |
| `lesson_id` | ForeignId | Relación con la tabla `lessons` |
| `step_number` | Integer | Número correlativo de la etapa |
| `title` | String | Título de la etapa (ej: "Etapa 2: Cuestionario sobre Ejes") |
| `type` | Enum | Tipo de etapa (`theory`, `quiz`, `shortcut_challenge`, `interactive_calc`) |
| `content` | Text | Texto explicativo corto en HTML/Markdown |
| `question` | String | Pregunta del cuestionario o consigna |
| `options` | JSON | Opciones de respuesta de selección |
| `correct_answer` | String | Respuesta correcta esperada |
| `explanation` | Text | Retroalimentación técnica al responder |

### 2. Tabla `user_step_progress` (Progreso de Pasos del Alumno)
| Campo | Tipo | Descripción |
|---|---|---|
| `id` | BigIncrements | Identificador único de progreso por paso |
| `user_id` | ForeignId | Relación con el alumno (`users.id`) |
| `lesson_step_id` | ForeignId | Relación con `lesson_steps.id` |
| `completed` | Boolean | Estado (true = aprobado, false = pendiente) |
| `user_answer` | String | Respuesta registrada por el estudiante |

---

## 📐 LÓGICAS Y ECUACIONES DE TALLER INTEGRADAS

### 1. Calculadora de Grados de Doblez: Fórmula `(n - 180)`
- **Entrada:** Ángulo $n$ medido con el transportador 3D en SketchUp.
- **Ecuación:** $\text{Resultado} = |n - 180|$
- **Cota en AutoCAD:**
  - **Lado Posterior / "Feo":** Cota **POSITIVA (+)**
  - **Lado Frente / Vista:** Cota **NEGATIVA (-)**
- **Restricción física:** Alerta en rojo si la cota es superior a **100°** (límite físico de la dobladora).

### 2. Validador Geométrico de Plegado en "U" (Canal)
- **Entradas:** Ala A ($\text{mm}$), Base Central ($\text{mm}$), Ala B ($\text{mm}$).
- **Regla de Pestaña Mínima:** $Ala \, A \ge 15\text{mm}$ y $Ala \, B \ge 15\text{mm}$.
- **Regla de Colisión:** $Base \, Central \ge Ala \, A$ y $Base \, Central \ge Ala \, B$.

---

## 🏷️ HITOS Y HISTORIAL DE VERSIONES (GIT RELEASES)

### Release `v0.2.0-beta` (Sistema de Clases Paso a Paso & Cuestionarios)
- Implementación del sistema de flujo guiado secuencial por etapas (`InteractiveLessonFlow.php`).
- Integración de cuestionarios evaluativos con opción múltiple, desafíos de teclado y retroalimentación inmediata.
- Nuevas tablas de base de datos `lesson_steps` y `user_step_progress`.
- Actualización de la interfaz con Stepper de progreso, badges interactivos y resplandor estilo cyber-engineering.

### Release `v0.1.0-alpha` (MVP Inicial)
- Inicialización de Laravel + Livewire v4 + Tailwind CSS + `<model-viewer>`.
