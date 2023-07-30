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
          "colonia_id",
          "calle",
          "numero_exterior",
          "numero_interior",
          "codigo_postal",
          "nombre_empresa",
          "razon_social",
          "rfc",
          "imagen"
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        /* 'deleted_at', */
    ];

    // Atributes
    public function getNombrePaisAttribute()
    {
        return $this->colonia->municipio->estado->pais->nombre;
    }

    public function getNombreEstadoAttribute()
    {
        return $this->colonia->municipio->estado->nombre;
    }

    public function getNombreMunicipioAttribute()
    {
        return $this->colonia->municipio->nombre;
    }

    public function getNombreColoniaAttribute()
    {
        return $this->colonia->nombre;
    }

    public function getCpColoniaAttribute()
    {
        return $this->colonia->nombre;
    }

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
    public function colonia()
    {
        return $this->belongsTo("App\Models\Domicilios\Colonia");
    }
}
