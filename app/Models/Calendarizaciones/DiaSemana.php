<?php

namespace App\Models\Calendarizaciones;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiaSemana extends Model{

    protected $table = 'diasSemana';

    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nombre',
        'log_id'
    ];
}
