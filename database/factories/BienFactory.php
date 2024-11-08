<?php

namespace Database\Factories;

use App\Models\Bien;
use Illuminate\Database\Eloquent\Factories\Factory;
use illuminate\support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bien>
 */
class BienFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Bien::class;

    public function definition(): array
    {
        return [
            // 'numero_inventario' => $this->faker->unique()->numerify('INV-####'),
            // 'numero_serie' => $this->faker->unique()->numerify('SER-####'),
            'numero_inventario' => 'INV-' . Str::random(6), // Más caracteres aleatorios
            'numero_serie' => 'SER-' . Str::random(6), // Más caracteres aleatorios
            'descripcion' => $this->faker->randomElement(['Laptop', 'Impresora', 'Mouse', 'Teclado', 'Monitor', 'Celular', 'No Break']),
            //'modelo' => $this->faker->word,
            'modelo' => $this->faker->word,
            //'marca' => $this->faker->word,
            'marca' => $this->faker->randomElement(['Lenovo', 'HP', 'Dell', 'Smartbit', 'Brother', 'LG', 'Asus', 'Epson']),
            'precio' => $this->faker->randomFloat(2, 100, 1000),
            'factura' => $this->faker->word,
            'observaciones' => $this->faker->optional()->sentence,
            //'estado' => $this->faker->randomElement(['DISPONIBLE', 'RESGUARDO', 'BAJA', 'MANTENIMIENTO']),
            'estado' => $this->faker->randomElement(['DISPONIBLE']),
            'fecha_ingreso' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
