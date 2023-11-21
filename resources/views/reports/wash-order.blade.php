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

        table.order-description {
            width: 100%;
            height: 10%;
            max-height: 10%;

            border: 1px solid black;
            border-radius: 10px;

            padding: 10px;
        }

        table.order-detail {
            margin-top: 10px;

            width: 100%;

            height: 72%;
            max-height: 72%;

            border: 1px solid black;
            border-radius: 10px;
        }

        table.order-total {
            margin-top: 10px;

            width: 100%;

            height: 5%;
            max-height: 5%;

            border: 1px solid black;
            border-radius: 10px;

            padding: 10px;
        }

        .table-detail {
            height: 40px;
            text-align: center;
        }

        .table-detail-headers {
            text-align: center;
        }

        tr.table-detail-row {
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
            font-size: 22px;
            font-weight: 500;
        }

        .order-observations {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
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

    <div class="detail">
        <table class="order-description">
            <tr>
                <td colspan="3"><b>Cliente:</b> {{ $client->fullname }}</td>
                <td colspan="2"><b>Fecha:</b> {{ $washOrder->date->format('d/m/Y') }}</td>
                <td colspan="2"><b>Tipo Lavado:</b> {{ $washOrder->washType->name }}</td>
            </tr>
            <tr>
                <td class="order-observations" colspan="7"><b>Observaciones: </b> {{ $washOrder->observations }}</td>
            </tr>
        </table>
        <table class="order-detail">
            <tr class="table-detail">
                <td colspan="7"><b>DETALLES</b></td>
            </tr>
            <tr class="table-detail-headers">
                <td><b>Tipo</b></td>
                <td><b>Tam.</b></td>
                <td><b>Focalizado</b></td>
                <td><b>Nevado</b></td>
                <td><b>Precio U. (Bs.)</b></td>
                <td><b>Cantidad</b></td>
                <td><b>Subtotal (Bs.)</b></td>
            </tr>
            @foreach ($details as $detail)
                <tr class="table-detail-row">
                    <td>{{ $detail->clothType->name }}</td>
                    <td>{{ $detail->clothSize->name }}</td>
                    <td>{{ $detail->is_focalizado_active ? 'SI' : 'NO' }}</td>
                    <td>{{ $detail->is_nevado_active ? 'SI' : 'NO' }}</td>
                    <td>{{ $detail->unit_price }}</td>
                    <td>{{ $detail->quantity }}</td>
                    <td>{{ $detail->subtotal_price }}</td>
                </tr>
                <tr class="table-detail-row">
                    <td colspan="1"><b>Efectos:</b></td>
                    <td colspan="6">
                        @foreach ($detail->effects as $key => $effect)
                            {{ $effect->name }}
                            @if ($key < $detail->effects->count() - 1)
                                {{ ',' }}
                            @endif
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </table>
        <table class="order-total">
            <tr>
                <td style="width: 76%"><b>TOTALES</b></td>
                <td style="width: 12%"><b>{{ $washOrder->total_quantity }}</b></td>
                <td style="width: 12%"><b>{{ $washOrder->total_price }}</b></td>
            </tr>
        </table>
    </div>
</body>

</html>
