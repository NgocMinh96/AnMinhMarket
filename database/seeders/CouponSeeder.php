<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = date("Y-m-d");
        Coupon::create([
            'name' => 'Mã giảm đơn hàng >= 100k',
            'coupon' => 'GIAM10',
            'amount'    => 10000,
            'condition' =>  100000,
            'start_at' => date('Y-m-d 00:00:00', strtotime($date)),
            'end_at' => date('Y-m-d 23:59:59', strtotime($date . '+ 7days'))
        ]);
    }
}
