<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Prueba extends Model
{
    use HasFactory;
    /* use SoftDeletes; */

    protected $connection = 'mongodb';

    protected $collection = 'prueba';

    protected $fillable = [
          "id",
          "descripcion",
          "imagen"
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        /* 'deleted_at', */
    ];

    // Atributes
    // public function getNombrePaisAttribute()
    // {
    //     return $this->colonia->municipio->estado->pais->nombre;
    // }

    // Scopes
    public function scopeToIndex($query)
    {
        return $query->with(['colonia.municipio.estado.pais']);
    }

    // Maps
    public function indexMap()
    {
        $empresaArray = $this->toArray();

        $empresaArray['direccion'] = $this->nombre_pais.", ".
                                     $this->nombre_estado.", ".
                                     $this->nombre_municipio.", ".
                                     $this->nombre_colonia.", ".
                                     $this->calle.", ".
                                     $this->cp_colonia;

        return collect($empresaArray);
    }

    // Relations
}
