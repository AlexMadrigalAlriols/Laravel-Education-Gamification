<?php

namespace Database\Factories;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class TasksFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $idsCategory = DB::table('category')->pluck('id_category');
        $idsCourse_uf = DB::table('course_uf')->pluck('id_course_uf');


        return [
            'id_category' => fake()->randomElement($idsCategory),
            'id_course_uf' => fake()->randomElement($idsCourse_uf),
            'title'=>fake()->title(),
            'description' => fake()->text($maxNbChars = 100),
            'type'=>fake()->randomElement(["task","forum","exam","file","link","page"]),
            'file_rubrica' => "{}",
            'contents' => "{}",
            'percentage' => fake()->numberBetween(1, 100),
            'max_mark' => fake()->numberBetween(1, 10),
        ];
    }
}
