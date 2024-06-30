<?php

namespace App\Http\Controllers;
use App\Models\Sheet;
use App\Models\Reservation;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SheetController extends Controller
{
    public function index()
    {
        $sheets = Sheet::all();
        return view('sheets.index', compact('sheets'));
    }


    public function reserve(Request $request, $movie_id, $schedule_id)
    {
        if(empty($request->date)) {
            return abort(400);
        }

        // 予約済みの座席を取得
        $reservedSeats = Reservation::where('schedule_id', $schedule_id)->where('is_canceled', false)->pluck('sheet_id')->toArray();

        $unavailableSeats = Sheet::whereNotIn('id', $reservedSeats)->pluck('id')->toArray();

        $availableSheets = Sheet::whereIn('id', $unavailableSeats)->get();

        $date = $request->date;

        $sheets = Sheet::all();

        return view('sheets.reserve', compact('availableSheets', 'reservedSeats', 'movie_id', 'schedule_id', 'date', 'sheets'));
    }




    /*public function reserve(Request $request, $movie_id, $schedule_id)
    {
        if(empty($request->date)) {
            return App::abort(400);
        }
        $sheets = Sheet::all();

        return view('sheets.reserve', ['sheets' => $sheets, 'movie_id' => $movie_id, 'schedule_id' => $schedule_id, 'date' => CarbonImmutable::now()]);
    }*/


}
