<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\PracticeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\SheetController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ScreenController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Models\Movie;

// Route::get('URL', [Controllerの名前::class, 'Controller内のfunction名']);
Route::get('/practice', [PracticeController::class, 'sample']);
Route::get('/practice2', [PracticeController::class, 'sample2']);
Route::get('/practice3', [PracticeController::class, 'sample3']);
Route::get('/getPractice', [PracticeController::class, 'getPractice']);

//一覧画面の表示
Route::get('/movies', [MovieController::class, 'index'])->name('lists.index');

//管理画面の表示
Route::get('/admin/movies', [MovieController::class, 'admin'])->name('lists.admin');

//新規登録画面
Route::get('/admin/movies/create', [MovieController::class, 'create'])->name('lists.create');

//新規登録送信
Route::post('/admin/movies/store', [MovieController::class, 'store'])->name('lists.store');

// 編集画面
Route::get('/admin/movies/{id}/edit', [MovieController::class, 'edit'])->name('lists.edit');

// 更新
Route::patch('/admin/movies/{id}/update', [MovieController::class, 'update'])->name('lists.update');

// 削除
Route::delete('/admin/movies/{id}/destroy', [MovieController::class, 'destroy'])->name('lists.destroy');

//検索
Route::get('/movies', [MovieController::class, 'index'])->name('lists.index');

//詳細
Route::get('/movies/{id}', [MovieController::class, 'show'])->name('lists.show');

//管理画面詳細
Route::get('/admin/movies/{id}', [MovieController::class, 'AdminShow'])->name('lists.admin_show');



//スケジュール
Route::get('/schedules', [ScheduleController::class, 'index'])->name('schedules.index');

//スケジュール一覧
Route::get('/admin/schedules', [ScheduleController::class, 'index'])->name('schedules.index');

//スケジュール詳細
Route::get('/admin/schedules/{id}', [ScheduleController::class, 'show'])->name('schedules.show');

//スケジュール新規登録画面
Route::get('/admin/movies/{id}/schedules/create', [ScheduleController::class, 'create'])->name('schedules.create');

//スケジュール新規登録送信
Route::post('/admin/movies/{id}/schedules/store', [ScheduleController::class, 'store'])->name('schedules.store');

//スケジュール編集画面
Route::get('/admin/schedules/{scheduleId}/edit', [ScheduleController::class, 'edit'])->name('schedules.edit');

//スケジュール削除
Route::delete('/admin/schedules/{id}/destroy', [ScheduleController::class, 'destroy'])->name('schedules.destroy');

//スケジュール更新
Route::patch('/admin/schedules/{id}/update', [ScheduleController::class, 'update'])->name('schedules.update');





//座席表
Route::get('/sheets', [SheetController::class, 'index'])->name('sheets.index')->middleware('auth.user');

//座席予約
Route::get('/movies/{movie_id}/schedules/{schedule_id}/sheets', [SheetController::class, 'reserve'])->name('sheets.reserve')->middleware('auth.user');



//予約フォーム
Route::get('/movies/{movie_id}/schedules/{schedule_id}/reservations/create', [ReservationController::class, 'create'])->name('reservations.index');

//予約登録
Route::post('/reservations/store', [ReservationController::class, 'store'])->name('reservations.store')->middleware('auth');

//予約管理画面
Route::get('/admin/reservations', [ReservationController::class, 'show'])->name('reservations.show')->middleware('auth');

//管理画面-予約追加フォーム
Route::get('/admin/reservations/create', [ReservationController::class, 'AdminCreate'])->name('reservations.AdminCreate');

//管理画面-予約追加実行
Route::post('/admin/reservations', [ReservationController::class, 'AdminStore'])->name('reservations.AdminStore');

//管理画面-予約編集フォーム
Route::get('/admin/reservations/{id}/edit', [ReservationController::class, 'edit'])->name('reservations.edit');

//管理画面-予約編集実行
Route::patch('/admin/reservations/{id}', [ReservationController::class, 'Update'])->name('reservations.update');

//管理画面-予約削除
Route::delete('/admin/reservations/{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');



//スクリーン
Route::get('/screens', [ScreenController::class, 'index'])->name('screens.index');



//ユーザー登録
Route::get('/users/create', [RegisteredUserController::class, 'create'])->name('register');

Route::post('/users/create', [RegisteredUserController::class, 'store'])->name('register.store');



//ユーザーログイン
Route::get('/users/login', [AuthenticatedSessionController::class, 'create'])->name('login');

Route::post('/users/login/store', [AuthenticatedSessionController::class, 'store'])->name('login.store');


//ログアウト
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
