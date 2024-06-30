<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>スクリーン一覧</title>
</head>
<body>
    <h1>スクリーン一覧</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>映画</th>
                <th>スケジュール</th>
                <th>座席</th>
                <th>名前</th>
                <th>作成日時</th>
                <th>更新日時</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($screens as $screen)
            <tr>
                <td>{{ $screen->id }}</td>
                <td>{{ $screen->movie_id }}</td>
                <td>{{ $screen->schedule_id }}</td>
                <td>{{ $screen->sheet_id }}</td>
                <td>{{ $screen->name }}</td>
                <td>{{ $screen->created_at }}</td>
                <td>{{ $screen->updated_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
