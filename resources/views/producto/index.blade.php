

<div class="row">
    <div class="col-12 scroll table-producto"  >
        <table class="table table-bordered border-1 table-sm  table-responsive">
            <thead class="thead">
                <tr>
                    <th  class="text-center">Acciones</th>
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
                    <tr>
                        <td class="text-center d-flex justify-content-center">
                      
                            <a class="btn btn-warning btn-sm " href="{{ route('producto.edit', $producto) }}">
                                <i class="fa fa-edit text-white"></i>
                            </a>
                            &nbsp;
                            <form action="{{ route('producto.destroy', $producto) }}" method="POST">
                                @csrf @method('delete')
                                <button class="btn btn-outline-danger btn-sm" type="submit">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                            
                        </td>

                        {{-- <td>{{ $producto['id'] }}</td> --}}
                        <td>{{ $producto['id_producto'] }}</td>
                        <td>{{ $producto['nombre1'] }}</td>
                        <td>{{ $producto['nombre2'] }}</td>
                        <td>{{ $producto['precio'] }}</td>
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

