<?php

namespace App\Models\EstructuraAcademica;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aula extends Model
{

    protected $table = 'aulas';

    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'edificio_id',
        'tipo_aula_id',
        'nombre',
        'estatus',
        'capacidad',
        'log_id'
    ];

    // Relación con la tabla EstructuraAcademica/AulasReservacion
    public function aulaReservacion()
    {
        return $this->hasMany('App\Models\EstructuraAcademica\AulaReservacion');
    }

    // Relación con la tabla EstructuraAcademica/Edicios
    public function edificio()
    {
        return $this->belongsTo('App\Models\EstructuraAcademica\Edificio');
    }

    // Relación con la tabla EstructuraAcademica/Grupos
    public function grupo()
    {
        return $this->hasMany('App\Models\EstructuraAcademica\Grupo');
    }

    // Relación con la tabla Calendarizaciones/Horarios
    public function horario()
    {
        return $this->hasMany('App\Models\Calendarizaciones\Horario');
    }

    // Relación con la tabla EstructuraAcademica/TiposAulas
    public function tipoAula()
    {
        return $this->belongsTo('App\Models\EstructuraAcademica\TipoAula');
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
