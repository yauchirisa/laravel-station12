<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>上映スケジュール</title>
</head>
<body>
    <h1>Schedule List</h1>
    <tr>
    @foreach ($schedules as $schedule)
        <h2>{{ $schedule->movie->title }} (Movie_ID: {{ $schedule->movie->id }})</h2>
        <td>Start Time: {{ $schedule->start_time }}</td> -
        <td>End Time: {{ $schedule->end_time }}</td>
        <td><a href="{{ route('schedules.show', ['id' => $schedule->id]) }}">詳細</a></td>
    @endforeach
</table>


</body>
</html>
