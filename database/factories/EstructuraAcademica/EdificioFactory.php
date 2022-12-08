<?php

namespace Database\Factories\EstructuraAcademica;

use App\Models\EstructuraAcademica\Edificio;
use Illuminate\Database\Eloquent\Factories\Factory;

class EdificioFactory extends Factory
{
    protected $model = Edificio::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->numerify('build-##')
        ];
    }
}
