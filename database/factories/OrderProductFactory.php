<?php

namespace Database\Factories;

use App\Models\OrderList;
use App\Models\OrderProduct;
use App\Models\ProductList;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderProduct::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $product = ProductList::inRandomOrder()->first();
        return [
            'order_list_id' => OrderList::factory(),
            'product_id'    => $product->id,
            'name'          => $product->name,
            'price'         => $product->price,
            'quantity'      => rand(1, 3),
        ];
    }
}
