<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Movie</title>
</head>
<body>

    <div class="post-search-form col-md-6">
        <form class="form-inline" action="{{ route('lists.index') }}" method="GET">
            <div class="form-group">
                <input type="text" name="keyword"  class="form-control" placeholder="キーワードを入力">
            </div>
            <input type="radio" checked>すべて
            <input type="radio" name="is_showing" id="show" value="1"> 公開中
            <input type="radio" name="is_showing" id="will_show" value="0"> 公開予定
            </div>
          <input type="submit" value="検索" class="btn btn-info">
        </form>
        </div>

        <!-- ログインとユーザー登録のリンク -->
        <div class="auth-links">
            @guest
                <a href="{{ route('login') }}">ログイン</a>
                <a href="{{ route('register') }}">ユーザー登録</a>
            @else
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
            @csrf
                <button type="submit">ログアウト</button>
            </form>
            @endguest
        </div>


    <table>
        @foreach ($lists as $list)
        <tr>
            <td>{{ $list->id }}</td>
            <td>{{ $list->title }}</td>
            <td>{{ $list->image_url }}</td>
            <td>{{ $list->published_year }}</td>

            @if ($list->is_showing == true)
                <td>公開中</td>
            @else
                <td>公開予定</td>
            @endif

            <td>{{ $list->description }}</td>
            <td>{{ $list->genre->name }}</td>
            <td>{{ $list->created_at }}</td>
            <td>{{ $list->updated_at }}</td>
            <td><a href="{{ route('lists.show', ['id' => $list->id]) }}">詳細</a></td>
        @endforeach
        {{ $lists->links() }}
    </table>
</div>


</body>
</html>
