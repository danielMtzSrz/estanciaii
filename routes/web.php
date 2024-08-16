<?php


// Controladores
use App\Http\Controllers\System\{UserController, RoleController, PermissionController};

// Domicilios
use App\Http\Controllers\System\{PaisesController, EstadosController, MunicipiosController};

use App\Http\Controllers\System\PanelPrincipalController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use Inertia\Inertia;

// Agrupación de los controladores con el middleware de autenticación
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get("/", [PanelPrincipalController::class, 'index'])->name('dashboard');

    // Rutas de system
    Route::resource('user', UserController::class);
    Route::put('user/update/cv/{id_user}', [UserController::class, 'updateCv'])->name('user.update_cv');
    Route::get('user/generar/cv/{id_user}', [UserController::class, 'generarCv'])->name('user.generar_cv');
    Route::resource('role', RoleController::class);
    Route::resource('permission', PermissionController::class);
    
    // Rutas de domicilios
    Route::resource("paises", PaisesController::class)->except('show','create','edit');
    Route::resource("estados", EstadosController::class)->except('show','create','edit');
    Route::resource("municipios", MunicipiosController::class)->except('show','create','edit');
});
