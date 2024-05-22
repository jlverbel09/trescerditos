<!DOCTYPE html>
<html style="padding:0; margin:10px">

<head>
    <title>Tickets</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Sans+SC:wght@100..900&family=Noto+Sans+TC:wght@100..900&display=swap"
        rel="stylesheet">

    <link
        href="https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Noto+Sans+SC:wght@100..900&family=Noto+Sans+TC:wght@100..900&display=swap"
        rel="stylesheet">
    <style>


        body {
            font-family: "Barlow Semi Condensed", sans-serif;
            font-weight: 500;
            font-style: normal;
            padding: 0;
            margin: 0
        }

        @font-face {
            font-family: "Noto Sans SC", sans-serif;
            font-optical-sizing: auto;
            font-weight: <weight>;
            font-style: normal;
        }


        .china {
            font-family: Noto Sans SC, sans-serif;
            padding: 0;
            margin: -10px;
            position: absolute;
            top: -10px;
        }

        .titulo-china {
            font-family: Noto Sans SC, sans-serif;
        }


        td,
        p,
        h4 {
            color: #000;

        }
        td{
            margin: 0px;
            padding: -10px;
        }

        .td {
            position: relative;
            top: 100px
        }

        table {
            text-align: left;
            width: 100%;
            padding: 0px;
            margin: 0px;
        }
        b{
            padding: 0;
            margin: 0;
        }
    </style>

</head>

<body width="100%" style="padding:0">
    <div style="text-align:center" class="barlow-semi-condensed-thin">
        <h5>TRES CERDITOS</h5>

        <p style="padding:0; margin:0; font-size:10px">EMPANADERIA S.L. CIF:B02959252</p>
        <p style="padding:0; margin:0px; margin-top:-10px; font-size:10px" class="titulo-china">三只小猪饺子店</p>
        <p style="padding:0; margin:0; font-size:10px">C/BAILEN, 20, 28005, MADRID</p>
        <p style="padding:0; margin:0; font-size:10px">640048866/911448383s</p>

    </div>
    <table width="100%" cellspacing="0">
        <tr>
            <td style="font-size:10px;">
                <b style="padding: 0px; margin:0px">Caja</b>
            </td>
            <td style="font-size:10px">
                Usuario 1
            </td>
            <td style="font-size:10px">
                <b>Serial:</b>
            </td>
            <td style="font-size:10px">
                {{ str_pad($ticketActual, 9, '0', STR_PAD_LEFT) }}
            </td>
        </tr>
        <tr>
            <td style="font-size:10px">
                <b>NO.FC</b>
            </td>
            <td style="font-size:10px">
                {{ str_pad($nro_factura, 9, '0', STR_PAD_LEFT) }}
            </td>
            <td style="font-size:10px">
                <b>Imprimido:</b>
            </td>
            <td style="font-size:10px">
                1
            </td>
        </tr>
        <tr>
            <td style="font-size:10px">
                <b>Fecha:</b>
            </td>
            <td colspan="2" width="100" style="font-size:10px">
                {{ date('Y-m-d h:i:s') }}
            </td>
        </tr>
        <tr>
            <td style="font-size:10px"><b>Mesa:</b></td>
            <td colspan="3" style="font-size:10px"><b>{{ $mesa }}</b></td>
            {{-- <td style="font-size:10px"><b>GST:</b></td>
            <td style="font-size:10px">2</td> --}}
        </tr>
    </table>

    <table class="table p-0 m-0" style="padding: 0px">


        @foreach ($venta as $vent)
            <tr style="margin: -10px;padding:0px">
                <td style="font-size:12px;padding-top:9px; padding:0px; margin: -10px" class="td">
                    {{ $vent->cantidad }}
                </td>
                <td style="font-size:12px;padding-top:9px;padding:0px;margin:0px" class="td">
                    {{ $vent->id_producto }} {{ $vent->nombre1 }}
                </td>
                <td style="font-size:10px;padding:0px; margin:0px; margin-top:-50px" class="china">
                    {{ $vent->nombre2 }}
                </td>
                <td style="font-size:12px;padding-top:9px;padding:0px;margin:0px" class="td">
                    €{{ number_format($vent->precio_total, 2, ',', '.') }}
                </td>
            </tr>
        @endforeach
    </table>
    <table class="table text-center">
        <tr>
            <td style="padding:0; font-size:10px; border:none">
                <b>IVA/TAX:</b>
                &nbsp;
                €{{ number_format($iva, 2, ',', '.') }}
            </td>
        </tr>
        <tr>
            <td style=" padding:0; font-size:10px; border:none"><b>TOTAL:</b>
                €{{ number_format($totalFinal, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <td style="font-size:10px; border:none; padding:0">
                Gracias por su visita!<br> Tips not included
            </td>
        </tr>
    </table>

</body>

</html>
