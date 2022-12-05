<?php

namespace App\Models\Domicilios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Municipio extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'municipios';

    protected $hidden = ['deleted_at'];

    protected $fillable = [
        'estado_id',
        'nombre',
    ];

    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }

    public function colonia()
    {
        return $this->hasMany(Colonia::class);
    }

}
