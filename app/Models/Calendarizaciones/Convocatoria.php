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
        'contenido'
    ];

    // Maps
    public function indexMap()
    {
        return [
            'id' => $this->id,
            'periodo' => $this->periodo,
            'periodo_nombre' => $this->periodo->titulo,
            'tipo_convocatoria' => $this->tipo_convocatoria,
            'tipo_convocatoria_nombre' => $this->tipo_convocatoria->nombre,
            'contenido' => $this->contenido,
        ];
    }

    // Relación con la tabla Calendarizaciones/Periodos
    public function periodo()
    {
        return $this->belongsTo('App\Models\Calendarizaciones\Periodo');
    }

    // Relación con la tabla Calendarizaciones/TiposConvocatorias
    public function tipo_convocatoria()
    {
        return $this->belongsTo('App\Models\Calendarizaciones\TipoConvocatoria');
    }
}
