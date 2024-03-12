<?php


// Controladores
use App\Http\Controllers\System\EmpresasController;
use App\Http\Controllers\System\{UserController, RoleController, PermissionController};

// Domicilios
use App\Http\Controllers\System\{PaisesController, EstadosController, MunicipiosController};

// Vacantes
use App\Http\Controllers\System\{TiposAnunciosController, AnunciosController};

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use Inertia\Inertia;

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
    
    // Rutas de empresas
    Route::resource("empresas", EmpresasController::class)->except('show','create','edit');
    
    // Rutas de domicilios
    Route::resource("paises", PaisesController::class)->except('show','create','edit');
    Route::resource("estados", EstadosController::class)->except('show','create','edit');
    Route::resource("municipios", MunicipiosController::class)->except('show','create','edit');
    
    // Anuncios
    Route::resource("tiposanuncios", TiposAnunciosController::class)->except('show','create','edit');
    Route::resource('anuncios', AnunciosController::class);
});
