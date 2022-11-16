<?php

namespace App\Models\GestionAcademica;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\GestionAcademica\PlanEstudio;
use Illuminate\Database\Eloquent\Model;

class MapaCurricular extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'mapascurriculares';

    protected $fillable = [
        'clave_mapa_curricular',
        'total_cuatrimestres',
        'total_horas',
        'total_creditos',
        'total_materias',
        'duracion',
        'vigencia',
        'fecha_revision',
        'log_id'
    ];

    //Relacion con la tabla GestionAcademica\PlanesEstudio
    public function planEstudio()
    {
        return $this->hasMany(PlanEstudio::class);
    }
    //Relacion con la tabla System\logs
    public function log()
    {
        return $this->belongsTo('App\Models\System\Log');
    }
}
