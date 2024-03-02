<?php

namespace App\Models\GestionAcademica;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\GestionAcademica\PlanEstudio;

class MapaCurricular extends Model
{
    use HasFactory;
    
    protected $table = 'mapas_curriculares';

    protected $fillable = [
        'clave_mapa_curricular',
        'total_cuatrimestres',
        'total_horas',
        'total_creditos',
        'total_materias',
        'duracion',
        'vigencia',
        'fecha_revision'
    ];

    public function planEstudio()
    {
        return $this->hasMany(PlanEstudio::class);
    }
}
