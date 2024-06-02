@extends('layouts.app')

@section('content')
    <div class="row justify-content-center mt-3">
        <div class="col-8 col-xl-11 ">
            <h2>{{ $titleform }}</h2>
        </div>
        <div class="col-4 col-xl-1 text-center justify-content-center d-flex align-items-center">
            @if (Auth::user()->rol == 1)
                <a href="{{ route('pagos-excel') }}" title="Exportar" style="text-decoration:none">
                    <i class="fa fa-file-excel text-success  " style="font-size: 30px"></i> Exportar
                </a>
            @endif
        </div>
        <style>
            td {
                border: none
            }

            td.borde {
                border-top: 1px solid #383d3f
            }
        </style>

        <div class="col-lg-12 col-sm-12 mt-3 scroll table-ventas-cerradas ">
            <table class="table  table-dark" style="border: 1px solid #383d3f">
                <tr>
                    <th><b>Ticket</b></th>
                    <th><b>Mesa</b></th>
                    <th><b>Tipo Pago</b></th>
                    <th><b>Id pago</b></th>
                    <th><b>Pagado</b></th>
                    <th><b>Devolución</b></th>
                    <th><b>Recaudado</b></th>
                    <th><b>Usuario Reg.</b></th>
                    <th><b>Fecha Reg.</b></th>
                </tr>

                @php
                    $sum = 0;
                    $ticketanterior = -1;
                    $sum_pagado = 0;
                    $sum_devolucion = 0;
                    $sum_total = 0;
                @endphp
                @forelse ($data as $d)
                    @php
                        $sum_pagado = $sum_pagado + $d->valor;
                        $sum_devolucion = $sum_devolucion + $d->devolucion;
                    @endphp
                    <tr>
                        @if ($d->ticket . '0' . $d->mesa == $ticketanterior)
                            @php
                                $sum = $sum + 1;
                            @endphp
                            <td></td>
                            <td></td>
                        @else
                            @php

                                $ticketanterior = $d->ticket . '0' . $d->mesa;
                                $sum = 1;

                            @endphp
                            <td class="borde">{{ $d->ticket }}</td>
                            <td class="borde">{{ $d->mesa }}</td>
                        @endif

                        <td class="borde">{{ $d->tipopago }}</td>
                        <td class="borde">{{ str_pad($d->id, 6, '0', STR_PAD_LEFT) }}</td>
                        <td class="borde">{{ '€' . number_format($d->total, 2, ',', '.') }}</td>
                        <td class="borde">{{ '€' . number_format($d->devolucion, 2, ',', '.') }}</td>
                        <td class="borde">{{ '€' . number_format($d->total - $d->devolucion, 2, ',', '.') }}</td>
                        <td class="borde">{{ strtoupper($d->name) }}</td>
                        <td class="borde">{{ $d->created_at }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">No existen registros</td>
                    </tr>
                @endforelse

            </table>
        </div>
        <div class="col-12">
            <table class="text-white table table-dark table-bordered">
                <tr>
                    <td class="borde">
                        <b>PAGADO: {{ '€' . number_format($sum_pagado, 2, ',', '.') }}</b>
                    </td>
                    <td class="borde">
                        <b>DEVOLUCION: {{ '€' . number_format($sum_devolucion, 2, ',', '.') }}</b>
                    </td>
                    <td class="borde">
                        <b>
                            RECAUDADO: {{ '€' . number_format($sum_pagado - $sum_devolucion, 2, ',', '.') }}
                        </b>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@endsection
