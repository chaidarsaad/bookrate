<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Rating;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rating>
 */
class RatingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Rating::class;
    public function definition(): array
    {
        return [
            'book_id' => Book::inRandomOrder()->first()->id,
            'score' => fake()->numberBetween(1, 10),
        ];
    }
}
