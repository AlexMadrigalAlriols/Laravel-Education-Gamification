<?php

namespace Database\Factories;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $idsCourse = DB::table('courses')->pluck('id_course');
        return [
            'id_course' => fake()->randomElement($idsCourse),
            'title' => fake()->title(),
            'order'=>fake()->unique()->numberBetween(1, 1000),

        ];

       
    }
    
}
