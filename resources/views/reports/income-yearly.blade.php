<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Incomes</title>
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
            font-size: 16px;
            line-height: 0.5;
            font-weight: bold;
            text-align: center;
        }

        .subtitle {
            font-size: 13px;
            line-height: 0.5;
            text-align: center;
        }

        .table-title {
            font-size: 14px;
            line-height: 0.5;
            font-weight: bold;
            text-align: center;
        }

        .table-subtitle {
            font-size: 12px;
            line-height: 0.5;
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
            <td class="title">INGRESOS ANUALES {{ $year }}</td>
        </tr>
        <tr>
            <td class="subtitle">
                TOTAL INGRESOS: {{ $total_income }} - TOTAL REAL: {{ $total_real_income }} - PERDIDAS:
                {{ $lost_income }}
            </td>
        </tr>
        <tr>
            <td class="subtitle">(Expresado en Dolares Americanos)</td>
        </tr>
    </table>

    <div class="container">
        <div class="detail">
            <table class="account-movements">
                <thead>
                    <th style="width: 15%">FECHA</th>
                    <th style="width: 15%">RECIBO</th>
                    <th style="width: 40%">DETALLE</th>
                    <th style="width: 15%">MONTO</th>
                    <th style="width: 15%">TOTAL</th>
                </thead>
                <tbody>
                    @foreach ($incomes as $income)
                        <tr class="table-detail-row">
                            <td>{{ $income['date'] }}</td>
                            <td>{{ $income['receipt_number'] }}</td>
                            <td>{{ $income['concept'] }}</td>
                            <td>{{ $income['amount'] }}</td>
                            <td>{{ $income['sub_total'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
