<?php

namespace App\Models\Calendarizaciones;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Convocatoria extends Model{

    protected $table = 'convocatorias';

    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'periodo_id',
        'tipo_convocatoria_id',
        'servicio_id',
        'contenido',
        'log_id'
    ];

    // Relación con la tabla Calendarizaciones/Periodos
    public function periodo(){
        return $this->belongsTo('App\Models\Calendarizaciones\Periodo');
    }

    // Relación con la tabla Calendarizaciones/TiposConvocatorias
    public function tipoConvocatoria(){
        return $this->belongsTo('App\Models\Calendarizaciones\TipoConvocatoria');
    }

    // Relación con el modelo ServiciosFinancieros/Servicios
    public function servicio(){
        return $this->belongsTo('App\Models\ServiciosFinancieros\Servicio');
    }

    // Relación con el modelo SinGrupo/Logs
    public function log(){
        return $this->belongsTo('App\Models\SinGrupo\Log');
    }
}
