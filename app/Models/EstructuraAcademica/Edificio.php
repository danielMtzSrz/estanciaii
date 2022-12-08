<?php

namespace App\Models\EstructuraAcademica;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Edificio extends Model
{

    protected $table = 'edificios';

    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nombre',
        'log_id'
    ];

    // Relación con la tabla EstructuraAcademica/Aulas
    public function aula()
    {
        return $this->hasMany('App\Models\EstructuraAcademica\Aula');
    }

    public function log()
    {
        return $this->belongsTo('App\Models\System\Log');
    }

    protected function createdAt() : Attribute {
        return Attribute::make(
            get: fn($value) => Carbon::parse($value) -> diffForHumans()
        );
    }

    protected function updatedAt() : Attribute {
        return Attribute::make(
            get: fn($value) => Carbon::parse($value) -> diffForHumans()
        );
    }
}
