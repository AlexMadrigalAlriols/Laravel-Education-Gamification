<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PopersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'poper_name' => fake()->firstName(),
            'skin'=>"{}",
            'stats'=>"{}",
            'stats_base' => '{}',
            'abilities'=>"{}",
            'element'=>fake()->randomElement(['wild','ember','water','psyco','smog','brawny']),
            'level'=>fake()-> numberBetween(1, 99),
            'current_exp'=>fake()->numberBetween(0, 1000),


        ];
    }
}
