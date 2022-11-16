<?php

namespace App\Models\GestionAcademica;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\GestionAcademica\GrupoMateria;
use App\Models\GestionAcademica\CargaAcademica;
use App\Models\EstructuraAcademica\Academia;
use App\Models\GestionAcademica\Cuatrimestre;
use App\Models\GestionAcademica\PlanEstudio;


use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'materias';

    protected $fillable = [
        "cuatrimestre_id",
        "nombre",
        "plan_estudios_id",
        "log_id"
    ];

    //Relacion con la tabla GestionAcademica\GrupoMateria
    public function grupoMateria()
    {
        return $this->hasMany(GrupoMateria::class);
    }
    //Relacion con la tabla GestionAcademica\CargasAcademicas
    public function cargaAcademica()
    {
        return $this->hasMany(cargaAcademica::class);
    }

    //Relacion con la tabla EstructuraAcademica\Cuatrimestre
    public function cuatrimestre()
    {
        return $this->belongsTo(Cuatrimestre::class);
    }
    //Realacion con la tabla EstructuraAcademica\PlanesEstudio
    public function planEstudio()
    {
        return $this->belongsTo(PlanEstudio::class);
    }
    //Relacion con la tabla System\logs
    public function log()
    {
        return $this->belongsTo('App\Models\System\Log');
    }
}
