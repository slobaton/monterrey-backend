<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
</head>

<body>
    <h2>Lista de Clientes</h2>

    <hr>

    <h3>Usuario: {{ $userId }}</h3>

    <hr>

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellidos</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clients as $client)
                <tr>
                    <td>{{ $client->name }}</td>
                    <td>{{ $client->paternal_surname }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
