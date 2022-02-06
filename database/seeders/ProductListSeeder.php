<?php

namespace Database\Seeders;

use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Models\ProductList;

class ProductListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 12; $i++) {
            $product = ProductList::create([
                'name'          => 'Sản phẩm ' . $i,
                'slug'          => 'san-pham-' . $i,
                'price'         => rand(2, 9) . '0000',
                'sale'          => 0,
                'label'         => '',
                'description'   => '',
                'status'        => 1,
                'special'       => 0,
                'video'         => ''
            ]);
            $product->categories()->attach(1);
            $image = ProductImage::create([
                'image' => 'sp' . $i . '.jpg',
                'ordering' => 0,
            ]);
            $image->products()->attach($product->id);
        }
    }
}
