<?php

namespace Database\Factories\EstructuraAcademica;

use App\Models\EstructuraAcademica\Aula;
use Illuminate\Database\Eloquent\Factories\Factory;

class AulaFactory extends Factory
{
    protected $model = Aula::class;

    public function definition()
    {
        return [
            'edificio_id' => $this->faker->numberBetween(1,5),
            'tipo_aula_id' => $this->faker->numberBetween(1,5),
            'nombre' => $this->faker->numerify('room-##'),
            'estatus' => $this->faker->numberBetween(0,1),
            'capacidad' => $this->faker->numberBetween(10,40),
        ];
    }
}
