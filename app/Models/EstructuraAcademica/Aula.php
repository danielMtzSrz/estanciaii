<?php

namespace App\Models\EstructuraAcademica;

use App\Models\Calendarizaciones\Horario;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Aula extends Model
{

    protected $table = 'aulas';

    use HasFactory;

    protected $fillable = [
        'edificio_id',
        'tipo_aula_id',
        'nombre',
        'capacidad',
        'horarios',
        'estatus'
    ];

    protected $casts = [
        'horarios' => 'array'
    ];

    // Maps
    public function indexMap()
    {
        return [
            'id' => $this->id,
            'tipo_aula' => $this->tipoAula(),
            'tipo_aula_nombre' => $this->tipoAula()['nombre'],
            'edificio' => $this->edificio(),
            'edificio_nombre' => $this->edificio()['nombre'],
            'horarios' => $this->horarios,
            'nombre' => $this->nombre,
            'capacidad' => $this->capacidad,
            'estatus' => $this->estatus,
            'estatus_label' => $this->estatus_label
        ];
    }

    // Variables computadas
    public function getEstatusLabelAttribute()
    {
        return $this->estatus ? 'Activo' : 'Inactivo';
    }

    // Relación con la tabla EstructuraAcademica/AulasReservacion
    public function aulaReservacion()
    {
        return $this->hasMany('App\Models\EstructuraAcademica\AulaReservacion');
    }

    // Relación con la tabla EstructuraAcademica/Grupos
    public function grupo()
    {
        return $this->hasMany(Grupo::class);
    }

    // Relación con los arrays en staticdata
    public function edificio()
    {
        $edificio = config('staticdata.estructura_academica.edificios');

        return collect($edificio)->firstWhere('id', $this->edificio_id);
    }

    public function tipoAula()
    {
        $tipos_aulas = config('staticdata.estructura_academica.tipos_aulas');

        return collect($tipos_aulas)->firstWhere('id', $this->tipo_aula_id);
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
