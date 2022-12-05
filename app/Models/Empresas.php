<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresas extends Model
{
    use HasFactory;
    /* use SoftDeletes; */

    protected $table = 'empresasAsociadas';

    protected $fillable = [
          "id",
          "domicilio_id",
          "calle",
          "numero_exterior",
          "numero_interior",
          "codigo_postal",
          "nombre_empresa",
          "razon_social",
          "rfc",
          "imagen",
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        /* 'deleted_at', */
    ];

    public function domicilio()
    {
        return $this->belongsTo('App\Models\Domicilios\Domicilio' , "domicilio_id");
    }
}
