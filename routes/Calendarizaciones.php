<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Calendarizaciones\{CalendarizacionesController, ConvocatoriasController, PeriodosController, TiposPeriodosController, TiposConvocatoriasController, DiaSemanaController, HorarioController};


// Periodos
Route::resource("Periodos", PeriodosController::class)->except(['show', 'create', 'edit']);

// Tipos de periodos
Route::resource("TiposPeriodo", TiposPeriodosController::class)->except(['show', 'create', 'edit']);

// Tipos de convocatorias
Route::resource("TiposConvocatoria", TiposConvocatoriasController::class)->except(['show', 'create', 'edit']);

// Convocatorias
Route::resource("Convocatorias", ConvocatoriasController::class)->except(['show', 'create', 'edit']);