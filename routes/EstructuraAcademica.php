<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstructuraAcademica\{ AulaController, AulaReservacionController, GrupoController };


// Aulas
Route::resource("Aulas", AulaController::class)->except(['show', 'create', 'edit']);
Route::name('Aulas.')->prefix('Aulas')->group(function () {
    Route::get('eliminados', [AulaController::class, 'trashed'])->name('trashed');
    Route::post('restablecer/{id}', [AulaController::class, 'restore'])->name('restore');
    Route::delete('forzarEliminado/{id}', [AulaController::class, 'forceDestroy'])->name('forceDelete');
}); 

Route::resource("AulasReservacion", AulaReservacionController::class)->except(['show', 'create', 'edit']);
Route::name('AulasReservacion.')->prefix('AulasReservacion')->group(function () {
    Route::get('eliminados', [AulaReservacionController::class, 'trashed'])->name('trashed');
    Route::post('restablecer/{id}', [AulaReservacionController::class, 'restore'])->name('restore');
    Route::delete('forzarEliminado/{id}', [AulaReservacionController::class, 'forceDestroy'])->name('forceDelete');
});

Route::resource("Grupos", GrupoController::class)->except(['show', 'create', 'edit']);
Route::name('Grupos.')->prefix('Grupos')->group(function () {
    Route::get('eliminados', [GrupoController::class, 'trashed'])->name('trashed');
    Route::post('restablecer/{id}', [GrupoController::class, 'restore'])->name('restore');
    Route::delete('forzarEliminado/{id}', [GrupoController::class, 'forceDestroy'])->name('forceDelete');
});