<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>座席表</title>
</head>

<body>

    <div class="auth-links">
        @guest
            <a href="{{ route('login') }}">ログイン</a>
            <a href="{{ route('register') }}">ユーザー登録</a>
        @else
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">ログアウト</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        @endguest
    </div>

    <table>
        <tbody>
            @foreach ($sheets->chunk(5) as $row)
                <tr>
                    @foreach ($row as $sheet)
                        <td>{{ $sheet->row }}-{{ $sheet->column }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
