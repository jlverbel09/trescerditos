<div class="row">
    @foreach ($mesas as $cabMesas)
        <div class="p-1 col-2 col-xl-1 ">
            <a class="btn @if (request()->idmesa == $cabMesas->numero) bordeado @endif @if($cabMesas->estado == 1) btn-warning @else btn-secondary @endif  d-flex align-items-center justify-content-center"
                style="width: 100%; height: 60px" href="{{ route('venta.create.id', $cabMesas) }}">
                {{ $cabMesas->descripcion }}
            </a>
        </div>
    @endforeach
     
</div>