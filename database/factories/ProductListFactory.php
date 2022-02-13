<?php

namespace Database\Factories;

use App\Models\ProductList;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductListFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductList::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->unique()->sentence(2);
        $sale = [0, 10, 20];
        return [
            'name'  => $name,
            'slug'  => Str::slug($name, '-'),
            'price' => rand(2, 9) . '0000',
            'sale'  => $sale[rand(0, 2)],
            'label' => null,
            'description' => '<p>' . $this->faker->realText(500, 2) . '</p>',
            'status' => 1,
            'special' => rand(0, 1),
            'ordering' => 0,
            'video' => 'https://www.youtube.com/embed/2FG_uOMcnAQ',
        ];
    }
}
