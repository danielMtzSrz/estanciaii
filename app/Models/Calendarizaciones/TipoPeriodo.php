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
        'contenido',
    ];

    protected $guarded = [
        '_id'
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
