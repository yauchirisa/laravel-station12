<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>座席表</title>
</head>
<body>
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
