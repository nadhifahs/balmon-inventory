<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin>
 */
class AdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'username' => fake()->userName(),
            'password' => bcrypt('password'),
            'email' => fake()->unique()->email(),
            'name' => fake()->name(),
            'avatar' => 'storage/placeholder/avatar/default-profile.png'
        ];
    }
}
