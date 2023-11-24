<?php

namespace App\Models\Calendarizaciones;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoPeriodo extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'tipoPeriodo';

    use HasFactory;
    // use SoftDeletes;

    protected $fillable = [
        'nombre',
        'contenido',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    // Relación con el modelo Periodos
    public function periodo(){
        return $this->hasMany('App\Models\Calendarizaciones\Periodo');
    }
}
