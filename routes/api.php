<?php

use App\Http\Controllers\Api\Domicilios;
use App\Http\Controllers\ChatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
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

Route::prefix('domicilio')->name('domicilio.')->group(function () {

    Route::get('paises', [Domicilios::class, 'Paises'])->name('paises');

    Route::get('estados/{id_pais}', [Domicilios::class, 'Estados'])->name('estados');

    Route::get('municipios/{id_estado}', [Domicilios::class, 'Municipios'])->name('municipios');

    Route::get('colonias/{id_municipio}', [Domicilios::class, 'Colonias'])->name('colonias');

    Route::get('cp/{cp}', [Domicilios::class, 'cp'])->name('cp');
});

// Chat api routes
//
Route::prefix('chat')->name('chat.')->group(function () {
    Route::get('get/{id}', [ChatController::class, 'getConversacion'])->name('get.conversacion');
    Route::get('get/msg/{id}', [ChatController::class, 'getMsg'])->name('get.msg');
    Route::post('send', [ChatController::class, 'sendMessage'])->name('send');
});
