<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Controladores
use App\Http\Controllers\System\{UserController, RoleController, PermissionController};
use App\Http\Controllers\Seguimiento\{AnunciosController, VacantesController};

// Modelos
use Illuminate\Http\Request;

// Agrupación de los controladores con el middleware de autenticación

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/', function (Request $request) {
        session(['breadcrumbItems' => []]);

        return Inertia::render('Dashboard');
    })->name('dashboard');

    // Rutas de system
    Route::resource('user', UserController::class);
    Route::resource('role', RoleController::class);
    Route::resource('permission', PermissionController::class);

    // Rutas de seguimiento
    Route::resource('anuncios', AnunciosController::class);
    Route::resource('vacantes', VacantesController::class);
});
