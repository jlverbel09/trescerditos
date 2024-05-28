<div class="row">
    <div class="col-12">

        <div class="row ">
            <div class="col-12 scroll table-ventas" {{-- style="overflow: scroll" --}}>
                <table class="table table-bordered border-1 table-sm  table-responsive " >
                    <thead class="thead">
                        <tr>
                            <th class="text-center">Acciones</th>
                            {{-- <th>ID</th> --}}
                            <th>ID.&nbsp;Producto</th>
                            <th>Mesa&nbsp;&nbsp;&nbsp;</th>
                            <th>Nombre&nbsp;1</th>
                            <th>Nombre&nbsp;2</th>
                            <th class="text-center">cantidad</th>
                            <th>Precio&nbsp;Unitario&nbsp;&nbsp;&nbsp;</th>
                            <th>Precio&nbsp;Total&nbsp;&nbsp;&nbsp;</th>
                            <th>Comentario</th>
                            <th>Observación</th>
                            <th>Fec.&nbsp;Creación</th>
                           {{--  <th>Fec.&nbsp;Modificación</th> --}}
    
                        </tr>
                    </thead>
                    <tbody class="tbody">
                        @php
                            $total = 0;
                        @endphp
    
                        @forelse ($data as $venta)
                            @php
                                $total = $total + $venta['precio_total'];
                            @endphp
                            <tr>
                                <td class="text-center pt-2 justify-content-center">
    
                                   {{--  <a class="btn btn-warning btn-sm " href="{{ route('venta.edit', $venta) }}">
                                        <i class="fa fa-edit text-white"></i>
                                    </a>
                                    &nbsp; --}}
                                    <form action="{{ route('venta.destroy', $venta) }}" method="POST">
                                        @csrf @method('delete')
                                        <button class="btn btn-outline-danger btn-sm" type="submit">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
    
                                </td>
    
                                {{-- <td>{{ $venta['id'] }}</td> --}}
                                <td>{{ $venta['id_producto'] }}</td>
                                <td>{{ $venta['mesa'] }}</td>
                                <td>{{ $venta['nombre1'] }}</td>
                                <td>{{ $venta['nombre2'] }}</td>
                                <td class="text-center">{{ $venta['cantidad'] }}</td>
                                <td>{{ '€' . number_format($venta['precio'], 2, ',', '.') }}</td>
                                <td>{{ '€' . number_format($venta['precio_total'], 2, ',', '.') }}</td>
                                <td>{{ $venta['comentario'] }}</td>
                                <td>{{ $venta['observacion'] }}</td>
                                <td>{{ $venta['created_at'] }}</td>
                                {{-- <td>{{ $venta['updated_at'] }}</td> --}}
    
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-left">No existe ningún registro</td>
                            </tr>
                        @endforelse
    
                    </tbody>
                </table>
            </div>
        </div>
    
    
    
    
    
    
    
    
        <div class="row">
            <div class="col-12">
                <hr>
            </div>
            <div class="col-12">
                <table class="table table-bordered border-1 table-sm  table-responsive text-center text-center">
                    <thead class="thead">
                        <tr>
                            <td width="30%">
                                <b>IVA 10%</b>
                            </td>
                            <td width="20%">
                                €{{ $iva }}
                            </td>
                            <td width="30%">
                                <b>SERVICIO&nbsp;10%</b>
                            </td>
                            <td width="20%" class="text-center">
                                <div class="form-check form-switch justify-content-center d-flex">
                                    <input class="form-check-input" type="checkbox" role="switch" id="checkiva"
                                        onchange="adicionarServicio({{ $total }},{{ $iva }})">&nbsp;€{{ $iva }}
                                    <input type="hidden" id="ivatext" value="0">
                                </div>
    
                            </td>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="col-8 text-right ">
                {{--  <a href=""  class="btn btn-danger m-1">
                CERRAR VENTA
            </a> --}}
            </div>
            <div class="col-4 ">
                <table class="table table-bordered border-1 table-sm  table-responsive text-center">
                    <thead class="thead">
                        <tr>
                            <td width="60%">
                                <b>TOTAL</b>
                            </td>
    
                            <td width="40%" id="totalFinal">
                                {{ '€' . number_format($total, 2, ',', '.') }}
                            </td>
    
                        </tr>
                    </thead>
                </table>
            </div>
            
            <div class="col-8 text-right justify-content-end d-flex offset-4">
                <a type="button" onclick="reabrirmesa({{request()->idmesa}})" class="btn btn-info m-1 text-white @if($mesasActivas > 0) disabled @endif">
                    RE-ABRIR ULTIMO TICKET DE LA MESA <i class="fa fa-lock-open"></i>
                </a>
                <a type="button" onclick="cerrarVenta({{request()->idmesa}})"  class="btn btn-danger m-1 @if($total == 0) disabled @endif">
                    CERRAR VENTA <i class="fa fa-lock"></i>
                </a>
                <a class="btn btn-success m-1 @if($total == 0) disabled @endif" target="_blank"
                    onclick="generarPDF({{request()->idmesa}},{{ $iva }}, {{ $servicio }})" >
                    IMPRIMIR <i class="fa fa-print"></i>
                </a>
            </div>
    
    
        </div>
    </div>

    {{-- <div class="row col-3" id="GFG"> 
        <div class="frame" >
            <iframe src="../../generate-pdf/{{request()->idmesa}}/{{$iva}}#toolbar=0" height="100%" frameborder="0"></iframe>
        </div>
    </div> --}}

</div>
