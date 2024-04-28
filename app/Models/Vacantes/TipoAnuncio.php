<?php

namespace App\Models\Vacantes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoAnuncio extends Model
{
    use HasFactory;
    /* use SoftDeletes; */

    protected $table = 'tipos_anuncio';

    protected $fillable = [
        "empresa_id",
        "nombre",
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
            'nombre' => $this->nombre,
            'contenido' => $this->contenido,
            'imagen' => $this->imagen
        ];
    }
}
