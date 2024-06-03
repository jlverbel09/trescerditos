<nav class=" main-header navbar navbar-expand d-flex flex-wrap justify-content-between text-white navbar-light " style="background-color: #000">
    <!-- Left navbar links -->
    <ul class="navbar-nav  text cabecera row  w-100 mb-1" @style('width:initial')>

        <li class="col-6 d-flex align-items-center ">
            <img width="100" height="auto" class="logo" src="{{ asset('img/logo.png') }}" alt="">
            <h4 class="text-white me-2 ms-1 "><a class="text-decoration-none text-white"
                    href="{{ route('producto.create') }} ">Empanaderia China Los Tres Cerditos</a></h4>
        </li>
        <li class="col-6  ">
            @include('layouts.navigation')
        </li>
    </ul>


    <ul class="m-0 px-2  listadomenu ">
        <li class="nav-item d-sm-inline-block     ">
            <a href="{{ route('producto.create') }}"
                class="nav-link  p-2   @if (Route::currentRouteName() == 'producto.create') bg-primary @else text-light bg-secondary @endif">Productos</a>
        </li>
        <li class="nav-item  d-sm-inline-block     ">
            <a href="{{ route('venta.create.id', 1) }}"
                class="nav-link  p-2   @if (Route::currentRouteName() == 'venta.create.id') bg-primary @else text-light bg-secondary @endif">Ventas</a>
        </li>
        <li class="nav-item  d-sm-inline-block     ">
            <a href="{{ route('ventas-cerradas.index') }}"
                class="nav-link  p-2   @if (Route::currentRouteName() == 'ventas-cerradas.index') bg-primary @else text-light bg-secondary @endif">Historico</a>
        </li>
        <li class="nav-item  d-sm-inline-block     ">
            <a href="{{ route('logs.index') }}"
                class="nav-link  p-2   @if (Route::currentRouteName() == 'logs.index') bg-primary @else text-light bg-secondary @endif">Logs</a>
        </li>
        <li class="nav-item  d-sm-inline-block     ">
            <a href="{{ route('pagos.index') }}"
                class="nav-link  p-2   @if (Route::currentRouteName() == 'pagos.index') bg-primary @else text-light bg-secondary @endif">Pagos</a>
        </li>

    </ul>
    @include('layouts.header-section')
</nav>
