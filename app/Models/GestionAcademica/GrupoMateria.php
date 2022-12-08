<?php

namespace App\Models\GestionAcademica;

use App\Models\Calendarizaciones\HorarioGrupoMateria;
use App\Models\Calendarizaciones\Periodo;
use App\Models\EstructuraAcademica\Grupo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\GestionAcademica\PerfilAcademico;
use App\Models\GestionAcademica\PlanEstudio;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;


class GrupoMateria extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'grupomateria';

    protected $fillable = [
        'profesor_id',
        'materia_id',
        'grupo_id',
        'periodo_id',
        'log_id',
    ];

    //Relación con tabla 
    public function profesor()
    {
        return $this->belongsTo('App\Models\User');
    }

    //Relación con tabla 
    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }

    //Relación con tabla
    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }

    //Relación con tabla
    public function horarioGrupoMateria()
    {
        return $this->hasMany(HorarioGrupoMateria::class);
    }

    public function periodo(){
        return $this->belongsTo(Periodo::class);
    }
    
    //Relacion con la tabla SinGrupo\logs
    public function log()
    {
        return $this->belongsTo('App\Models\System\Log');
    }
}
