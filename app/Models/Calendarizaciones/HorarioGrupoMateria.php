<?php

namespace App\Models\Calendarizaciones;

use App\Models\GestionAcademica\GrupoMateria;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HorarioGrupoMateria extends Model{
    
    protected $table = 'horariogrupomateria';

    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'horario_id',
        'grupo_materia_id',
        'log_id'
    ];

    // Relación con el modelo GestionAcademica\GrupoMateria
    public function horario(){
        return $this->belongsTo(Horario::class);
    }

    // Relación con el modelo GestionAcademica\GrupoMateria
    public function grupoMateria(){
        return $this->belongsTo(GrupoMateria::class);
    }
}
