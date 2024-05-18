<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>上映スケジュール</title>
</head>
<body>
    <ul>

        @foreach ($schedules as $schedule)
        <p>{{ $schedule->id }}</p>
        <p>{{ $schedule->movie_id }}</p>
            <li>
                <strong>Start Time:</strong> {{ $schedule->start_time }} -
                <strong>End Time:</strong> {{ $schedule->end_time }}
            </li>
        @endforeach
    </ul>
</body>
</html>
