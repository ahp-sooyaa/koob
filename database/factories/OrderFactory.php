<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'transaction_id' => $this->faker->uuid(),
            'address' => $this->faker->address(),
            'city' => $this->faker->city(),
            'state' => $this->faker->words($this->faker->numberBetween(1, 5), true),
            'zip_code' => $this->faker->numberBetween(10000, 20000),
            'total' => $this->faker->numberBetween(1000, 10000),
            'status' => $this->faker->randomElement([
                Order::SHIPPING,
                Order::DELIVERED,
            ]),
        ];
    }

    public function shipping()
    {
        return $this->state([
            'status' => Order::SHIPPING,
        ]);
    }

    public function delivered()
    {
        return $this->state([
            'status' => Order::DELIVERED,
        ]);
    }
}
