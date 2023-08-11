<?php

namespace App\Models\Chat;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversacion extends Model
{
    use HasFactory;

    protected $table = 'conversaciones';


    protected $fillable = [
        'nomhbre',
    ];

    public function mensajes()
    {
        return $this->hasMany(Mensaje::class);
    }

    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'usuario_conversacion', 'conversacion_id', 'usuario_id');
    }
}
