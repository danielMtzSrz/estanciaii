<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Calendarizaciones\{CalendarizacionesController, ConvocatoriasController, PeriodosController, TiposPeriodosController, TiposConvocatoriasController, DiaSemanaController, HorarioController};


// Periodos
Route::resource("Periodos", PeriodosController::class)->except(['show', 'create', 'edit']);
Route::name('Periodos.')->prefix('Periodos')->group(function () {
    Route::get('eliminados', [PeriodosController::class, 'trashed'])->name('trashed');
    Route::post('restablecer/{horarios}', [PeriodosController::class, 'restore'])->name('restore');
    Route::delete('forzarEliminado/{horarios}', [PeriodosController::class, 'forceDestroy'])->name('forceDelete');
}); 

// Tipos de periodos
Route::resource("TiposPeriodos", TiposPeriodosController::class)->except(['show', 'create', 'edit']);
Route::name('TiposPeriodos.')->prefix('TiposPeriodos')->group(function () {
    Route::get('eliminados', [TiposPeriodosController::class, 'trashed'])->name('trashed');
    Route::post('restablecer/{horarios}', [TiposPeriodosController::class, 'restore'])->name('restore');
    Route::delete('forzarEliminado/{horarios}', [TiposPeriodosController::class, 'forceDestroy'])->name('forceDelete');
}); 

// Días de la semana
Route::resource("DiasSemana", DiaSemanaController::class)->except(['show', 'create', 'edit']);
Route::name('DiasSemana.')->prefix('DiasSemana')->group(function () {
    Route::get('eliminados', [DiaSemanaController::class, 'trashed'])->name('trashed');
    Route::post('restablecer/{horarios}', [DiaSemanaController::class, 'restore'])->name('restore');
    Route::delete('forzarEliminado/{horarios}', [DiaSemanaController::class, 'forceDestroy'])->name('forceDelete');
}); 

// Tipos de convocatorias
Route::resource("TipoConv", TiposConvocatoriasController::class)->except(['show', 'create', 'edit']);
Route::name('TipoConv.')->prefix('TipoConv')->group(function () {
    Route::get('eliminados', [TiposConvocatoriasController::class, 'trashed'])->name('trashed');
    Route::post('restablecer/{horarios}', [TiposConvocatoriasController::class, 'restore'])->name('restore');
    Route::delete('forzarEliminado/{horarios}', [TiposConvocatoriasController::class, 'forceDestroy'])->name('forceDelete');
}); 

// Convocatorias
Route::resource("Convocatorias", ConvocatoriasController::class)->except(['show', 'create', 'edit']);
Route::name('Convocatorias.')->prefix('Convocatorias')->group(function () {
    Route::get('eliminados', [ConvocatoriasController::class, 'trashed'])->name('trashed');
    Route::post('restablecer/{horarios}', [ConvocatoriasController::class, 'restore'])->name('restore');
    Route::delete('forzarEliminado/{horarios}', [ConvocatoriasController::class, 'forceDestroy'])->name('forceDelete');
}); 

// Horarios
Route::resource('Horarios', HorarioController::class, ['parameters' => ['Horarios' => 'horarios']])->except(['show', 'create', 'edit']);
Route::name('Horarios.')->prefix('Horarios')->group(function () {
    Route::get('eliminados', [HorarioController::class, 'trashed'])->name('trashed');
    Route::post('restablecer/{horarios}', [HorarioController::class, 'restore'])->name('restore');
    Route::delete('forzarEliminado/{horarios}', [HorarioController::class, 'forceDestroy'])->name('forceDelete');
}); 