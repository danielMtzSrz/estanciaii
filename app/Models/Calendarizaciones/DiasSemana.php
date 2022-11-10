<?php

namespace App\Models\Calendarizaciones;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiasSemana extends Model{

    protected $table = 'diasSemana';

    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nombre',
        'log_id'
    ];

    // Relación con el modelo Calendarizaciones/Horarios
    public function horario(){
        return $this->hasMany('App\Models\Calendarizaciones\Horario');
    }

    // Relación con el modelo SinGrupo/Logs
    public function log(){
        return $this->belongsTo('App\Models\SinGrupo\Log');
    }
}
