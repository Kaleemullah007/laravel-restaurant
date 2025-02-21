<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
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

        $password = Hash::make('password');
        $first_name = $this->faker->name();
        $last_name = $this->faker->name();

        return [
            'name' => $first_name.' '.$last_name,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->unique()->phoneNumber(),
            'email_verified_at' => now(),
            'password' => $password, // password
            'remember_token' => Str::random(10),
            'status' => true,
            'is_factory_user' => true,
            'activated_at' => now(),

        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
