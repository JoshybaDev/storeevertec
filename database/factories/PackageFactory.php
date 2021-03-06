<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Package>
 */
class PackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => 'Package ' . $this->faker->name(),
            'country_scope' => $this->faker->name(),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
