<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>座席表</title>
    <style>
        .reserved {
            background-color: #cccccc; /* グレーの背景色 */
            pointer-events: none; /* マウスイベントを無効化 */
        }
    </style>
</head>
<body>

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

    <table>
        <tbody>
            @foreach ($sheets->chunk(5) as $row)
                <tr>
                    @foreach ($row as $sheet)
                        <td>
                            @if (in_array($sheet->id, $reservedSeats))
                                <span class="reserved">{{ $sheet->row }}-{{ $sheet->column }}</span>
                            @else
                                <a href="/movies/{{$movie_id}}/schedules/{{$schedule_id}}/reservations/create?date={{ $date }}&sheetId={{ $sheet->id }}">
                                    {{ $sheet->row }}-{{ $sheet->column }}
                                </a>
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
