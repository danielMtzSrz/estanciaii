<?php

namespace App\Models\Domicilios;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Domicilio extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'domicilios';

    protected $hidden = ['deleted_at'];

    protected $fillable = [
        'colonia_id',
        'referencias',
        'calle',
        'numero_interior',
        'numero_exterior',
    ];

    public function colonia()
    {
        return $this->belongsTo(Colonia::class);
    }

    public function institucionProcedencia()
    {
        return $this->hasMany('App/Models/EstructuraAcademica/InstitucionProcedencia');
    }

}
