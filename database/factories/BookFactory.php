<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->unique->name(),
            'author' => $this->faker->name(),
            'description' => $this->faker->text(),
            'category' =>  $this->faker->randomElement(['drama', 'horror', 'romance', 'action']),
            'published_at' => $this->faker->date(),
        ];
    }
}
