<?php

use App\Livewire\CourseDashboard;
use Illuminate\Support\Facades\Route;

/**
 * Rutas de la Plataforma Educativa Acadenvit.
 * Renderizan el componente principal CourseDashboard con soporte de parámetros de lección activa.
 */

// Ruta Principal del Dashboard del Curso
Route::get('/', CourseDashboard::class)->name('course.dashboard');

// Ruta Directa a una Lección por su Slug
Route::get('/leccion/{lessonSlug}', CourseDashboard::class)->name('course.lesson');
