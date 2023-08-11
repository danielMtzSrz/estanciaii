<?php

namespace App\Models\Chat;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    use HasFactory;

    protected $table = 'mensajes';

    protected $fillable = [
        'mensaje',
        'autor_id',
        'conversacion_id',
    ];

    public function conversacion()
    {
        return $this->belongsTo(Conversacion::class);
    }
    public function autor()
    {
        return $this->belongsTo(User::class);
    }
}
