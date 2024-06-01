@extends('layouts.app')

@section('content')
    <div class="row justify-content-center mt-3">
        <div class="col-8 col-xl-11 ">
            <h2>{{ $titleform }}</h2>
        </div>
        <div class="col-4 col-xl-1 text-center justify-content-center d-flex align-items-center">
           {{--  @if (Auth::user()->rol == 1)
                <a href="{{ route('ventas-cerradas-excel') }}" title="Exportar" style="text-decoration:none">
                    <i class="fa fa-file-excel text-success" style="font-size: 30px"></i> Exportar
                </a>
            @endif --}}
        </div>
    

        <div class="col-lg-12 col-sm-12 mt-3 scroll table-ventas-cerradas text-white ">

            <div class=" row m-1 mb-2 border">
                <div class="col-2">
                    MESA
                </div>
                <div class="col-2">
                    ESTADO
                </div>
                <div class="col-4">
                    APERTURA
                </div>

                <div class="col-4">
                    CIERRE
                </div>
            </div>

            @forelse ($aperturas as $apertura)
                <div class="accordion my-2" id="accordionExample{{ $apertura->id_mesa . $apertura->ticket }}">

                    <div class="accordion-item bg-transparent">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne{{ $apertura->id_mesa . $apertura->ticket }}" aria-expanded="true"
                                aria-controls="collapseOne{{ $apertura->id_mesa . $apertura->ticket }}">

                                <div class="col-2">
                                    {{ strtoupper($apertura->nombremesa) }}
                                </div>


                                <div class="col-2">
                                    @if ($apertura->ticket == 0)
                                        MESA ABIERTA
                                    @else
                                        MESA CERRADA - TICKET: {{ $apertura->ticket }}
                                    @endif
                                </div>
                                <div class="col-4">
                                    FECHA: {{ $apertura->created_at }}
                                </div>

                                <div class="col-4">
                                    @if ($apertura->cierre)
                                        FECHA: {{ $apertura->cierre }}
                                    @endif

                                </div>
                            </button>
                        </h2>
                        <div id="collapseOne{{ $apertura->id_mesa . $apertura->ticket }}" class="accordion-collapse collapse "
                            data-bs-parent="#accordionExample{{ $apertura->id_mesa . $apertura->ticket }}">
                            <div class="accordion-body m-0 ">



                                <table class="table  table-bordered table-dark" border="0">
                                    <tr>
                                        <th><b>Fecha</b></th>
                                        <th><b>Usuario</b></th>
                                        {{--  <th><b>Ticket</b></th>
                                        <th><b>Mesa</b></th> --}}
                                        <th><b>Acción</b></th>
                                        <th><b>Descripción</b></th>

                                    </tr>
                                    @foreach ($data as $d)
                                        @if ($apertura->id_mesa == $d->id_mesa && $apertura->ticket == $d->ticket)
                                            <tr>
                                                <td class="borde">{{ $d->created_at }} </td>
                                                <td class="borde">{{ strtoupper($d->name) }}</td>
                                                {{-- <td class="borde">{{ $d->ticket }}</td>
                                                <td class="borde">{{ $d->id_mesa }} </td> --}}
                                                <td class="borde">{{ $d->accion }}</td>
                                                <td class="borde">{{ $d->descripcion }}</td>
                                            </tr>
                                        @endif
                                    @endforeach

                                </table>


                            </div>
                        </div>
                    </div>






                </div>
            @empty
                <div class="col-12 p-2">
                    No existen registros
                </div>
            @endforelse








        </div>
    </div>
@endsection
