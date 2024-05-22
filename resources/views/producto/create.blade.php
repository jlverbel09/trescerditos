@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <h2>{{ $titleform }}</h2>
        </div>
        <div class="col-lg-2 col-sm-12 mb-4">
            <form action="{{ route('producto.store') }}" method="POST">
                @csrf
                @include('producto.form', ['btn'=> 'Guardar' ,'btn_accion'=> 'primary'])
            </form>
        </div>

        <div class="col-lg-10 col-sm-12">
            @include('producto.index')
        </div>
    </div>
@endsection
