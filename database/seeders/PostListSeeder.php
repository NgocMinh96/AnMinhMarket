<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PostList;

class PostListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // for ($i = 1; $i <= 10; $i++) {
        //     PostList::create([
        //         'title'         => 'Tiêu đề bài viết số ' . $i,
        //         'slug'          => 'tieu-de-bai-viet-so-' . $i,
        //         'description'   => 'Mô tả của bài viết',
        //         'content'       => '<p>Nội dung của bài viết</p>',
        //         'status'        => 1,
        //         'special'       => rand(0, 1),
        //         'ordering'      => 0,
        //         'keyword'       => '',
        //         'image'         => 'post' . $i . '.jpg',
        //         'author_id'     => 1,
        //         'author_name'   => 'ADMIN',
        //     ]);
        // }

        PostList::factory(50)->create();
    }
}
