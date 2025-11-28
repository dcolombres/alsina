<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ficha de Proyecto</title>
    <style>
        body { font-family: sans-serif; }
        h1 { font-size: 24px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Ficha de Proyecto: {{ $proyecto['nombre'] }}</h1>
    <table>
        @foreach($proyecto as $key => $value)
            <tr>
                <th>{{ ucfirst(str_replace('_', ' ', $key)) }}</th>
                <td>{{ is_array($value) ? json_encode($value) : $value }}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>
