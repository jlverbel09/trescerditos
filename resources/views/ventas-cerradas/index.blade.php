@extends('layouts.app')

@section('content')
    <div class="row justify-content-center mt-3">
        <div class="col-8 col-xl-11 ">
            <h2>{{ $titleform }}</h2>
        </div>
        <div class="col-4 col-xl-1 text-center justify-content-center d-flex align-items-center">
            @if (Auth::user()->rol == 1)
                <a href="{{ route('ventas-cerradas-excel') }}" title="Exportar" style="text-decoration:none">
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
            <table class="table table-dark "style="border: 1px solid #383d3f" border="0">
                <tr>
                    <th class="text-center"><b>Reabrir</b></th>
                    <th><b>Ticket</b></th>
                    <th><b>Mesa</b></th>
                    <th><b>Estado</b></th>
                    <th><b>Producto</b></th>
                    <th><b>Nombre chino</b></th>
                    <th><b>Cantidad</b></th>
                    <th><b>Precio</b></th>
                    <th><b>Precio Total</b></th>
                    <th><b>Observación</b></th>
                </tr>
                @php
                    $sum = 0;
                    $ticketanterior = -1;
                @endphp
                @forelse ($data as $d)
                    <tr>
                        @if ($d->ticket . '0' . $d->mesa == $ticketanterior)
                            @php
                                $sum = $sum + 1;
                            @endphp
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        @else
                            @php

                                $ticketanterior = $d->ticket . '0' . $d->mesa;
                                $sum = 1;

                            @endphp
                            <td class="text-center borde">
                                @if ($d->estadomesa == 0)
                                    <button title="Reabrir Ticket"
                                        onclick="consultarMesaCerrada({{ $d->ticket }},{{ $d->numero }})"
                                        class="btn btn-info  btn-sm"><i class="fa fa-lock-open"></i></button>
                                @else
                                    <button title="La mesa se encuentra abierta" class="btn btn-danger  btn-sm"
                                        width="100px"><i class="fa fa-info"></i></button>
                                @endif
                            </td>
                            <td class="borde">
                                @if ($d->estadomesa == 0)
                                    {{ str_pad($d->ticket, 6, '0', STR_PAD_LEFT) }}
                                @else
                                    -
                                @endif
                            <td class="borde">{{ $d->mesa }}</td>
                            <td class="borde">{{ $d->estado }}</td>
                        @endif

                        <td class="borde">{{ $d->id_producto }} {{ ucwords($d->nombre1) }}</td>
                        <td class="borde">{{ $d->nombre2 }}</td>
                        <td class="borde">{{ $d->cantidad }}</td>
                        <td class="borde">{{ '€' . number_format($d->precio, 2, ',', '.') }} </td>
                        <td class="borde">{{ '€' . number_format($d->precio_total, 2, ',', '.') }}</td>
                        <td class="borde">{{ $d->observacion }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10">No existen registros</td>
                    </tr>
                @endforelse

            </table>
        </div>
    </div>
@endsection
