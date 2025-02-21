<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $password = Hash::make('password');
        $first_name = $this->faker->name();
        $last_name = $this->faker->name();

        return [
            'name' => $this->faker->name(),
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->unique()->phoneNumber(),
            'email_verified_at' => now(),
            'password' => $password, // password
            'remember_token' => Str::random(10),
            'status' => true,
            'activated_at' => now(),
            'user_type' => 'customer',
        ];
    }
}
