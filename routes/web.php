<?php


// Controladores
use App\Http\Controllers\EmpresasController;
use App\Http\Controllers\System\{UserController, RoleController, PermissionController};
use App\Http\Controllers\Seguimiento\{AnunciosController, VacantesController};

// Domicilios
use App\Http\Controllers\System\{PaisesController};

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use Inertia\Inertia;

// Agrupación de los controladores con el middleware de autenticación

use App\Http\Controllers\Prueba\PruebaController;

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

    // Rutas de empresas
    Route::resource("empresas", EmpresasController::class)->except('show','create','edit');

    // Rutas de domicilios
    Route::resource("paises", PaisesController::class)->except('show','create','edit');

    Route::resource('prueba', PruebaController::class);
});
