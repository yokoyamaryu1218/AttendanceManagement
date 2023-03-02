<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            EmployeeSeeder::class,
            // DailySeeder::class,
            WorksSeeder::class,
            HierarchySeeder::class,
            OverTimeSeeder::class,
            AdminsSeeder::class,
            WorkingHoursSeeder::class,
        ]);
    }
}
