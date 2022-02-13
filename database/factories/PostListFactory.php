<?php

namespace Database\Factories;

use App\Models\PostList;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostListFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PostList::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence(4);
        return [
            'title'         => $title,
            'slug'          => Str::slug($title, '-'),
            'description'   => 'Mô tả của bài viết',
            'content'       => '<p>' . $this->faker->realText(1500, 5) . '</p>',
            'status'        => 1,
            'special'       => rand(0, 1),
            'ordering'      => 0,
            'keyword'       => '',
            'image'         => 'post' . rand(1, 10) . '.jpg',
            'author_id'     => 1,
            'author_name'   => 'ADMIN',
        ];
    }
}
