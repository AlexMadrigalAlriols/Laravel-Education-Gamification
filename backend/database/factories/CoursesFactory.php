<?php

namespace Database\Factories;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Courses>
 */
class CoursesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $idsTeacher = DB::table('users')->pluck('id_user');
        $idsCollege = DB::table('colleges')->pluck('id_college');


        return [
            'course_name' => fake()->firstName(),
            'id_teacher' => fake()->randomElement($idsTeacher),
            'id_college' => fake()->randomElement($idsCollege),
            'shop' => "{}",
            'code'=>fake()->unique()->asciify('******'),
            'requests'=>"{}",
            'tasks'=>"{}",

        ];
    }
}
