<?php

namespace App\Models\GestionAcademica;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\GestionAcademica\Materia;

use Illuminate\Database\Eloquent\Model;

class Asesoria extends Model
{
    use HasFactory;
    
    protected $table = 'asesorias';

    protected $fillable = [
        'materia_id',
        'user_id',
        'descripcion',
        'ubicacion',
        'hora_inicio',
        'hora_fin'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }
}
