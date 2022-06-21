<?php

namespace Database\Seeders;

use App\Http\Requests\StudentMarkPostRequest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TeacherSeeder::class);
        $this->call(SubjectSeeder::class);
        $this->call(StudentSeeder::class);
        $this->call(StudentMarkSeeder::class);
    }
}
