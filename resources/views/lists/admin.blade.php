<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Movie</title>
</head>
<body>

    <table>
        @foreach ($lists as $list)


        @if(session('message'))
        <div class="alert alert-success">{{session('message')}}</div>
        @endif

        <tr>
            <td>{{ $list->id }}</td>
            <td>{{ $list->title }}</td>
            <td>{{ $list->image_url }}</td>
            <td>{{ $list->published_year }}</td>

            @if ($list->is_showing  == true)
                <td>上映中</td>
            @else
                <td>上映予定</td>
            @endif

            <td>{{ $list->description }}</td>
            <td>{{ $list->genre->name }}</td>
            <td>{{ $list->created_at }}</td>
            <td>{{ $list->updated_at }}</td>
            <td><a href="{{ route('lists.edit', ['id' => $list->id]) }}">編集</a></td>
            <td>
                <form action="{{ route('lists.destroy', ['id' => $list->id]) }}" method="POST">
                @csrf
                @method('DELETE')
                <input type="hidden" name="movieId" Value="{{ $list->id }}"/>
                <button type="submit">削除</button>
            </form>
            </td>

            <td><a href="{{ route('lists.admin_show', ['id' => $list->id]) }}">詳細</a></td>
        </tr>
        @endforeach
    </table>
</div>
</body>
</html>
