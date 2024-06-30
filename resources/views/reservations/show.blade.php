<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>予約一覧</title>
</head>
<body>
    <h1>予約一覧</h1>

    <a href="{{ route('reservations.AdminCreate') }}">予約追加</a>

    <table>
        <thead>
            <tr>
                <th>作品</th>
                <th>座席</th>
                <th>日時</th>
                <th>スクリーン</th>
                <th>名前</th>
                <th>メールアドレス</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reservations as $reservation)
                <tr>
                    <td>{{ $reservation->schedule->movie->title }}</td>
                    <td>{{ strtoupper($reservation->sheet->row.$reservation->sheet->column) }}</td>
                    <td>{{ $reservation->schedule->start_time->format('Y-m-d H:i') }}</td>
                    <td>{{ $reservation->schedule->screen_id }}</td>
                    <td>{{ $reservation->name }}</td>
                    <td>{{ $reservation->email }}</td>
                    <td>
                        <a href="{{ route('reservations.edit', ['id' => $reservation->id]) }}">編集</a>
                        <form action="{{ route('reservations.destroy', ['id' => $reservation->id]) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">削除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
