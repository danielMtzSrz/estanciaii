<?php

namespace App\Models\EstructuraAcademica;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\GestionAcademica\GrupoMateria;

class Grupo extends Model
{

    protected $table = 'grupos';

    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'carrera_id',
        'aula_id',
        'tutor_id',
        'nombre',
        'turno',
        'log_id'
    ];

    // Relación con la tabla EstructuraAcademica/Aulas
    public function aula()
    {
        return $this->belongsTo('App\Models\EstructuraAcademica\Aula');
    }

    // Relación con la tabla GestionAcademica/Carreras
    public function carrera()
    {
        return $this->belongsTo('App\Models\GestionAcademica\Carrera');
    }
    
    // Relación con la tabla GestionAcademica/GrupoMateria
    public function grupoMateria()
    {
        return $this->hasMany(GrupoMateria::class);
    }

    // Relación con la tabla User
    public function tutor()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function log()
    {
        return $this->belongsTo('App\Models\System\Log');
    }

    protected function createdAt() : Attribute {
        return Attribute::make(
            get: fn($value) => Carbon::parse($value) -> diffForHumans()
        );
    }

    protected function updatedAt() : Attribute {
        return Attribute::make(
            get: fn($value) => Carbon::parse($value) -> diffForHumans()
        );
    }
}
