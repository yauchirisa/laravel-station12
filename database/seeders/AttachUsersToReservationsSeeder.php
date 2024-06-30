<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Reservation;
use Illuminate\Database\Seeder;

class AttachUsersToReservationsSeeder extends Seeder
{
    public function run()
    {

        $users = User::all();

        Reservation::all()->each(function ($reservation) use ($users) {
            $randomUser = $users->random();
            $reservation->user_id = $randomUser->id;
            $reservation->save();
        });
    }
}
