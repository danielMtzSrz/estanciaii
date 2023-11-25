<?php

namespace App\Models\Vacantes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anuncio extends Model
{
    use HasFactory;
    /* use SoftDeletes; */

    protected $table = 'anuncios';

    protected $fillable = [
        "tipo_anuncio_id",
        "empresa_id",
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
            'empresa' => $this->empresa,
            'empresa_nombre' => $this->empresa->nombre_empresa,
            'tipo_anuncio' => $this->tipoAnuncio,
            'tipo_anuncio_nombre' => $this->tipoAnuncio->nombre,
            'titulo' => $this->titulo,
            'contenido' => $this->contenido,
            'imagen' => $this->imagen
        ];
    }

    // Relations
    public function tipoAnuncio()
    {
        return $this->belongsTo("App\Models\Vacantes\TipoAnuncio");
    }

    public function empresa()
    {
        return $this->belongsTo("App\Models\Empresas");
    }
}
