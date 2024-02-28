<?php

namespace App\Models\EstructuraAcademica;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AulaReservacion extends Model
{
    protected $table = 'aulas_reservacion';

    use HasFactory;

    protected $fillable = [
        'aula_id',
        'solicitante_id',
        'horario_inicio',
        'horario_final',
        'asunto',
        'descripcion'
    ];

    // Relación con la tabla EstructuraAcademica/Aula
    public function aula()
    {
        return $this->belongsTo('App\Models\EstructuraAcademica\Aula');
    }

    // Relación con la tabla System/Users
    public function solicitante()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function log()
    {
        return $this->belongsTo('App\Models\System\Log');
    }

    protected function createdAt() : Attribute {
        return Attribute::make(
            get: fn($value) => Carbon::parse($value)->diffForHumans()
        );
    }

    protected function updatedAt() : Attribute {
        return Attribute::make(
            get: fn($value) => Carbon::parse($value)->diffForHumans()
        );
    }
}
