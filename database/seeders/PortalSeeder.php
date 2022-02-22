<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PortalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('portals')->insert([
            [
                'id' => 1,
                'name' => 'dashboard',
            ],
            [
                'id' => 2,
                'name' => 'students',
            ],
            [
                'id' => 3,
                'name' => 'teachers',
            ],
            [
                'id' => 4,
                'name' => 'courses',
            ],
            [
                'id' => 5,
                'name' => 'levels',
            ],
            [
                'id' => 6,
                'name' => 'classes',
            ],
            [
                'id' => 7,
                'name' => 'expenses',
            ],
            [
                'id' => 8,
                'name' => 'agenda',
            ],
            [
                'id' => 9,
                'name' => 'trash',
            ],
            [
                'id' => 10,
                'name' => 'settings',
            ],
        ]);
    }
}
