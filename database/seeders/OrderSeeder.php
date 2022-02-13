<?php

namespace Database\Seeders;

use App\Models\OrderList;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // hasProducts là products() in OrderListModel 
        OrderList::factory(20)->hasProducts(rand(1, 4))->create();
    }
}
