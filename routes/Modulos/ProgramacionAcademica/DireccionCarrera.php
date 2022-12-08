<?php

use App\Http\Controllers\Modulos\ProgramacionAcademica\DireccionCarrera\AsignaHorariosController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

Route::resource("AsignaHorarios", AsignaHorariosController::class)->only(['index', 'store' ,'edit', 'update', 'destroy']);