<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SheetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $masterData = [
            [1, 1, 'a'],
            [2, 2, 'a'],
            [3, 3, 'a'],
            [4, 4, 'a'],
            [5, 5, 'a'],
            [6, 1, 'b'],
            [7, 2, 'b'],
            [8, 3, 'b'],
            [9, 4, 'b'],
            [10, 5, 'b'],
            [11, 1, 'c'],
            [12, 2, 'c'],
            [13, 3, 'c'],
            [14, 4, 'c'],
            [15, 5, 'c'],
        ];

        foreach ($masterData as $data) {
            DB::table('sheets')->insert([
                'id' => $data[0],
                'column' => $data[1],
                'row' => $data[2],
            ]);
        }
    }
}
