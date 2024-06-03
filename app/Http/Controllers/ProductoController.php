<?php

namespace App\Http\Controllers;

use App\Http\Requests\saveProductoRequest;
use App\Models\producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Producto $producto)
    {
        $list = $producto->get();
        return view('producto.index', [
            'data' => $list,
            'titleform' => 'Productos'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Producto $producto)
    {
        $list = $producto->orderBy('id_producto')->get();
        return view('producto.create', [
            'data' => $list,
            'titleform' => 'Crear producto',
            'producto' => new Producto(),
            'productosSelect' => []
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Producto $producto, saveProductoRequest $request)
    {
        $producto->create([
            'id_producto' => $request->id_producto,
            'nombre1' => $request->nombre1,
            'nombre2' => $request->nombre2,
            'precio' => $request->precio,
            'comentario' => $request->comentario,
        ]);
        return redirect()->route('producto.create')->with('status','Producto creado correctamente');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(producto $producto)
    {
        $list = $producto->paginate(10);
        return view('producto.edit', [
            'data' => $list,
            'titleform' => 'Modificar Producto',
            'producto' => $producto,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(saveProductoRequest $request, Producto $producto)
    {
        $producto->update($request->validated());
        return redirect()->route('producto.create')->with('status','Producto modificado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(producto $producto)
    {
        $producto->delete();
        return redirect()->route('producto.create')->with('status','Producto eliminado correctamente');
    }
}
