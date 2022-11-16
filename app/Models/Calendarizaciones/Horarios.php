<?php

namespace App\Models\Calendarizaciones;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Horarios extends Model{

    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'gruopo_materia_id',
        'aula_id',
        'dia_semana_id',
        'hora_inicio',
        'hora_fin',
        'log_id',
    ];

    // Relación con el modelo GestionAcademica\GrupoMateria
    public function grupoMateria()
    {
        return $this->hasMany('App\Models\GestionAcademica\GrupoMateria');
    }

    // Relación con el modelo EstructuraAcademica/Aulas
    public function aula()
    {
        return $this->belongsTo('App\Models\EstructuraAcademica\Aula');
    }

    // Relación con el modelo Calendarizaciones/DiasSemana
    public function diaSemana()
    {
        return $this->belongsTo('App\Models\Calendarizaciones\DiasSemana');
    }
}
