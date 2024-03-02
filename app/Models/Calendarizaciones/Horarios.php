<?php

namespace App\Models\Calendarizaciones;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horarios extends Model{

    use HasFactory;

    protected $fillable = [
        'aula_id',
        'dia_semana_id',
        'hora_inicio',
        'hora_fin',
    ];

    public function aula()
    {
        return $this->belongsTo('App\Models\EstructuraAcademica\Aula');
    }

    public function diasSemana()
    {
        $dias_semana = config('staticdata.dates.dias_semana');
        
        return collect($dias_semana)->firstWhere('id', $this->dia_semana_id);
    }
}
