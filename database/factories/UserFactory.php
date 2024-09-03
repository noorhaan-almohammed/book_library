<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

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
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // Default password for seeded users
            'remember_token' => Str::random(10),
            'role' => 'user', // Default role if you have a role column
        ];
    }
     public function admin()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('p@ssw0rd'),
                'role' => 'admin',
            ];
        });
    }
    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return $this
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
