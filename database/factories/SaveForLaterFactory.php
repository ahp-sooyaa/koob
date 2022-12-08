<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\SaveForLater;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaveForLaterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SaveForLater::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $book = Book::factory()->create();

        return [
            'user_id' => User::factory(),
            'book_id' => $book->id,
            'title' => $book->title,
            'slug' => $book->slug,
            'quantity' => $this->faker->numberBetween(1, 10),
            'price' => $this->faker->numberBetween(10_00, 90_00),
            'cover_url' => $book->cover_url,
        ];
    }
}
