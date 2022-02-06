<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeetingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            [
                'favicon'       => 'favicon.png',
                'logo'          => 'logo.png',
                'banner'        => 'banner.png',
                'brand'         => 'BRAND',
                'color'         => 'rgb(53, 158, 57)',
                'phone'         => '0919291260',
                'email'         => 'email@gmail.com',
                'address'       => 'address',
                'map'           => 'map',
                'facebook'      => 'facebook',
                'messenger'     => 'messenger-facebook',
                'youtube'       => 'youtube',
                'keyword'       => 'keyword, keyword'
            ],
        ]);
    }
}
