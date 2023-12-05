<?php

namespace App\Models\Calendarizaciones;

use App\Models\GestionAcademica\GrupoMateria;
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

    // Métodos
    public function indexMap()
    {
        return [
            'id' => $this->id,
            'tipo_periodo' => $this->tipoPeriodo,
            'tipo_periodo_nombre' => $this->tipoPeriodo->nombre,
            'titulo' => $this->titulo,
            'descripcion' => $this->descripcion,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'periodo_activo' => (boolean) $this->periodo_activo
        ];
    }

    // Relación con el modelo TipoPeriodo
    public function tipoPeriodo()
    {
        return $this->belongsTo('App\Models\Calendarizaciones\TipoPeriodo');
    }

    // Relación con el modelo Convocatorias
    public function convocatorias()
    {
        return $this->hasMany('App\Models\Calendarizaciones\Convocatoria');
    }

    // Relación con el modelo de proyecciones
    public function proyecciones()
    {
        return $this->hasMany('App\Models\SinGrupo\Proyeccione');
    }

    // Relación con el modelo GestionAcademica\GrupoMateria
    public function grupoMateria()
    {
        return $this->hasMany(GrupoMateria::class);
    }

    // Relación con el modelo GestionAcademica\Inscripciones
    public function incripcion()
    {
        return $this->hasMany('App\Models\GestionAcademica\Inscripcione');
    }

    // Relación con el modelo ServiciosFinancieros\Pagos
    public function pagos()
    {
        return $this->hasMany('App\Models\ServiciosFinancieros\Pago');
    }
}
