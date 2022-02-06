<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


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
        ]);
    }
}
