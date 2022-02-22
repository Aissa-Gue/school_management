<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserPortalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_portals')->insert([
            [
                'user_id' => 1,
                'portal_id' => 1,
            ],
            [
                'user_id' => 1,
                'portal_id' => 2,
            ],
            [
                'user_id' => 1,
                'portal_id' => 3,
            ],
            [
                'user_id' => 1,
                'portal_id' => 4,
            ],
            [
                'user_id' => 1,
                'portal_id' => 5,
            ],
            [
                'user_id' => 1,
                'portal_id' => 6,
            ],
            [
                'user_id' => 1,
                'portal_id' => 7,
            ],
            [
                'user_id' => 1,
                'portal_id' => 8,
            ],
            [
                'user_id' => 1,
                'portal_id' => 9,
            ],
            [
                'user_id' => 1,
                'portal_id' => 10,
            ],
        ]);
    }
}
