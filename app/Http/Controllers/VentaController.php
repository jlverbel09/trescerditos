<?php

namespace App\Http\Controllers;

use App\Exports\VentasExport;
use App\Http\Requests\saveVentaRequest;
use App\Models\Log;
use App\Models\Mesa;
use App\Models\Pagos;
use App\Models\Producto;
use App\Models\Ticket;
use App\Models\Venta;
use GuzzleHttp\Psr7\Response;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(venta $venta)
    {
        $iva = 10;

        $list = Venta::select(
            'ventas.id',
            'ventas.id_producto',
            'nombre1',
            'nombre2',
            'comentario',
            'cantidad',
            'ventas.precio',
            'precio_total',
            'observacion',
            'ventas.created_at',
            'ventas.updated_at'
        )
            ->join('productos', 'productos.id_producto', 'ventas.id_producto')
            ->paginate(10);
        return view('venta.index', [
            'iva' => $iva,
            'data' => $list,
            'titleform' => 'Venta'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Venta $venta, Request $request)
    {

        if (!empty($request->idticket)) {
            Venta::where('estado', '=', 0)->where('id_mesa', '=', $request->idmesa)->where('ticket', '=', $request->idticket)->update(['estado' => 1]);
            Mesa::where('numero', '=', $request->idmesa)
                ->update(['estado' => 1]);
        }
        $suma = Venta::select('ventas.precio_total')
            ->join('productos', 'productos.id_producto', 'ventas.id_producto')
            ->where('ventas.id_mesa', '=', $request->idmesa)
            ->where('ventas.estado', '=', 1)
            ->sum('ventas.precio_total');

        $mesasActivas = Venta::select('ticket')->where('ventas.id_mesa', '=', $request->idmesa)->where('estado', '=', 1)->count('ticket');



        $ticket = Ticket::select('ticket')->orderBy('ticket', 'desc')->get();

        $mesas = Mesa::select('mesas.id', 'numero', 'descripcion', 'ventas.estado', DB::raw('max(ventas.ticket) as ticket'))
            ->leftJoin('ventas', function ($join) {
                $join->on('ventas.id_mesa', '=', 'mesas.numero');
                $join->where('ventas.estado', '=', 1);
                //$join->where('ventas.ticket','!=',0);
            })
            ->groupBy('mesas.id', 'numero', 'descripcion', 'ventas.estado')
            ->orderBy('numero')
            ->get();

        $listProductos = Producto::orderBy('id_producto')->get();
        $list = Venta::select(
            'ventas.id',
            'ventas.id_producto',
            'nombre1',
            'nombre2',
            'comentario',
            'cantidad',
            'ventas.precio',
            'precio_total',
            'observacion',
            'ventas.created_at',
            'ventas.updated_at',
            'mesas.descripcion as mesa'
        )
            ->join('productos', 'productos.id_producto', 'ventas.id_producto')
            ->join('mesas', 'mesas.numero', 'ventas.id_mesa')
            ->where('ventas.id_mesa', '=', $request->idmesa)
            ->where('ventas.estado', '=', 1)
            ->orderBy('ventas.created_at', 'desc')
            ->get();


        if (!empty($request->idticket)) {
            $carga_ticket = $request->idticket;
        } else {
            $carga_ticket = $ticket[0]['ticket'] . '0' . $request->idmesa;
        }


        $pago = Pagos::select(DB::raw('(sum(valor)) as pagado'))->where('id_mesa', '=', $request->idmesa)->where('ticket', '=', $carga_ticket)->get();
        if ($pago[0]->pagado) {
            $valorpago = $pago[0]->pagado;
        } else {
            $valorpago = 0;
        }


        return view('venta.create', [
            'mesaSelect' => [],
            'mesas' => $mesas,
            'ticket' => $carga_ticket,
            'data' => $list,
            'iva' => $suma * 10 / 100,
            'servicio' => $suma * 10 / 100,
            'titleform' => 'Registrar Venta',
            'listProducto' => $listProductos,
            'venta' => new Venta(),
            'ventaSelect' => [],
            'mesasActivas' => $mesasActivas,
            'pagado' => $valorpago
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Venta $venta, saveVentaRequest $request)
    {


        $verif_ticket = Venta::select('ticket')->where('ticket', '=', $request->ticket)->groupBy('ticket')->get();


        if (!empty($verif_ticket[0]->ticket)) {
            $nro_ticket = $verif_ticket[0]->ticket;
        } else {
            $nro_ticket = 0;
        }

        $estadoInicial = Mesa::select('estado')->where('numero', '=', $request->id_mesa)->get();
        if ($estadoInicial[0]->estado == 0) {
            $tiempo = strtotime('-1 minute', strtotime(date('Y-m-d H:i:s')));
            Log::create([
                'id_user' => Auth::user()->id,
                'ticket' => 0,
                'id_mesa' => $request->id_mesa,
                'accion' => 'APERTURA MESA',
                'descripcion' => '',
                'created_at' => $tiempo
            ]);
        }
        Mesa::where('numero', '=', $request->id_mesa)
            ->update(['estado' => 1]);





        $venta->create([
            'ticket' => $nro_ticket,
            'id_mesa' => $request->id_mesa,
            'id_producto' => $request->id_producto,
            'cantidad' => $request->cantidad,
            'precio' => $request->precio,
            'precio_total' => $request->precio_total,
            'observacion' => $request->observacion,
            'estado' => 1,
        ]);

        $producto = Producto::select()->where('id_producto', '=', $request->id_producto)->get();
        $nomb1 = $producto[0]->nombre1;
        $nomb2 = $producto[0]->nombre2;
        Log::create([
            'id_user' => Auth::user()->id,
            'ticket' => 0,
            'id_mesa' => $request->id_mesa,
            'accion' => 'SELECCION DE PLATO',
            'descripcion' => 'CANTIDAD: ' . $request->cantidad . ' - PLATO: ' . $nomb1 . ' - ' . $nomb2
        ]);

        /* ->with('status', 'Datos de venta registrado correctamente') */

        if (!empty($verif_ticket[0]->ticket)) {
            return redirect()->route('venta.create.id.ticket', [$request->id_mesa, $nro_ticket]);
        } else {
            return redirect()->route('venta.create.id', $request->id_mesa);
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(venta $venta)
    {
        $mesas = Mesa::select('*')->orderBy('numero')->get();

        $suma = Venta::select('ventas.precio')
            ->join('productos', 'productos.id_producto', 'ventas.id_producto')->sum('ventas.precio');
        $listProductos = Producto::get();
        $list = Venta::select(
            'ventas.id',
            'ventas.id_producto',
            'nombre1',
            'nombre2',
            'comentario',
            'cantidad',
            'ventas.precio',
            'precio_total',
            'observacion',
            'ventas.created_at',
            'ventas.updated_at'
        )
            ->join('productos', 'productos.id_producto', 'ventas.id_producto')
            ->where('ventas.estado', '=', 1)
            ->paginate(10);

        return view('venta.edit', [
            'mesas' => $mesas,
            'mesaSelect' => [json_decode($venta->id_mesa)],
            'data' => $list,
            'iva' => $suma * 10 / 100,
            'servicio' => $suma * 10 / 100,
            'listProducto' => $listProductos,
            'titleform' => 'Modificar venta',
            'venta' => $venta,
            'ventaSelect' => [json_decode($venta->id_producto)],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(saveVentaRequest $request, Venta $venta)
    {
        $venta->update($request->validated());
        return redirect()->route('venta.create')->with('status', 'Venta modificada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(venta $venta)
    {

        $producto = Producto::select()->where('id_producto', '=', $venta->id_producto)->get();
        $nomb1 = $producto[0]->nombre1;
        $nomb2 = $producto[0]->nombre2;
        Log::create([
            'id_user' => Auth::user()->id,
            'ticket' => 0,
            'id_mesa' => $venta->id_mesa,
            'accion' => 'ELIMINACION DE PLATO',
            'descripcion' => 'CANTIDAD: ' . $venta->cantidad . ' - PLATO: ' . $nomb1 . ' - ' . $nomb2
        ]);


        $venta->delete();
        return redirect()->route('venta.create.id', $venta->id_mesa)->with('status', 'Producto eliminado correctamente');
    }

    public function calculo(Request $response)
    {
        $id_producto =  $response['id_producto'];
        $list = Producto::select('*')->where('id_producto', '=', $id_producto)
            ->paginate(10);
        return $list[0]->precio;
    }


    public function ventasCerradas()
    {

        $data = Venta::select(
            'ventas.ticket',
            'mesas.numero',
            'mesas.estado as estadomesa',
            'mesas.descripcion as mesa',
            'productos.nombre1',
            'productos.nombre2',
            'productos.precio',
            'ventas.precio',
            DB::raw('CASE WHEN ventas.estado = 0 THEN \'CERRADA\' ELSE \'ABIERTA\' END AS estado'),
            'ventas.precio_total',
            'ventas.cantidad',
            'ventas.observacion'
        )
            ->join('mesas', 'mesas.numero', 'ventas.id_mesa')
            ->join('productos', 'productos.id_producto', 'ventas.id_producto')
            //->where('ventas.estado', '=', 0)

            ->orderBy('ticket', 'desc')

            ->get();

        return view('ventas-cerradas.index', [
            'titleform' => 'Histórico',
            'data' => $data
        ]);
    }

    public function reabrirVenta(Request $request)
    {

        $idmesa = $request['id_mesa'];
        $data = Venta::select('ticket')->where('ventas.id_mesa', '=', $idmesa)->where('ventas.estado', '=', 0)->orderBy('ticket', 'desc')->limit(1)->get();
        if (!empty($data[0]->ticket)) {
            Venta::where('ventas.id_mesa', '=', $request['id_mesa'])->where('ventas.ticket', '=', $data[0]->ticket)->update([
                'estado' => 1
            ]);
            Mesa::where('numero', '=', $request->id_mesa)
                ->update(['estado' => 1]);
            return true;
        }
        return 0;
    }

    public function pagar(Request $request)
    {

        Pagos::create([
            'id_mesa' => $request->id_mesa,
            'tipo_pago' => $request->tipo_pago,
            'valor' => $request->valor,
            'ticket' => $request->ticket,
            'devolucion' => $request->devolucion,
            'id_user' => Auth::user()->id
        ]);

        return $request;
    }

    public function exportarVentas()
    {
        return Excel::download(new VentasExport, 'ventas.xlsx');
    }
}
