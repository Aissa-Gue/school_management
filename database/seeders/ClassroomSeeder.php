<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('classrooms')->insert([
            [
                'id' => 1,
                'name' => 'class 1',
            ],
            [
                'id' => 2,
                'name' => 'class 2',
            ],
            [
                'id' => 3,
                'name' => 'class 3',
            ],
        ]);
    }
}
