<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;

use App\Models\EstructuraAcademica\Grupo;

use Inertia\Inertia;

class PanelPrincipalController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard');
    }
}
