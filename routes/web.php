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
