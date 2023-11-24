<?php

namespace App\Models\GestionAcademica;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\GestionAcademica\PerfilAcademico;
use App\Models\GestionAcademica\PlanEstudio;
use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table ='carreras';

    protected $fillable = [
        'nombre',
        'imagen',
        'descripcion',
        'estatus',
        'tipo_coordinacion_carrera',
        'log_id',
    ];

    //Relacion con la tabla GestionAcademica\PerfilesAcademicos
    public function perfilAcademico()
    {
        return $this->hasMany(PerfilAcademico::class);
    }
    //Realcion con tabla EstructuraAcademica\PlanesEstudio
    public function planEstudio()
    {
        return $this->hasMany(PlanEstudio::class); //Duda santiago
    }
    //Relacion con la tabla SinGrupo\logs
    public function log()
    {
        return $this->belongsTo('App\Models\System\Log');
    }
}
