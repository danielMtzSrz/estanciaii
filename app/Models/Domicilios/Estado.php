<?php

namespace App\Models\Domicilios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estado extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'estados';

    protected $hidden = ['deleted_at'];

    protected $fillable = [
        'pais_id',
        'nombre',
    ];


    // Maps
    public function indexMap()
    {
        return [
            'id' => $this->id,
            'pais' => $this->pais,
            'pais_nombre' => $this->pais->nombre,
            'nombre' => $this->nombre
        ];
    }

    // Relations
    public function pais()
    {
        return $this->belongsTo('App\Models\Domicilios\Pais');
    }

    public function municipio()
    {
        return $this->hasMany('App\Models\DomiciliosGrupo\Municipio');
    }
}
