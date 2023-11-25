<?php

use App\Http\Controllers\Api\Domicilios;
use App\Http\Controllers\Api\Empresas;
use App\Http\Controllers\Api\TipoAnuncioApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Empresas
Route::get('empresas', [Empresas::class, 'Empresas'])->name('empresas');

// Tipos de anuncios
Route::get('tipos_anuncio', [TipoAnuncioApi::class, 'TipoAnuncio'])->name('tipos_anuncio');


// Domicilios
Route::prefix('domicilio')->name('domicilio.')->group(function () {

    Route::get('paises', [Domicilios::class, 'Paises'])->name('paises');
    
    Route::get('estados/{id_pais}', [Domicilios::class, 'Estados'])->name('estados');
    
    Route::get('municipios/{id_estado}', [Domicilios::class, 'Municipios'])->name('municipios');
    
    Route::get('colonias/{id_municipio}', [Domicilios::class, 'Colonias'])->name('colonias');
    
    Route::get('cp/{cp}',[Domicilios::class, 'cp'])->name('cp');
});
