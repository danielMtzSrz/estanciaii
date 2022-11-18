<?php

namespace Database\Seeders;

use App\Models\EstructuraAcademica\Aula;
use App\Models\EstructuraAcademica\AulaReservacion;
use App\Models\EstructuraAcademica\Edificio;
use App\Models\EstructuraAcademica\Grupo;
use App\Models\EstructuraAcademica\TipoAula;
use App\Models\GestionAcademica\Carrera;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstructuraAcademicaSeeder extends Seeder
{
    public function run()
    {
        User::factory(5)->create();
        Edificio::factory(5)->create();
        TipoAula::factory(5)->create();
        Aula::factory(5)->create();
        AulaReservacion::factory(5)->create();
        Carrera::factory(5)->create();
        Grupo::factory(5)->create();
    }
}
