<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cart::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory()->create(),
            'book_id' => Book::factory()->create(),
            'title' => $this->faker->sentence(),
            'quantity' => $this->faker->numberBetween(10, 90),
            'price' => $this->faker->numberBetween(10_00, 90_00)
        ];
    }
}
