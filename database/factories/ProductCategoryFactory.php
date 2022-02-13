<?php

namespace Database\Factories;

use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = 'Danh Mục ' . $this->faker->word() . rand(1, 9);
        return [
            'name' => $name,
            'slug' => Str::slug($name, '-'),
            'status' => 1,
        ];
    }
}
