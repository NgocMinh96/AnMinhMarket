<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            SeetingSeeder::class,
            RolePermissionSeeder::class,
            PostListSeeder::class,
            ProductCategorySeeder::class,
            ProductListSeeder::class,
            CouponSeeder::class,
            OrderSeeder::class,
        ]);
    }
}
