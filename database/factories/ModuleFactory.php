<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ModuleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->randomDigit(4),
            'route_name' => $this->faker->name(),
            'reverse_routing' => $this->faker->name(),
            'url' => $this->faker->url(),
            'status' => false,
        ];
    }
}
