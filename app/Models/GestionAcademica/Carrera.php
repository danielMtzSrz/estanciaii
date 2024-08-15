<?php

namespace App\Models\GestionAcademica;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\GestionAcademica\PerfilAcademico;
use App\Models\GestionAcademica\PlanEstudio;

use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    use HasFactory;
    
    protected $table ='carreras';

    protected $fillable = [
        'nombre',
        'imagen',
        'descripcion',
        'estatus'
    ];

    public function perfilAcademico()
    {
        return $this->hasMany(PerfilAcademico::class);
    }

    public function planEstudio()
    {
        return $this->hasMany(PlanEstudio::class);
    }
}
