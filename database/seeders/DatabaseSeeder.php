<?php

namespace Database\Seeders;
use App\Practice;
use App\Models\Movie;

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

    }


}
