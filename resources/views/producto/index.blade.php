<div class="row">
    <div class="col-12 scroll table-producto">
        <table class="table table-dark table-bordered  table-sm  table-responsive">
            <thead class="thead">
                <tr>
                    <th class="text-center">Acciones</th>
                    {{-- <th>ID</th> --}}
                    <th>ID.&nbsp;Producto</th>
                    <th>Nombre 1</th>
                    <th>Nombre 2</th>
                    <th>Precio&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                    <th>Comentario</th>
                    <th>Fec.&nbsp;Creación</th>
                    <th>Fec.&nbsp;Modificación</th>

                </tr>
            </thead>
            <tbody class="tbody">

                @forelse ($data as $producto)
                    <tr class="bg-dark" style="border: blak">
                        <td class="text-center   bg-dark">
                            <div class="row justify-content-center d-flex">
                                <div class="col-6 text-end">
                                    <a class="btn btn-warning btn-sm " href="{{ route('producto.edit', $producto) }}">
                                        <i class="fa fa-edit text-white"></i>
                                    </a>
                                </div>
                                @if (Auth::user()->rol == 1)
                                    <div class="col-6 text-start">
                                        <form action="{{ route('producto.destroy', $producto) }}" method="POST">
                                            @csrf @method('delete')
                                            <button class="btn btn-outline-danger btn-sm" type="submit">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>

                        </td>

                        {{-- <td>{{ $producto['id'] }}</td> --}}
                        <td>{{ $producto['id_producto'] }}</td>
                        <td>{{ $producto['nombre1'] }}</td>
                        <td>{{ $producto['nombre2'] }}</td>
                        <td>{{ '€' . number_format($producto['precio'], 2, ',', '.') }}</td>
                        <td>{{ $producto['comentario'] }}</td>
                        <td>{{ $producto['created_at'] }}</td>
                        <td>{{ $producto['updated_at'] }}</td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="text-center">No existe ningún registro</td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>
</div>
