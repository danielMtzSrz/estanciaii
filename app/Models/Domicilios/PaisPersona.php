<?php

namespace App\Models\Domicilios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaisPersona extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'paisPersona';

    protected $hidden = ['deleted_at'];

    protected $fillable = [
        'nacionalidad_id',
        'usuarios_id',
    ];

    public function usuario()
    {
        return $this->belongsToMany('App/Models/User');
    }

    public function pais()
    {
        return $this->belongsTo('App/Models/DomiciliosGrupo/Pais');
    }
}
