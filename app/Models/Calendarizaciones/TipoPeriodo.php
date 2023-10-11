<?php

namespace App\Models\Calendarizaciones;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoPeriodo extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'tipoPeriodo';

    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nombre',
        'descripcion',
        'color',
        'log_id'
    ];

    // Relación con el modelo Periodos
    public function periodo(){
        return $this->hasMany('App\Models\Calendarizaciones\Periodo');
    }
}
