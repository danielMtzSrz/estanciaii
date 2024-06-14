<?php

namespace App\Models\EstructuraAcademica;

use App\Models\GestionAcademica\GrupoMateria;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Grupo extends Model
{
    protected $table = 'grupos';

    use HasFactory;

    protected $fillable = [
        'carrera_id',
        'aula_id',
        'tutor_id',
        'periodo_id',
        'nombre',
        'turno',
        'horarios'
    ];

    protected $casts = [
        'horarios' => 'array'
    ];

    public function aula()
    {
        return $this->belongsTo('App\Models\EstructuraAcademica\Aula');
    }

    public function carrera()
    {
        return $this->belongsTo('App\Models\GestionAcademica\Carrera');
    }
    
    public function tutor()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function turno()
    {
        $turnos = config('staticdata.gestion_academica.turnos');
        
        return collect($turnos)->firstWhere('id', $this->turno);
    }

    public function grupoMateria()
    {
        return $this->hasMany(GrupoMateria::class);
    }

    public function periodo()
    {
        return $this->belongsTo("App\Models\Calendarizaciones\Periodo");
    }
}
