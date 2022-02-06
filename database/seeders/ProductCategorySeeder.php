<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_categories')->insert([
            ['name' => 'Danh Mục 1', 'slug' => 'danh-muc-1', 'status' => 1],
            ['name' => 'Danh Mục 2', 'slug' => 'danh-muc-1', 'status' => 1],
        ]);
    }
}
