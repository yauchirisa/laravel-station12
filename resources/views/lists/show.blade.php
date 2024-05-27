<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>detail</title>
</head>
<body>
    <h1>詳細ページ</h1>
        <p>{{ $movie->title }}</p>
        <p><img src="{{ $movie->image_url }}"></p>
        <p>{{ $movie->published_year }}</p>
        @if ($movie->is_showing == true)
            <td>上映中</td>
        @else
            <td>上映予定</td>
        @endif

        <p>{{ $movie->description }}</p>
        <p>{{ $movie->created_at }}</p>
        <p>{{ $movie->updated_at }}</p>

        <p>
        <ul>
            @foreach ($schedules as $schedule)
                <li>{{ $schedule->start_time->format('H:i') }} - {{ $schedule->end_time->format('H:i') }}</li>
            @endforeach
        </ul>

        <a href='{{ route("lists.index") }}'>戻る</a>
        </p>
</div>


</body>
</html>
