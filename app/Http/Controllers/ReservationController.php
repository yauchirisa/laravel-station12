<?php

namespace App\Http\Controllers;
use App\Models\Reservation;
use App\Models\Sheet;
use App\Models\Schedule;
use App\Models\Screen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateReservationRequest;
use App\Http\Requests\CreateAdminReservationRequest;
use App\Http\Requests\UpdateAdminReservationRequest;
use Illuminate\Support\Facades\App;

class ReservationController extends Controller
{
    public function create(Request $request, $movie_id, $schedule_id)
    {

        if(empty($request->date) || empty($request->sheetId)) {
            return App::abort(400);
        }

        $existingReservation = Reservation::where('schedule_id', $schedule_id)
        // ->where('date', $request->date)
        ->where('sheet_id', $request->sheetId)
        ->exists();

        if ($existingReservation) {
            return abort(400);
        }

        $schedule = Schedule::findOrFail($schedule_id);
        $screen_id = $schedule->screen_id;

        $sheets = Sheet::all();
        return view('reservations.index', ['sheets' => $sheets, 'movie_id' => $movie_id, 'schedule_id' => $schedule_id, 'screen_id' => $screen_id]);
    }


    public function store(CreateReservationRequest $request)
    {

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'ログインが必要です');
        }

            // movie_idを取得
            $movieID = Schedule::findOrFail($request->schedule_id)->movie_id;

            // 予約の重複をチェック
            $existingReservation = Reservation::where('schedule_id', $request->schedule_id)
                ->where('sheet_id', $request->sheet_id)
                ->exists();

            if ($existingReservation) {
                return redirect()->route('sheets.reserve', ['movie_id' => $movieID, 'schedule_id' => $request->schedule_id, 'date' => $request->date, 'screen_id' => $request->screen_id])
                    ->with('error', 'その座席はすでに予約済みです');
            }

        try {

            DB::beginTransaction();

            // 予約を作成
            Reservation::create([
                'schedule_id' => $request->schedule_id,
                'sheet_id' => $request->sheet_id,
                'date' => $request->date,
                'screen_id' => $request->screen_id,
                'name' => $request->name,
                'email' => $request->email,
                'user_id' => $user->id,
                'is_canceled' => false,
            ]);

            DB::commit(); // コミット
        } catch (\Exception $e) {
            DB::rollBack(); // エラー発生時にロールバック
            return redirect()->back()->withInput()->with('error', '予約に失敗しました。エラー：'.$e->getMessage());
        }

        // 予約完了ページにリダイレクト
        return redirect()->route('lists.show', ['id' => $movieID])
            ->with('success', '予約が完了しました');
    }


    //管理画面
    public function show(){

        $reservations = Reservation::whereHas('schedule', function ($query) {
            $query->whereDate('start_time', '>=', now());
        })->get();

        // ビューにデータを渡して表示
        return view('reservations.show', compact('reservations'));

    }



    //管理画面‐予約追加フォーム
    public function AdminCreate(Request $request)
    {
        $schedules = Schedule::with('movie')->get();
        $sheets = Sheet::all();
        $users = User::pluck('name', 'id')->map(function ($userName, $userId) {
            return [
                'name' => $userName,
                'email' => User::findOrFail($userId)->email,
            ];
        });

        $input = $request->session()->get('reservation_input', []);

        return view('reservations.AdminCreate', compact('schedules', 'sheets', 'users'));
    }


    //管理画面‐予約追加画面
    public function AdminStore(CreateAdminReservationRequest $request)
    {
        try {

            $user = Auth::user();


            // movie_idを取得
            $movie_id = Schedule::findOrFail($request->schedule_id)->movie_id;
            $startTime = Schedule::findOrFail($request->schedule_id)->start_time;

            // 予約の重複をチェック
            $existingReservation = Reservation::where('schedule_id', $request->schedule_id)
                ->where('sheet_id', $request->sheet_id)
                ->exists();

            if ($existingReservation) {
                $request->session()->flash('reservation_input', $request->except('_token'));

                return redirect()->route('reservations.AdminCreate')
                    ->withInput()
                    ->with('error', 'その座席はすでに予約済みです');
            }

            DB::beginTransaction();

            // 予約を作成
            $reservation =Reservation::create([
                'schedule_id' => $request->schedule_id,
                'sheet_id' => $request->sheet_id,
                'date' => $startTime,
                'screen_id' => $request->screen_id,
                'name' => $user->name,
                'email' => $user->email,
                'user_id' => $user->id,
                'is_canceled' => false,
            ]);

            DB::commit(); // コミット

            $schedules = Schedule::all();
            // 予約完了ページにリダイレクト
            return redirect()->route('reservations.show', compact('schedules', 'reservation'))
                ->with('success', '予約が完了しました');

        } catch (\Exception $e) {
            DB::rollBack(); // エラー発生時にロールバック

            return redirect()->back()->withInput()->with('error', '予約に失敗しました。エラー：'.$e->getMessage());
        }
    }




    // 管理画面‐予約編集フォーム
    public function edit($id)
    {
        $reservation = Reservation::findOrFail($id);
        $schedules = Schedule::all();
        $sheets = Sheet::all();
        $screens = Screen::all();
        $users = User::pluck('name', 'id');

        return view('reservations.edit', compact('reservation', 'schedules', 'sheets', 'screens', 'users'));
    }


    public function update(UpdateAdminReservationRequest $request, $id)
    {
        try {
            DB::beginTransaction();


            $user = Auth::user();

            // 予約を取得
            $reservation = Reservation::findOrFail($id);

            // 予約のスケジュールを更新する場合、重複をチェック
            if ($reservation->schedule_id != $request->schedule_id || $reservation->sheet_id != $request->sheet_id) {
                $existingReservation = Reservation::where('schedule_id', $request->schedule_id)
                    ->where('sheet_id', $request->sheet_id)
                    ->exists();

                if ($existingReservation) {
                    return redirect()->back()
                        ->with('error', 'その座席はすでに予約済みです')
                        ->withInput();
                }
            }

            // movie_idを取得
            $movie_id = Schedule::findOrFail($request->schedule_id)->movie_id;
            $startTime = Schedule::findOrFail($request->schedule_id)->start_time;

            // 予約情報を更新
            $reservation->update([
                'schedule_id' => $request->schedule_id,
                'sheet_id' => $request->sheet_id,
                'date' => $startTime,
                'screen_id' => $request->screen_id,
                'name' => $user->name,
                'email' => $user->email,
            ]);

            DB::commit(); // コミット
        } catch (\Exception $e) {
            DB::rollBack(); // エラー発生時にロールバック
            return redirect()->back()
                ->withInput()
                ->with('error', '予約の更新に失敗しました。エラー：' . $e->getMessage());
        }

        // 更新後の予約情報を表示するページにリダイレクト
        return redirect()->route('reservations.show', ['id' => $reservation->id])
            ->with('success', '予約を更新しました');
    }




    //削除処理
    public function destroy($id)
    {
        $reservation = Reservation::find($id);

        if (!$reservation) {
            return abort(404);
        }

        // 予約を削除
        $reservation->delete();

        return redirect('/admin/reservations')->with('message', '予約を削除しました');
    }




}
