<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\Log;
use App\Models\Mesa;
use App\Models\Producto;
use App\Models\Ticket;
use App\Models\Venta;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Crabbly\Fpdf\Fpdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class PDFController extends Controller
{
    public function generatePDF($idmesa, $iva, $servicio = 0)
    {
        $productos = Producto::get();
        $venta = Venta::select(
            'ventas.ticket',
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
            'mesas.descripcion as mesa',
            'numero'
        )
            ->join('productos', 'productos.id_producto', 'ventas.id_producto')
            ->join('mesas', 'mesas.numero', 'ventas.id_mesa')
            ->where('ventas.id_mesa', '=', $idmesa)
            ->where('ventas.estado', '=', 1)
            ->get();

        $ticket = Ticket::select('ticket')->orderBy('ticket', 'desc')->get();

        $suma = Venta::select('ventas.precio_total')
            ->join('productos', 'productos.id_producto', 'ventas.id_producto')
            ->where('ventas.id_mesa', '=', $idmesa)
            ->where('ventas.estado', '=', 1)
            ->sum('ventas.precio_total');

        $factura = Factura::select('factura')->orderBy('factura', 'desc')->get();

        $data = [
            'title' => 'Ticket',
            'date' => date('m/d/Y'),
            'productos' => $productos,
            'venta' => $venta,
            'mesa' => $idmesa,
            'iva' => $suma * 10 / 100,
            'servicio' => $suma * 10 / 100,
            'ticketActual' => $ticket[0]['ticket'],
            'nro_factura' => $factura[0]['factura'],
            'totalFinal' => $suma + request()->servicio
        ];

        $pdf = FacadePdf::loadView('pdf', $data);
        $pdf->setOption(['defaultFont' => 'sans-serif']);
        $pdf->set_paper(array(0, 0, 210, 400));
        return $pdf->stream();
        //return view('pdf', $data);
    }

    public function cerrarVenta(Request $request)
    {
        $idmesa = $request->id_mesa;
        if ($request->id_ticket != null) {
            $ticket = $request->id_ticket;
        } else {
            $ticket = Ticket::select('ticket')->orderBy('ticket', 'desc')->get();
            $ticket = $ticket[0]->ticket . '0' . $idmesa;
        }

        $venta = Venta::where('id_mesa', '=', $idmesa)->where('estado', '=', 1)
            ->update(['estado' => 0, 'ticket' => $ticket]);

        if ($venta > 0) {

            Log::create([
                'id_user' => Auth::user()->id,
                'ticket' => $ticket,
                'id_mesa' => $request->id_mesa,
                'accion' => 'CIERRE MESA',
                'descripcion' => ''
            ]);

            Log::where('id_mesa', '=', $idmesa)->where('ticket', '=', 0)->update(['ticket' =>  $ticket]);

            $ticket = Ticket::select('ticket')->orderBy('ticket', 'desc')->get();
            $ticket = $ticket[0]->ticket;
            Ticket::insert([
                'ticket' => $ticket + 1,
                'created_at' => now()
            ]);

            $factura = Factura::select('factura')->orderBy('factura', 'desc')->get();
            Factura::insert([
                'factura' => $factura[0]['factura'] + 1,
                'created_at' => now()
            ]);

            Mesa::where('numero', '=', $idmesa)
                ->update(['estado' => 0]);
        }
    }
}
