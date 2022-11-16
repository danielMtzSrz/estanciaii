<?php

namespace App\Models\GestionAcademica;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\GestionAcademica\Materia;
use App\Models\GestionAcademica\Carrera;
use App\Models\GestionAcademica\mapaCurricular;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class PlanEstudio extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'planesEstudio';

    protected $fillable = [
        'carrera_id',
        'mapa_curricular_id',
        'estatus',
        'log_id'
    ];

    //Relacion con la tabla GestionAcademica\Materias
    public function materia()
    {
        return $this->hasMany(Materia::class);
    }
    //Relacion con la tabla GestionAcademica\Carreras
    public function carrera()
    {
        return $this->belongsTo(Carrera::class);
    }
    //Relacion con la tabla GestionAcademica\MapasCurriculares
    public function mapaCurricular()
    {
        return $this->belongsTo(mapaCurricular::class);
    }
    //Relacion con la tabla System\logs
    public function log()
    {
        return $this->belongsTo('App\Models\System\Log');
    }
}
