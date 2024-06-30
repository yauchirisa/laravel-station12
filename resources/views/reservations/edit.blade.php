<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>予約編集</title>
</head>
<body>
    <h1>予約編集</h1>

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

    <form method="POST" action="{{ route('reservations.update', ['id' => $reservation->id]) }}">
        @csrf
        @method('PATCH')

        <label for="schedule_id">スケジュール:</label>
        <select id="schedule_id" name="schedule_id" required>
            <option value="">選択してください</option>
            @foreach ($schedules as $schedule)
                <option value="{{ $schedule->id }}" data-movie-id="{{ $schedule->movie_id }}" data-movie-title="{{ $schedule->movie->title }}"
                    {{ old('schedule_id', $reservation->schedule_id) == $schedule->id ? 'selected' : '' }}>
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
                <option value="{{ $sheet->id }}" {{ old('sheet_id', $reservation->sheet_id) == $sheet->id ? 'selected' : '' }}>
                    {{ strtoupper($sheet->row.$sheet->column) }}
                </option>
            @endforeach
        </select>
        <br>

        <label for="date">日付:</label>
        <input type="date" id="date" name="date" value="{{ old('date', $reservation->schedule->start_time->format('Y-m-d')) }}" required>
        <br>

        <label for="user_id">予約者:</label>
        <select id="user_id" name="user_id" required>
            <option value="">選択してください</option>
            @foreach ($users as $userId => $userName)
                <option value="{{ $userId }}" {{ old('user_id', $reservation->user_id) == $userId ? 'selected' : '' }}>
                    {{ $userName }} - {{ \App\Models\User::findOrFail($userId)->email }}
                </option>
            @endforeach
        </select>
        <br>


        <button type="submit">更新</button>
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
