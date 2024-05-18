<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(MovieSeeder::class);
        $this->call(SheetSeeder::class);
        $this->call(ScheduleSeeder::class);

    }


}
