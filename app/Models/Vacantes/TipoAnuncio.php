<?php

namespace App\Models\Vacantes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoAnuncio extends Model
{
    use HasFactory;
    /* use SoftDeletes; */

    protected $connection = 'mongodb';

    protected $collection = 'tipoAnuncio';

    protected $fillable = [
        "empresaasociada_id",
        "titulo",
        "contenido",
        "imagen"
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        /* 'deleted_at', */
    ];

    // Scopes

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
    public function empresa()
    {
        return $this->belongsTo("App\Models\Empresas", 'empresaasociada_id', 'id');
    }
}
