<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Account Movements</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        .header {
            width: 100%;
            border-collapse: collapse;
        }

        .header td {
            padding: 5px;
        }

        .title {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
        }

        .subtitle {
            font-size: 14px;
            text-align: center;
        }

        .detail {
            margin-top: 20px;
        }

        .container {
            page-break-after: always;
        }

        .container:last-child {
            page-break-after: unset;
        }

        table.account-movements {
            width: 100%;

            border: 1px solid black;
            border-collapse: collapse;
        }

        table.account-movements thead>th,
        table.account-movements tbody>tr>td {
            border: 1px solid black;
            padding: 2px;
        }

        table.account-movements thead>th {
            text-align: center;

            font-size: 12px;
        }

        tr.table-detail-row {
            font-size: 11px;
        }
    </style>
</head>

<body>
    <table class="header">
        <tr>
            <td class="title">ESTADO DE CUENTA: {{ $client->fullname }}</td>
        </tr>
        <tr>
            <td class="subtitle">(Expresado en Dolares Americanos)</td>
        </tr>
    </table>

    <div class="container">
        @foreach ($processedMovements as $processedMovement)
            <div class="detail">
                <div class="month-info">
                    <table class="header">
                        <tr>
                            <td class="title">{{ $processedMovement['monthHeader'] }}</td>
                        </tr>
                        <tr>
                            <td class="subtitle">Saldo mes anterior: {{ $processedMovement['monthBalanceDebt'] }}</td>
                        </tr>
                    </table>
                </div>
                <table class="account-movements">
                    <thead>
                        <th style="width: 9%">FECHA</th>
                        <th style="width: 4%">TIPO</th>
                        <th style="width: 6%">NR</th>
                        <th style="width: 8%">PRENDA</th>
                        <th style="width: 4%">TAM.</th>
                        <th style="width: 32%">DETALLE</th>
                        <th style="width: 6%">CANT.</th>
                        <th style="width: 6%">P/U</th>
                        <th style="width: 8%">TOTAL</th>
                        <th style="width: 8%">PAGO/C</th>
                        <th style="width: 9%">SALDO</th>
                    </thead>
                    <tbody>
                        @foreach ($processedMovement['monthItems'] as $processedItem)
                            <tr class="table-detail-row">
                                <td>{{ $processedItem['date'] }}</td>
                                <td>DD</td>
                                <td>{{ $processedItem['receipt_number'] }}</td>
                                <td>{{ $processedItem['cloth_type'] }}</td>
                                <td>{{ $processedItem['cloth_size'] }}</td>
                                <td>{{ $processedItem['description'] }}</td>
                                <td>{{ $processedItem['quantity'] }}</td>
                                <td>{{ $processedItem['unit_price'] }}</td>
                                <td>{{ $processedItem['subtotal_price'] }}</td>
                                <td>{{ $processedItem['amount'] }}</td>
                                <td>{{ $processedItem['balance_debt'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
    </div>
</body>

</html>
