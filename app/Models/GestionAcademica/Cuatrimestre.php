<?php

namespace App\Models\GestionAcademica;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Cuatrimestre extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'cuatrimestre';

    protected $fillable = [
        'nombre',
        'log_id'
    ];

    //Relacion con la tabla GestionAcademica\Materias
    public function materia()
    {
        return $this->hasMany('App\Models\GestionAcademica\Materia.php');
    }
    //Relacion con la tabla System\logs
    public function log()
    {
        return $this->belongsTo('App\Models\System\Log');
    }
}
