<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \DB::table('students')->insert([[
            'id' => '1',
            'name' => 'John Doe',
            'age' => 18,
            'gender' => 'm',
            'reporting_teacher_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ],
            [
                'id' => '2',
                'name' => 'Mary',
                'age' => 22,
                'gender' => 'f',
                'reporting_teacher_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]],
        );
    }
}
