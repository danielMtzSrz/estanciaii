<?php

namespace App\Models\Seguimiento;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anuncios extends Model
{
    use HasFactory;

    protected $fillable = [
        "empresa_id",
        "name",
        "contenido",
        "imagen"
    ];

    public function empresa(){
        return $this->belongsTo("App\Models\System\Empresas");
    }
}
