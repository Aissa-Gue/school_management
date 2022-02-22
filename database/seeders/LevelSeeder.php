<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('levels')->insert([
            [
                'id' => 1,
                'name' => '1 Année Primaire',
            ],
            [
                'id' => 2,
                'name' => '2 Année Primaire',
            ],
            [
                'id' => 3,
                'name' => '3 Année Primaire',
            ],
            [
                'id' => 4,
                'name' => '4 Année Primaire',
            ],
            [
                'id' => 5,
                'name' => '5 Année Primaire',
            ],
            [
                'id' => 6,
                'name' => '1 Année Moyenne',
            ],
            [
                'id' => 7,
                'name' => '2 Année Moyenne',
            ],
            [
                'id' => 8,
                'name' => '3 Année Moyenne',
            ],
            [
                'id' => 9,
                'name' => '4 Année Moyenne',
            ],
            [
                'id' => 10,
                'name' => '1 Année secondaire',
            ],
            [
                'id' => 11,
                'name' => '2 Année secondaire',
            ],
            [
                'id' => 12,
                'name' => '3 Année secondaire',
            ],
        ]);
    }
}
