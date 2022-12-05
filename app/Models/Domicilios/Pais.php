<?php

namespace App\Models\Domicilios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pais extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'paises';

    protected $hidden = ['log_id', 'deleted_at'];

    protected $fillable = [
        'nombre',
        'nacionalidad',
        'log_id',
    ];


    public function estados()
    {
        return $this->hasMany('App\Models\Domicilios\Estado');
    }

    public function municipios() {
        return $this -> hasManyThrough(Municipio::class, Estado::class);
    }

    public function usuario()
    {
        return $this->hasMany('App\Models\User');
    }

    public function paisPersona()
    {
        return $this->hasMany('App\Models\Domicilios\PaisPersona');
    }
}

