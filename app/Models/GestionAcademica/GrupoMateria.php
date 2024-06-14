<?php

namespace App\Models\GestionAcademica;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GrupoMateria extends Model
{
    use HasFactory;
    
    protected $table = 'grupo_materia';

    protected $fillable = [
        'profesor_id',
        'materia_id',
        'grupo_id',
        'periodo_id',
        'horarios'
    ];

    protected $casts = [
        'horarios' => 'array'
    ];

    public function profesor()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }

    public function grupo()
    {
        return $this->belongsTo("App\Models\EstructuraAcademica\Grupo");
    }
}
