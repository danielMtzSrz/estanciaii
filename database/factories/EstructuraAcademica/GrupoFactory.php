<?php

namespace Database\Factories\EstructuraAcademica;

use App\Models\EstructuraAcademica\Grupo;
use Illuminate\Database\Eloquent\Factories\Factory;

class GrupoFactory extends Factory
{
    protected $model = Grupo::class;

    public function definition()
    {
        return [
            'carrera_id' => $this->faker->numberBetween(1,5),
            'aula_id' => $this->faker->numberBetween(1,5),
            'tutor_id' => $this->faker->numberBetween(1,5),
            'nombre' => $this->faker->numerify('carrera-##'),
            'turno' =>  $this->faker->numberBetween(0,1),
        ];
    }
}
