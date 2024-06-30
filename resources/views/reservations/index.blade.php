<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>座席予約フォーム</title>
</head>
<body>
    <h1>座席予約フォーム</h1>

    @if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

        @if (session('error'))
    <div style="color: red;">
        {{ session('error') }}
    </div>
    @endif

    <form method="post" action="{{ route('reservations.store') }}">
        @csrf
        <input type="hidden" name="movie_id" value="{{$movie_id}}">
        <input type="hidden" name="schedule_id" value="{{$schedule_id}}">
        <input type="hidden" name="date" value="{{ request()->input('date') }}">
        <input type="hidden" name="sheet_id" value="{{ request()->input('sheetId') }}">
        <input type="hidden" name="screen_id" value="{{$screen_id}}">
        <input type="hidden" name="name" value="{{ Auth::user()->name }}">
        <input type="hidden" name="email" value="{{ Auth::user()->email }}">

        @if (Auth::check())
            <p>名前：{{ Auth::user()->name }} </p>
            <p>メールアドレス: {{ Auth::user()->email }}</p>

        @else
            <p>ログインしていません。</p>
        @endif

        <button type="submit">予約する</button>
    </form>
</body>
</html>
