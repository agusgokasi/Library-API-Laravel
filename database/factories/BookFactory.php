<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    protected $model = Book::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3), // Generate a book title
            'description' => $this->faker->paragraph(), // Generate a description
            'publish_date' => $this->faker->date(), // Generate a random publish date
            'author_id' => Author::factory(), // Generate an associated author
        ];
    }
}
