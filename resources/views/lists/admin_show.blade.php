<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AdminDetail</title>
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
        <ul>
            @foreach ($schedules as $schedule)
                <li>
                    {{ $schedule->start_time }} -
                    {{ $schedule->end_time }}
                    <a href="{{ route('schedules.show', ['id' => $schedule->id]) }}">詳細</a>
                    <a href="{{ route('schedules.edit', ['scheduleId' => $schedule->id]) }}">編集</a>
                    <form action="{{ route('schedules.destroy', ['id' => $schedule->id]) }}" method="POST" onsubmit="return confirm('本当に削除しますか？')">
                        @csrf
                        @method('DELETE')
                        <button type="submit">削除</button>
                    </form>
                </li>
            @endforeach
        </ul>
        <a href="{{ route('schedules.create', ['id' => $movie->id]) }}">スケジュール作成</a>

</div>


</body>
</html>
