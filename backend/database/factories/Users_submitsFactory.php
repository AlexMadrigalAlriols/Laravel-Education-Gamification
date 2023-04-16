<?php

namespace Database\Factories;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class Users_submitsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $idsTasks = DB::table('tasks')->pluck('id_tasks');
        $idsUser = DB::table('users')->pluck('id_user');


        return [
            'id_tasks' => fake()->randomElement($idsTasks),
            'id_user' => fake()->randomElement($idsUser),
            'submit' => "{}",
            'mark' => fake()->numberBetween(1, 10),
    
        ];
    }
}
