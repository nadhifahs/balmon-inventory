<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->words(3, true),
            'product_category_id' => 1,
            'brand' => $this->faker->lexify('?????'),
            'type' => $this->faker->lexify('?????'),
            'series' => $this->faker->lexify('?????'),
            'condition' => $this->faker->randomElement(['BAIK','RUSAK']),
            'year' => rand(2010,2022),
            'quantity' => 1
        ];
    }
}
