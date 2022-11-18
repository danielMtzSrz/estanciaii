<?php

namespace Database\Factories\EstructuraAcademica;

use App\Models\EstructuraAcademica\TipoAula;
use Illuminate\Database\Eloquent\Factories\Factory;

class TipoAulaFactory extends Factory
{
    protected $model = TipoAula::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->numerify('type-#'),
        ];
    }
}
