<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Genre;
use App\Models\Schedule;
use App\Http\Requests\MovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use Illuminate\Support\Facades\DB;


class MovieController extends Controller
{
    //一覧画面
    public function index(Request $request)
    {
        $lists = Movie::all();

        $keyword = $request->keyword;
        $is_showing = $request->input('is_showing');

        $query = Movie::query();

        if ($keyword = $request->input('keyword')) {
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', '%' . $keyword . '%')
                  ->orWhere('description', 'like', '%' . $keyword . '%');
            });
        }

        // 表示状態でのフィルタリング
        $is_showing = $request->input('is_showing');
        if ($is_showing === '0' || $is_showing === '1') {
            $query->where('is_showing', $is_showing);
        }

        $lists = $query->paginate(20);
        return view('lists.index', compact('lists')
    );

    }

    //管理一覧画面
    public function admin()
    {
        $lists = Movie::all();
        return view('lists.admin', compact('lists'));
    }

    //登録画面

   public function create()
   {
       return view('lists.create');
   }

   //登録処理
   public function store(UpdateMovieRequest $request)
   {
       try {
           DB::beginTransaction();

           // ジャンルを取得し、存在しない場合は新規作成
           $genreName = $request->input('genre');
           $genre = Genre::firstOrCreate(['name' => $genreName]);
           Movie::create([
            'title' => $request->title,
            'image_url' => $request->image_url,
            'published_year' => $request->published_year,
            'is_showing' => $request->is_showing,
            'description' => $request->description,
            'genre_id' => $genre->id,
           ]);

           DB::commit();
           return redirect('/admin/movies');

       } catch (\Exception $e){
           DB::rollback();
           $exceptionMessage = $e->getMessage();
           \Log::error('映画の登録中にエラーが発生しました' . $exceptionMessage);
           return response()->json(['error' => '映画の登録中にエラーが発生しました'], 500);
           //return redirect('/admin/movies/create')->with('error', '映画の登録中にエラーが発生しました');
       }

   }






   //編集画面
   public function edit($id)
   {
       $list = Movie::find($id);
       return view('lists.edit', compact('list'));
   }



     // 更新処理
     public function update(UpdateMovieRequest $request, $id)
     {
        $movie = Movie::find($id);

         try {
             DB::beginTransaction();
             $genreName = $request->input('genre');
             // ジャンルを取得する
             $genre = Genre::where('name', $genreName)->first();
             if (!$genre) {
                 // ジャンルが存在しない場合は新規作成
                 $genre = Genre::create(['name' => $genreName]);
             }
             $movie->update([
                'title' => $request->title,
                'image_url' => $request->image_url,
                'published_year' => $request->published_year,
                'is_showing' => $request->is_showing,
                'description' => $request->description,
                'genre_id' => $genre->id,
             ]);

             DB::commit();
             //$movie = Movie::all();
             //$genre = Genre::all();
             return redirect('/admin/movies');

         } catch (\Exception $e){
             DB::rollback();
             $exceptionMessage = $e->getMessage();
             \Log::error('映画の登録中にエラーが発生しました' . $exceptionMessage);
             return response()->json(['error' => '映画の更新中にエラーが発生しました'], 500);
             //return redirect()->back()->with('error', '映画の更新中にエラーが発生しました');
         }
     }



    //削除処理
    public function destroy(Request $request)
    {
        $movie = Movie::find($request->id);
        if (!$movie) {
            return abort(404);
        }

        // idを条件に該当レコードを削除
        Movie::where('id', $request->id)->delete();
        return redirect('/admin/movies')->with('message', '削除しました');
    }


    //詳細画面
    public function show(Request $request, $id)
    {
        //$movie = Movie::with('schedules')->find($id);
        //$movie = Movie::find($id);
        //$schedules = Schedule::orderBy('start_time')->get();
        //return view('lists.show', compact('movie', 'schedules'));

        $movie = Movie::find($id);
        $schedules = Schedule::where('movie_id', $id)->orderBy('start_time')->get();
        return view('lists.show', compact('movie', 'schedules'));
    }


}
