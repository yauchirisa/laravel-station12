<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Movie;
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
        /*
        $schedule1 = Schedule::create([
            'movie_id' => $id,
            'start_time' => Carbon::now(),
            'end_time' => Carbon::now()->addHours(2),
        ]);
        */
        return view('schedules.show', compact('schedule'));
    }

    //スケジュール編集
    public function edit($scheduleId)
    {
        $schedule = Schedule::findOrFail($scheduleId);
        return view('schedules.edit', compact('schedule'));
    }

    //スケジュール更新
    public function update(UpdateScheduleRequest $request, $id)
    {
        $schedule = Schedule::findOrFail($id);
        $movieId = $schedule->movie_id;

        $startTime = new Carbon($request->start_time_time);
        $endTime = new Carbon($request->end_time_time);

        /*if($startTime->gte($endTime)) {
            return redirect()
                    ->route('schedules.edit', ['scheduleId' => $id])
                    ->with(['error' => '時間の設定を確認してください。']);
        }

        $diffInMinutes = $endTime->diffInMinutes($startTime);

        if($diffInMinutes < 5) {
            return redirect()
                    ->route('schedules.edit', ['scheduleId' => $id])
                    ->with(['error' => '5分以上間隔をあけてください。']);
        }*/

        $startTime = $request->input('start_time_date') . ' ' . $request->input('start_time_time');
        $endTime = $request->input('end_time_date') . ' ' . $request->input('end_time_time');

        $schedule->start_time = Carbon::parse($startTime);
        $schedule->end_time = Carbon::parse($endTime);

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
        return view('schedules.create', compact('movie'));
    }


    //スケジュール作成処理
    public function store(CreateScheduleRequest $request, $movieId)
    {
        /*$startTime = new Carbon($request->start_time_time);
        $endTime = new Carbon($request->end_time_time);

        if($startTime->gte($endTime)) {
            return redirect()
                    ->route('schedules.create', ['id' => $movieId])
                    ->with(['error' => '時間の設定を確認してください。']);
        }

        $diffInMinutes = $endTime->diffInMinutes($startTime);

        if($diffInMinutes < 5) {
            return redirect()
                    ->route('schedules.create', ['id' => $movieId])
                    ->with(['error' => '5分以上間隔をあけてください。']);
        }*/

        Schedule::insert([
            'movie_id' => $request->movie_id,
            'start_time' => $request->start_time_date . ' ' . $request->start_time_time,
            'end_time' => $request->end_time_date . ' ' . $request->end_time_time,
        ]);

        return redirect()->route('lists.admin_show', ['id' => $movieId])->with('success', '新しいスケジュールが作成されました！');
    }
}
