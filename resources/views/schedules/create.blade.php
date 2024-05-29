<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>新規スケジュール</title>
</head>
<body>
    <h1>新規スケジュール</h1>

    <form action="{{ route('schedules.store', ['id' => $movie->id]) }}" method="POST">
        @foreach ($errors->all() as $error)
        {{$error}}<br>
        @endforeach
        @if (session('time_error'))
        {{ session('time_error') }}<br>
        @endif
        @csrf

        <input type="hidden" name="movie_id" value="{{ $movie->id }}">

        <label for="start_time_date">開始日:</label>
        <input type="date" id="start_time_date" name="start_time_date" required>
        <label for="start_time_time">開始時間:</label>
        <input type="time" id="start_time_time" name="start_time_time" required><br><br>

        <label for="end_time_date">終了日:</label>
        <input type="date" id="end_time_date" name="end_time_date" required>
        <label for="end_time_time">終了時間:</label>
        <input type="time" id="end_time_time" name="end_time_time" required><br><br>

        <button type="submit">作成</button>
    </form>
</body>
</html>
