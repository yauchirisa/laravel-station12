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

    <form method="post" action="{{ route('reservations.AdminStore') }}">
        @csrf

        <label for="schedule_id">スケジュール:</label>
        <select id="schedule_id" name="schedule_id" required>
            <option value="">選択してください</option>
            @foreach ($schedules as $schedule)
                <option value="{{ $schedule->id }}" data-movie-id="{{ $schedule->movie_id }}" data-movie-title="{{ $schedule->movie->title }}"
                    {{ old('schedule_id', isset($input['schedule_id']) ? $input['schedule_id'] : '') == $schedule->id ? 'selected' : '' }}>
                    {{ $schedule->movie->title }} - {{ $schedule->start_time }} ~ {{ $schedule->end_time }}
                </option>
            @endforeach
        </select>
        <br>

        <input type="hidden" id="movie_id" name="movie_id" value="{{ old('movie_id', isset($input['movie_id']) ? $input['movie_id'] : '') }}">

        <label for="sheet_id">座席:</label>
        <select id="sheet_id" name="sheet_id" required>
            <option value="">選択してください</option>
            @foreach ($sheets as $sheet)
                <option value="{{ $sheet->id }}" {{ old('sheet_id', isset($input['sheet_id']) ? $input['sheet_id'] : '') == $sheet->id ? 'selected' : '' }}>
                    {{ strtoupper($sheet->row.$sheet->column) }}
                </option>
            @endforeach
        </select>
        <br>

        <label for="date">日付:</label>
        <input type="date" id="date" name="date" value="{{ old('date', isset($input['date']) ? $input['date'] : '') }}" required>
        <br>


        <label for="user_id">予約者:</label>
        <select id="user_id" name="user_id" required>
            <option value="">選択してください</option>
            @foreach ($users as $userId => $userData)
                <option value="{{ $userId }}" {{ old('user_id', isset($input['user_id']) ? $input['user_id'] : '') == $userId ? 'selected' : '' }}>
                    {{ $userData['name'] }} - {{ $userData['email'] }}
                </option>
            @endforeach
        </select>
        <br>



        <button type="submit">追加</button>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var scheduleSelect = document.getElementById('schedule_id');
            var movieIdInput = document.getElementById('movie_id');

            // 初期選択時の movie_id 設定
            if (scheduleSelect.value !== '') {
                var selectedOption = scheduleSelect.options[scheduleSelect.selectedIndex];
                var movieId = selectedOption.getAttribute('data-movie-id');
                movieIdInput.value = movieId;
            }

            // スケジュールが変更されたときの処理
            scheduleSelect.addEventListener('change', function() {
                var selectedOption = scheduleSelect.options[scheduleSelect.selectedIndex];
                var movieId = selectedOption.getAttribute('data-movie-id');
                movieIdInput.value = movieId;
            });
        });
    </script>

</body>
</html>
