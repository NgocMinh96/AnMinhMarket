<?php

namespace Database\Factories;

use App\Models\OrderList;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrderListFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderList::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'order_id' => Str::random(2) . time(),
            'name'     => $this->faker->name(),
            'phone'    => '093' . $this->faker->numberBetween(100000, 999999),
            'address'  => $this->faker->address(),
            'discount' => 0,
            'payment_price' => 100000,
            'payment_method' => 0,
            'payment_status' => 0,
            'order_status'  => 0
        ];
    }
}
