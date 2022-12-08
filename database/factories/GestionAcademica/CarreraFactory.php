<?php

namespace Database\Factories\GestionAcademica;

use App\Models\GestionAcademica\Carrera;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarreraFactory extends Factory
{
    protected $model = Carrera::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->numerify('group-##'),
            'descripcion' => $this->faker->sentence(5),
            'estatus' => $this->faker->numberBetween(0,1),
        ];
    }
}
