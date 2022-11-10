<?php

namespace App\Models\Calendarizaciones;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Periodo extends Model{

    protected $table = 'periodos';

    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'tipo_periodo_id',
        'titulo',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
        'periodo_activo',        
        'log_id'
    ];

    // Relación con el modelo TipoPeriodo
    public function tipoPeriodo(){
        return $this->belongsTo('App\Models\Calendarizaciones\TipoPeriodo');
    }

    // Relación con el modelo Convocatorias
    public function convocatorias(){
        return $this->hasMany('App\Models\Calendarizaciones\Convocatoria');
    }

    // Relación con el modelo de proyecciones
    public function proyecciones(){
        return $this->hasMany('App\Models\SinGrupo\Proyeccione');
    }

    // Relación con el modelo GestionAcademica\GrupoMateria
    public function grupoMateria(){
        return $this->hasMany('App\Models\GestionAcademica\GrupoMateria');
    }

    // Relación con el modelo GestionAcademica\Inscripciones
    public function incripcion(){
        return $this->hasMany('App\Models\GestionAcademica\Inscripcione');
    }

    // Relación con el modelo ServiciosFinancieros\Pagos
    public function pagos(){
        return $this->hasMany('App\Models\ServiciosFinancieros\Pago');
    }

    // Relación con el modelo SinGrupo/Logs
    public function log(){
        return $this->belongsTo('App\Models\SinGrupo\Log');
    }
}
