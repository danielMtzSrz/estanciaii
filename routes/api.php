<?php

use App\Http\Controllers\Api\UsuariosApi;
use App\Http\Controllers\Api\Domicilios;
use App\Http\Controllers\Api\Empresas;
use App\Http\Controllers\Api\TipoAnuncioApi;
use App\Http\Controllers\Api\TiposPeriodoApi;
use App\Http\Controllers\Api\TiposConvocatoriaApi;
use App\Http\Controllers\Api\PeriodosApi;
use App\Http\Controllers\Api\AulasApi;
use App\Http\Controllers\Api\CarrerasApi;
use App\Http\Controllers\Api\MapasCurricularesApi;
use App\Http\Controllers\Api\CuatrimestresApi;
use App\Http\Controllers\Api\PlanesEstudioApi;
use App\Http\Controllers\Api\MateriasApi;
use App\Http\Controllers\Api\GruposApi;
use App\Http\Controllers\Api\GeneralApi;

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

// Usuarios
Route::get('usuarios', [UsuariosApi::class, 'Usuarios'])->name('usuarios');

// Empresas
Route::get('empresas', [Empresas::class, 'Empresas'])->name('empresas');

// Tipos de anuncios
Route::get('tipos_anuncio', [TipoAnuncioApi::class, 'TipoAnuncio'])->name('tipos_anuncio');

// Tipos de periodos
Route::get('tipos_periodo', [TiposPeriodoApi::class, 'TipoPeriodo'])->name('tipos_periodo');

// Tipos de convocatorias
Route::get('tipos_convocatoria', [TiposConvocatoriaApi::class, 'TiposConvocatoria'])->name('tipos_convocatoria');

// Periodos
Route::get('periodos', [PeriodosApi::class, 'Periodos'])->name('periodos');

// Aulas
Route::get('aulas', [AulasApi::class, 'Aulas'])->name('aulas');

// Carreras
Route::get('carreras', [CarrerasApi::class, 'Carreras'])->name('carreras');

// Turnos
Route::get('turnos', [CarrerasApi::class, 'Turnos'])->name('turnos');

// Turnos
Route::get('mapas_curriculares', [MapasCurricularesApi::class, 'MapasCurriculares'])->name('mapas_curriculares');

// Cuatrimestres
Route::get('cuatrimestres', [CuatrimestresApi::class, 'Cuatrimestres'])->name('cuatrimestres');

// Planes de estudio
Route::get('planes_estudio', [PlanesEstudioApi::class, 'PlanesEstudio'])->name('planes_estudio');

// Materias
Route::get('materias', [MateriasApi::class, 'Materias'])->name('materias');

// Grupos
Route::get('grupos', [GruposApi::class, 'Grupos'])->name('grupos');

// General
Route::get('generos', [GeneralApi::class, 'Generos'])->name('generos');
Route::get('tipos_sangre', [GeneralApi::class, 'TiposSangre'])->name('tipos_sangre');
Route::get('estados_civiles', [GeneralApi::class, 'EstadosCiviles'])->name('estados_civiles');

// Domicilios
Route::prefix('domicilio')->name('domicilio.')->group(function () {

    Route::get('paises', [Domicilios::class, 'Paises'])->name('paises');
    
    Route::get('estados/{id_pais}', [Domicilios::class, 'Estados'])->name('estados');
    
    Route::get('municipios/{id_estado}', [Domicilios::class, 'Municipios'])->name('municipios');
    
    Route::get('colonias/{id_municipio}', [Domicilios::class, 'Colonias'])->name('colonias');
    
    Route::get('cp/{cp}',[Domicilios::class, 'cp'])->name('cp');
});
