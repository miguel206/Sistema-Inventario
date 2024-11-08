<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Personal>
 */
class PersonalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */


    public function definition(): array
    {


        return [
            //
            'rfc' => $this->faker->unique()->lexify('???') . strtoupper($this->faker->unique()->regexify('[0-9A-F]{10}')),
            'nombre' => $this->faker->name,
            'area' => $this->faker->randomElement(['Informatica', 'Contraloria', 'Juridico', 'Financieros', 'Materiales', 'Secretaria Ejecutiva', 'Consejeros', 'Asociaciones Politicas']),
            'fecha_ingreso' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
