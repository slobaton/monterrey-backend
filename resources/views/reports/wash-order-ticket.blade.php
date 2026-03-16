<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ficha de Lavado {{ $washOrder->code }}</title>
    <style>
        /* ======== Estilos Generales ======== */
        body {
            margin: 0;
            padding: 0;
            font-family: "Courier New", Courier, monospace;
            font-size: 11px;
            color: #000;
        }

        /* Contenedor estrecho de ~300px para simular ticket */
        #ticket {
            width: 300px;
            margin: 0 auto;
            padding: 0;
        }

        /* ======== Encabezado ======== */
        .header {
            text-align: center;
            margin-bottom: 4px;
        }

        /* Código / número de ficha: separado con bordes punteados */
        .header .codigo {
            font-size: 12px;
            font-weight: bold;
            line-height: 12px;
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            padding: 2px 0;
            margin-bottom: 4px;
        }

        /* ======== Sección de datos generales ======== */
        .info-general {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4px;
        }
        .info-general td {
            vertical-align: top;
            padding: 1px 0;
        }
        .info-general .label {
            width: 35%;
            font-weight: bold;
            text-transform: uppercase;
        }
        .info-general .valor {
            width: 65%;
        }
        .info-general .line-separator {
            /* línea discontinua horizontal */
            border-top: 1px dashed #000;
            padding-top: 4px;
            margin-bottom: 4px;
        }

        /* ======== Detalles (tabla) ======== */
        .detalle-header {
            font-weight: bold;
            text-align: center;
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            padding: 2px 0;
            margin-bottom: 2px;
        }
        .tabla-detalle {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4px;
            font-size: 10px;
        }
        .tabla-detalle th,
        .tabla-detalle td {
            padding: 2px 4px;
            text-align: center;
        }
        .tabla-detalle th {
            font-weight: bold;
        }
        .tabla-detalle tr {
            border-bottom: none;
        }

        /* Layout de dos columnas dentro de la celda de detalle */
        .detail-row-2col {
            display: flex;
            flex-direction: row;
            gap: 20px;
            justify-content: space-between;
            align-items: flex-start;
        }
        .detail-left {
            text-align: left;
        }
        .detail-right {
            flex: 1 1 auto;
            text-align: left;
        }
        .efecto-item { display: flex; align-items: center; gap: 8px; padding: 2px 0; }

        /* ======== Estilos para checkboxes en DETALLES ======== */
        .effects-cell .effects-title {
            text-align: center;
            font-weight: bold;
            font-size: 10px;
            margin-bottom: 4px;
        }
        /* Lista de efectos en línea */
        .effects-cell .effects-list label {
            display: inline-block;
            font-size: 10px;
            margin-right: 8px;
            vertical-align: middle;
        }
        /* Checkbox con buen espaciado */
        .effects-cell .effects-list input[type="checkbox"] {
            vertical-align: middle;
            margin-right: 4px;
        }
        .effects-row .effects-cell {
            border-top:    1px dashed #cccccc;
            border-bottom: 1px dashed #cccccc;
            padding:       4px 0;
        }

        /* ======== Totales ======== */
        .totales {
            width: 100%;
            border-top: 1px dashed #000;
            padding-top: 4px;
            margin-top: 4px;
            font-weight: bold;
        }
        .totales td {
            padding: 2px 0;
        }
        .totales .label-total {
            width: 70%;
            text-align: left;
            text-transform: uppercase;
        }
        .totales .valor-total {
            width: 30%;
            text-align: right;
        }

        /* ======== Pie de página ======== */
        .footer {
            margin-top: 6px;
            font-size: 9px;
            line-height: 10px;
            border-top: 1px dashed #000;
            padding-top: 4px;
        }

        @font-face {
            font-family: 'primeicons';
            /* font-display: block; */
            src: url('{{ 'file://'.str_replace('\\','/',public_path('fonts/primeicons.ttf')) }}') format('truetype'),
                url('/fonts/primeicons.woff2') format('woff2'),
                url('/fonts/primeicons.woff') format('woff'),
                url('/fonts/primeicons.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        .pi {
            font-family: 'primeicons';
            font-style: normal;
            font-weight: normal;
            font-variant: normal;
            text-transform: none;
            line-height: 1;
            display: inline-block;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .pi:before {
            --webkit-backface-visibility:hidden;
            backface-visibility: hidden;
        }

    </style>
</head>
<body>
<div id="ticket">
    <!-- ======== ENCABEZADO ======== -->
    <div class="header">
        <!-- Número de ficha, con bordes punteados arriba y abajo -->
        <div class="codigo">FICHA LAVADO   N° {{ $washOrder->code }}</div>
    </div>

    <!-- ======== DATOS GENERALES ======== -->
    <table class="info-general">
        <tr>
            <td class="label">Cliente:</td>
            <td class="valor">{{ $client->fullname }}</td>
        </tr>
        <tr>
            <td class="label">Fecha:</td>
            <td class="valor">{{ $washOrder->date->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td class="label">Tipo Lavado:</td>
            <td class="valor">
                @if(!$washOrder->is_rewash)
                    {{ $washOrder->washType->name }}
                @else
                    RELAVADO
                @endif
            </td>
        </tr>
        <tr>
            <td class="label">Observaciones:</td>
            <td class="valor">
                @if(trim($washOrder->observations) !== '')
                    {{ $washOrder->observations }}
                @else
                    —
                @endif
            </td>
        </tr>
    </table>

    <div class="info-general line-separator"></div>

    <!-- ======== DETALLES ======== -->
    <div class="detalle-header">DETALLES</div>
    <table class="tabla-detalle">
        <tbody>
        @foreach($details as $detail)
            <tr>
                <td>
                    <div class="detail-row-2col">
                        <div class="detail-left">
                            <div><b>TIPO:</b> {{ Str::upper($detail->clothType->name) }}</div>
                            <div><b>TAM:</b> {{ Str::upper($detail->clothSize->name) }}</div>
                            <div><b>CANT:</b> {{ $detail->quantity }}</div>
                        </div>
                        <div class="detail-right">
                            <div class="efectos-header"><b>EFECTOS</b></div>
                            <!-- <div class="efectos-list"> -->
                                <ul>
                                    @foreach($detail->effects as $effect)
                                        <li class="efecto-item">
                                            <span class="efecto-name"><i class="pi">&#xE98C;</i> {{ Str::upper($effect->name) }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            <!-- </div> -->
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <!-- ======== TOTALES ======== -->
    <table class="totales">
        <tr>
            <td class="label-total">TOTAL CANTIDAD:</td>
            <td class="valor-total">{{ $washOrder->total_quantity }}</td>
        </tr>
    </table>

    <!-- ======== PIE DE PÁGINA ======== -->
    <div class="footer">
        <table style="width:100%; border-collapse:collapse;">
            <tr>
                <td style="text-align:left; vertical-align:top;">{{ $washOrder->printHistories()->count() > 1 ? 'REIMPRESION' : '' }}</td>
                <td style="text-align:right; vertical-align:top;">{{ optional($washOrder->created_at)->format('d/m/Y H:i:s') }}</td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>
