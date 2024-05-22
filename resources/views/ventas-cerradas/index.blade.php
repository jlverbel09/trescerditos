@extends('layouts.app')

@section('content')
    <div class="row justify-content-center mt-3">
        <div class="col-8 col-xl-11 ">
            <h2>{{ $titleform }}</h2>
        </div>
        <div class="col-4 col-xl-1 text-center justify-content-center d-flex align-items-center">
            
            <a href="{{route('ventas-cerradas-excel')}}" title="Exportar" style="text-decoration:none">
                <i class="fa fa-file-excel text-success  " style="font-size: 30px"></i> Exportar
            </a>
        </div>
        <style>
            td{
                border: none
            }
            td.borde{
                border-top: 1px solid white
            }
        </style>

        <div class="col-lg-10 col-sm-12 mt-3 scroll table-ventas-cerradas ">
            <table class="table " border="0">
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
                    $ticketanterior = 0;
                @endphp
                @foreach ($data as $d)

                   
                <tr>
                    @if($d->ticket == $ticketanterior)
                    @php
                    $sum = $sum + 1;
                    @endphp
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                @else
                    @php
                   
                    $ticketanterior = $d->ticket;
                        $sum = 1;
                        
                    @endphp
                    <td class="text-center borde">
                        @if ($d->estadomesa == 0)  
                        <button title="Reabrir Ticket" onclick="consultarMesaCerrada({{$d->ticket}},{{$d->numero}})" class="btn btn-info  btn-sm"><i class="fa fa-lock-open"></i></button>
                        @else 
                        <button  title="La mesa se encuentra abierta" class="btn btn-danger  btn-sm" width="100px"><i class="fa fa-info"></i></button>
                        @endif                    
                    </td>
                    <td class="borde">{{$d->ticket}}</td>
                    <td class="borde">{{$d->mesa}}</td>
                    <td class="borde">{{$d->estado}}</td>
                @endif
                    
                    
                
                    <td class="borde">{{$d->id_producto}} {{ucwords($d->nombre1)}}</td>
                    <td class="borde">{{$d->nombre2}}</td>
                    <td class="borde">{{$d->cantidad}}</td>
                    <td class="borde">{{ '€' . number_format($d->precio, 2, ',', '.') }} </td>
                    <td class="borde">{{ '€' . number_format($d->precio_total, 2, ',', '.') }}</td>
                    <td class="borde">{{$d->observacion}}</td>
                </tr>
                @endforeach
                
            </table>
        </div>
    </div>
@endsection
