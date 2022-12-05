<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GestionAcademica\TipoEvaluacionController;
use App\Http\Controllers\GestionAcademica\GradoAcademicoController;
use App\Http\Controllers\GestionAcademica\CuatrimestreController;
use App\Http\Controllers\GestionAcademica\MapaCurricularController;
use App\Http\Controllers\GestionAcademica\{CarreraController, GrupoMateriaController, MateriaController, PlanEstudioController};
use Inertia\Inertia;


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get("/", fn() => Inertia::render('GestionAcademica/Index'))->name('Panel');

    //carreras
    Route::resource("Carreras", CarreraController::class)->except(['show', 'create', 'edit']);
    Route::name('Carreras.')->prefix('Carreras')->group(function () {
        Route::get('eliminados', [CarreraController::class, 'trashed'])->name('trashed');
        Route::post('restablecer/{carrera}', [CarreraController::class, 'restore'])->name('restore');
        Route::delete('forzarEliminado/{carrera}', [CarreraController::class, 'forceDestroy'])->name('forceDelete');
    });

    //cuatrimestres
    Route::resource("Cuatrimestres", CuatrimestreController::class)->except(['show', 'create', 'edit']);
    Route::name('Cuatrimestres.')->prefix('Cuatrimestres')->group(function () {
        Route::get('eliminados', [CuatrimestreController::class, 'trashed'])->name('trashed');
        Route::post('restablecer/{cuatrimestre}', [CuatrimestreController::class, 'restore'])->name('restore');
        Route::delete('forzarEliminado/{cuatrimestre}', [CuatrimestreController::class, 'forceDestroy'])->name('forceDelete');
    });

    //Grupo-materia
    Route::resource("GrupoMateria", GrupoMateriaController::class)->except(['show', 'create', 'edit']);
    Route::name('GrupoMateria.')->prefix('GrupoMateria')->group(function () {
        Route::get('eliminados', [GrupoMateriaController::class, 'trashed'])->name('trashed');
        Route::post('restablecer/{grupoMateria}', [GrupoMateriaController::class, 'restore'])->name('restore');
        Route::delete('forzarEliminado/{grupoMateria}', [GrupoMateriaController::class, 'forceDestroy'])->name('forceDelete');
    });

    //Mapas curriculares
    Route::resource("MapasCurriculares", MapaCurricularController::class)->except(['show', 'create', 'edit']);
    Route::name('MapasCurriculares.')->prefix('MapasCurriculares')->group(function () {
        Route::get('eliminados', [MapaCurricularController::class, 'trashed'])->name('trashed');
        Route::post('restablecer/{mapaCurricular}', [MapaCurricularController::class, 'restore'])->name('restore');
        Route::delete('forzarEliminado/{mapaCurricular}', [MapaCurricularController::class, 'forceDestroy'])->name('forceDelete');
    });

    //Materias
    Route::resource("Materias", MateriaController::class)->except(['show', 'create', 'edit']);
    Route::name('Materias.')->prefix('Materias')->group(function () {
        Route::get('eliminados', [MateriaController::class, 'trashed'])->name('trashed');
        Route::post('restablecer/{materia}', [MateriaController::class, 'restore'])->name('restore');
        Route::delete('forzarEliminado/{materia}', [MateriaController::class, 'forceDestroy'])->name('forceDelete');
    });

    //Planes de Estudios
    Route::resource("PlanesEstudios", PlanEstudioController::class)->except(['show', 'create', 'edit']);
    Route::name('PlanesEstudios.')->prefix('PlanesEstudios')->group(function () {
        Route::get('eliminados', [PlanEstudioController::class, 'trashed'])->name('trashed');
        Route::post('restablecer/{planEstudio}', [PlanEstudioController::class, 'restore'])->name('restore');
        Route::delete('forzarEliminado/{planEstudio}', [PlanEstudioController::class, 'forceDestroy'])->name('forceDelete');
    });

});
