<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('teachers')->insert([[
                'id' => 1,
                'name' => 'Katie',
            ],
            [
                'id' => 2,
                'name' => 'Max',
            ]]
        );
    }
}
