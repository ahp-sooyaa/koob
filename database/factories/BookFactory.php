<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => Category::factory(),
            'slug' => $this->faker->slug(),
            'title' => $this->faker->sentence(),
            'author' => $this->faker->name(),
            'excerpt' => $this->faker->paragraph(),
            'price' => $this->faker->numberBetween(10_00, 90_00),
            'cover' => '/images/cover.png',
            // 'available_stock_count' => 10,
            'stock_count' => 10
        ];
    }
}
