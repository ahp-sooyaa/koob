<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Address::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'default' => 0,
            'label' => $this->faker->title(),
//            'contact_no' => $this->faker->phoneNumber(),
            'building' => $this->faker->randomNumber(3),
            'street' => $this->faker->streetName(),
            'state' => $this->faker->streetAddress(),
            'township' => $this->faker->word(),
            'city' => $this->faker->city(),
        ];
    }

    public function default()
    {
        return $this->state([
            'default' => 1,
        ]);
    }
}
