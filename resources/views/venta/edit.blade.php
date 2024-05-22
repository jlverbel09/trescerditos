@extends('layouts.app')

@section('content')
    @include('venta.cabecera')
    <div class="row">
        <div class="col-12">
            <h2>{{ $titleform }}</h2>
        </div>
        <div class="col-lg-2 col-sm-12 mb-4">
            <a class="btn btn-info btn-sm " href="{{ route('venta.create') }}">
                <i class="fa fa-save text-white"></i> <span class="text-white">Crear</span>
            </a>
            <form method="POST" action="{{ route('venta.update', $venta) }}">
                @csrf
                @method('PATCH')
                @include('venta.form', ['btn' => 'Modificar', 'btn_accion' => 'warning'])
            </form>
        </div>
        <div class="col-lg-10 col-sm-12">
            @include('venta.index')
        </div>
    </div>
@endsection
