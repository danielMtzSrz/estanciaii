<?php

namespace App\Models\Domicilios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Colonia extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'colonias';

    protected $hidden = ['deleted_at'];

    protected $fillable = [
        'municipio_id',
        'cp',
        'nombre',
    ];

    public function municipio()
    {
        return $this->belongsTo(Municipio::class);
    }
}
