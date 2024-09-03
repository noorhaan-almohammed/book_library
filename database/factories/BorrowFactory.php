<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Borrow>
 */
class BorrowFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $borrowedAt = $this->faker->dateTimeBetween('-1 year', 'now');
        $dueDate = (clone $borrowedAt)->modify('+2 weeks');
        $returnedDate = $this->faker->boolean(70) ? $this->faker->dateTimeBetween($borrowedAt, $dueDate) : null;

        return [

            'book_id' =>  Book::factory(),
            'user_id' => User::factory(),
            'borrowed_at' => $borrowedAt->format('Y-m-d'),
            'due_date' => $dueDate->format('Y-m-d'),
            'returned_at' => $returnedDate ? $returnedDate->format('Y-m-d') : null,
        ];
    }
}
