<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Material>
 */
class MaterialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => 'CO' . $this->faker->unique()->numberBetween(1, 9999),
            'name' => $this->faker->word,
            'price' => $this->faker->randomFloat(2, 1, 100),
        ];
    }
}
