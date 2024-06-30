<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Movie;
use App\Models\Screen; // 追加
use Carbon\Carbon;
use App\Http\Requests\UpdateScheduleRequest;
use App\Http\Requests\CreateScheduleRequest;

use Illuminate\Http\Request;

class ScheduleController extends Controller
{

    //一覧
    public function index()
    {
        $schedules = Schedule::with('movie')->orderBy('movie_id')->get();
        return view('schedules.index', compact('schedules'));
    }


    //詳細
    public function show($id)
    {
        $schedule = Schedule::findOrFail($id);
        return view('schedules.show', compact('schedule'));
    }

    //スケジュール編集
    public function edit($scheduleId)
    {
        $schedule = Schedule::findOrFail($scheduleId);
        $screens = Screen::all();

        return view('schedules.edit', compact('schedule', 'screens'));
    }

    //スケジュール更新
    public function update(UpdateScheduleRequest $request, $id)
    {
        $schedule = Schedule::findOrFail($id);
        $movieId = $schedule->movie_id;

        $startTime = new Carbon($request->start_time_time);
        $endTime = new Carbon($request->end_time_time);

        $startTime = $request->input('start_time_date') . ' ' . $request->input('start_time_time');
        $endTime = $request->input('end_time_date') . ' ' . $request->input('end_time_time');
        $screenId = $request->input('screen_id');

        $schedule->start_time = Carbon::parse($startTime);
        $schedule->end_time = Carbon::parse($endTime);
        $schedule->screen_id = $screenId;

        $schedule->save();

        return redirect()->route('lists.admin_show', ['id' => $movieId]);
    }

    //スケジュール削除
    public function destroy($id)
    {

        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return redirect()->back()->with('success', 'スケジュールが削除されました');
    }


    //スケジュール作成
    public function create($movieId)
    {
        $movie = Movie::find($movieId);
        $screens = Screen::all(); // スクリーンを取得する

        return view('schedules.create', compact('movie', 'screens'));
    }


    //スケジュール作成処理
    public function store(CreateScheduleRequest $request, $movieId)
    {

        // スケジュールを作成
        Schedule::create([
            'movie_id' => $request->movie_id,
            'start_time' => $request->start_time_date . ' ' . $request->start_time_time,
            'end_time' => $request->end_time_date . ' ' . $request->end_time_time,
            'screen_id' => $request->input('screen_id'),
        ]);

        return redirect()->route('lists.admin_show', ['id' => $movieId])->with('success', '新しいスケジュールが作成されました！');
    }
}
