<?php

namespace Database\Factories;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $idsCollege = DB::table('colleges')->pluck('id_college');
        $idsPopers = DB::table('popers')->pluck('id_poper');

        return [
            'name' => fake()->firstName(),
            'email' => fake()->unique()->safeEmail(),
            'last_name' => fake()->lastName(),
            'nick'=>fake()->firstNameMale(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'role'=>fake()->randomElement(['student','teacher','college_manager']),
            'pepas'=>fake()-> randomNumber(),
            'id_college' => fake()->randomElement($idsCollege),
            'courses' => "{}",
            'id_poper' => fake()->randomElement($idsPopers),
            'inventory' => "{}",
            'birth_date'=>fake()->date(),
            'force_change_pass' =>fake()->boolean()
            
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
