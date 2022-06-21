<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class StudentMarkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('student_marks')->insert([
            [
                'student_id' => 1,
                'subject_id' => 1,
                'term' => 'one',
                'marks' => 40,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'student_id' => 1,
                'subject_id' => 2,
                'term' => 'one',
                'marks' => 40,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'student_id' => 1,
                'subject_id' => 3,
                'term' => 'one',
                'marks' => 40,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'student_id' => 1,
                'subject_id' => 1,
                'term' => 'two',
                'marks' => 30,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'student_id' => 1,
                'subject_id' => 2,
                'term' => 'two',
                'marks' => 45,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'student_id' => 1,
                'subject_id' => 3,
                'term' => 'two',
                'marks' => 49,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],

            [
                'student_id' => 2,
                'subject_id' => 1,
                'term' => 'two',
                'marks' => 50,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'student_id' => 2,
                'subject_id' => 2,
                'term' => 'two',
                'marks' => 50,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'student_id' => 2,
                'subject_id' => 3,
                'term' => 'two',
                'marks' => 50,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);
    }
}
