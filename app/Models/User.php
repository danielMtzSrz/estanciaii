<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'colonia_id',
        'tipo_sangre_id',
        'estado_civil_id',
        'generos_id',
        'nacionalidad_id',
        
        'apellido_paterno',
        'apellido_materno',
        'fecha_nacimiento',
        'curp',
        'rfc',
        'nss',
        'telefono_local',
        'telefono_celular',
        'name',
        'email',
        
        'calle',
        'numero_exterior',
        'numero_interior',
        'profile_photo_path',
        'password',

        'cv',
        'horarios'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'horarios' => 'array'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function setPasswordAttribute($value){
        $this->attributes["password"] = Hash::make($value);
    }

    public function materias(){
        return $this->hasMany("App\Models\Material\Materias");
    }

    public function materiaUsuarios(){
        return $this->belongsTo("App\Models\Material\MateriaUsuarios");
    }
}
