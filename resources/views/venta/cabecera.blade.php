<div class="row">
    @foreach ($mesas as $cabMesas)
        @if ($cabMesas->ticket)
            @php
                $ruta = route('venta.create.id.ticket', [$cabMesas, $cabMesas->ticket]);
            @endphp
        @else
            @php
                $ruta =  route('venta.create.id', $cabMesas);
            @endphp
        @endif

        <div class="p-1 col-2 col-xl-1 ">
            <a class="btn @if (request()->idmesa == $cabMesas->numero) bordeado @endif
                 @if ($cabMesas->estado == 1) btn-warning @else btn-secondary @endif  d-flex align-items-center justify-content-center"
                style="width: 100%; height: 60px" href="{{$ruta }}">
                {{ $cabMesas->descripcion }}
            </a>
        </div>
    @endforeach

</div>
