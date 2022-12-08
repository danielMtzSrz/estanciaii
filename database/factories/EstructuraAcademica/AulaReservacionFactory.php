<?php

namespace Database\Factories\EstructuraAcademica;

use App\Models\EstructuraAcademica\AulaReservacion;
use Illuminate\Database\Eloquent\Factories\Factory;

class AulaReservacionFactory extends Factory
{
    protected $model = AulaReservacion::class;

    public function definition()
    {
        return [
            'aula_id' => $this->faker->numberBetween(1,5),
            'solicitante_id' => $this->faker->numberBetween(1,5),
            'horario_inicio' => $this->faker->dateTimeBetween('-2 week', 'now'),
            'horario_final' => $this->faker->dateTimeBetween('now', '+2 week'),
            'asunto' => $this->faker->words(2, true),
            'descripcion' => $this->faker->sentence(5)
        ];
    }
}
