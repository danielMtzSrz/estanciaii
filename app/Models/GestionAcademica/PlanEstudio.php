<?php

namespace App\Models\GestionAcademica;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\GestionAcademica\Materia;
use App\Models\GestionAcademica\Carrera;
use App\Models\GestionAcademica\mapaCurricular;

use Illuminate\Database\Eloquent\Model;

class PlanEstudio extends Model
{
    use HasFactory;

    protected $table = 'planes_estudio';

    protected $fillable = [
        'carrera_id',
        'mapa_curricular_id',
        'estatus'
    ];

    public function materia()
    {
        return $this->hasMany(Materia::class);
    }
    
    public function carrera()
    {
        return $this->belongsTo(Carrera::class);
    }
    
    public function mapaCurricular()
    {
        return $this->belongsTo(mapaCurricular::class);
    }
}
