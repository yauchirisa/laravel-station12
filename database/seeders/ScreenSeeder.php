<?php

namespace Database\Seeders;

use App\Models\Screen;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ScreenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('screens')->insert([
            ['id' => 1, 'name' => 'Screen 1'],
            ['id' => 2, 'name' => 'Screen 2'],
            ['id' => 3, 'name' => 'Screen 3'],
        ]);

    }

}
