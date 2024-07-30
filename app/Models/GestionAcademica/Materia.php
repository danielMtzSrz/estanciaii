<?php

namespace App\Models\GestionAcademica;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\GestionAcademica\GrupoMateria;
use App\Models\GestionAcademica\CargaAcademica;
use App\Models\GestionAcademica\Cuatrimestre;
use App\Models\GestionAcademica\PlanEstudio;

use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;
    
    protected $table = 'materias';

    protected $fillable = [
        "cuatrimestre_id",
        "plan_estudios_id",
        "nombre",
        "color"
    ];

    public function grupoMateria()
    {
        return $this->hasMany(GrupoMateria::class);
    }
    
    public function cargaAcademica()
    {
        return $this->hasMany(cargaAcademica::class);
    }
    
    public function planEstudios()
    {
        return $this->belongsTo(PlanEstudio::class);
    }

    public function cuatrimestre()
    {
        $cuatrimestres = config('staticdata.gestion_academica.cuatrimestres');

        return collect($cuatrimestres)->firstWhere('id', $this->cuatrimestre_id);
    }
}
