<?php

namespace App\Models\Calendarizaciones;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoConvocatoria extends Model{

    protected $table = 'tipos_convocatoria';

    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nombre',
        'contenido'
    ];

    public function convocatorias()
    {
        return $this->hasMany('App\Models\Calendarizaciones\Convocatoria');
    }

}
