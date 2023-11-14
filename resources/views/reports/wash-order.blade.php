<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        .header {
            width: 100%;
            border-collapse: collapse;
        }

        table.body {
            width: 100%;
            height: 80%;
            border: 1px solid black;
            border-radius: 10px;

            padding: 10px;
        }

        .table-detail {
            height: 40px;
            background-color: #ecb9b9;
            text-align: center;
        }

        .table-detail-headers {
            background-color: #fdefc8;
            text-align: center;
        }

        .header td {
            padding: 5px;
        }

        .logo {
            width: 150px;
        }

        .title {
            font-size: 22px;
            font-weight: bold;
        }

        .code {
            font-size: 18px;
            font-weight: 400;
        }
    </style>
</head>

<body>
    <table class="header">
        <tr>
            <td><img class="logo" src="{{ asset('images/logo.jpg') }}" alt="Logo"></td>
            <td class="title">FICHA LAVADO</td>
            <td class="code">N° {{ $washOrder->code }}</td>
        </tr>
    </table>

    <table class="body">
        <tr>
            <td colspan="2"><b>Cliente:</b> {{ $client->fullname }}</td>
            <td colspan="2"><b>Fecha:</b> {{ $washOrder->date->format('d/m/Y') }}</td>
            <td colspan="2"><b>Tipo Lavado:</b> {{ $washOrder->washType->name }}</td>
        </tr>
        <tr>
            <td colspan="6"><b>Observaciones: </b> {{ $washOrder->observations }}</td>
        </tr>
        <tr class="table-detail">
            <td colspan="6"><b>DETALLES</b></td>
        </tr>
        <tr class="table-detail-headers">
            <td><b>Tipo</b></td>
            <td><b>Tam.</b></td>
            <td><b>Cantidad</b></td>
            <td><b>Focalizado</b></td>
            <td><b>Nevado</b></td>
            <td><b>Efectos</b></td>
        </tr>
        @foreach ($details as $detail)
            <tr>
                <td>{{ $detail->clothType->name }}</td>
                <td>{{ $detail->clothSize->name }}</td>
                <td>{{ $detail->quantity }}</td>
                <td>{{ $detail->is_focalizado_active ? 'SI' : 'NO' }}</td>
                <td>{{ $detail->is_nevado_active ? 'SI' : 'NO' }}</td>
                <td>
                    <ul>
                        @foreach ($detail->effects as $effect)
                            <li>{{ $effect->name }}</li>
                        @endforeach
                    </ul>
                </td>
            </tr>
        @endforeach
    </table>
</body>

</html>
