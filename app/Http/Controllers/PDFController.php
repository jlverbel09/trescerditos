<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\Mesa;
use App\Models\Producto;
use App\Models\Ticket;
use App\Models\Venta;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Crabbly\Fpdf\Fpdf;
use Illuminate\Support\Facades\Storage;


class PDFController extends Controller
{
    public function generatePDF($idmesa, $iva, $servicio = 0){

       // dd($data);
        $productos = Producto::get();
        $venta = Venta::select('ventas.ticket', 'ventas.id','ventas.id_producto','nombre1' , 'nombre2' , 'comentario',
        'cantidad', 'ventas.precio', 'precio_total','observacion','ventas.created_at',
        'ventas.updated_at', 'mesas.descripcion as mesa','numero')
        ->join('productos','productos.id_producto','ventas.id_producto')
        ->join('mesas','mesas.numero','ventas.id_mesa')
        ->where('ventas.id_mesa','=',$idmesa)
        ->where('ventas.estado','=',1)
        ->get();
        

        $ticket = Ticket::select('ticket')->orderBy('ticket', 'desc')->get();
       
        
       
        $suma = Venta::select('ventas.precio_total')
        ->join('productos','productos.id_producto','ventas.id_producto')
        ->where('ventas.id_mesa','=',$idmesa)
        ->where('ventas.estado','=',1)
        ->sum('ventas.precio_total');


        $factura = Factura::select('factura')->orderBy('factura', 'desc')->get();

        $data = [
            'title' => 'Ticket',
            'date' => date('m/d/Y'),
            'productos' => $productos,
            'venta' => $venta,
            'mesa' => $idmesa,
            'iva' => $suma*10/100,
            'servicio' => $suma*10/100,
            'ticketActual' => $ticket[0]['ticket'],
            'nro_factura' => $factura[0]['factura'],
            'totalFinal' => $suma+request()->servicio
        ]; 
     
        
        

//create pdf document
/* 
$pdf = new Fpdf;

$pdf->AddPage();
$pdf->SetFont('Arial','B',16);

$str='<h1>於人類社會個成員儕有個固有尊</h1>';

$pdf->AddPage();




$pdf->Cell(130 ,5,$str,0,0);

//save file
$pdf->Output('D'); */


        $pdf = FacadePdf::loadView('pdf', $data);
        $pdf->setOption(['defaultFont' => 'sans-serif']);
        //$pdf->set_paper("A4", "portrait");
        $pdf->set_paper(array(0,0,210,400));
        //$pdf->set_paper('b7', 'portrait');
        
        return $pdf->stream();

        return view('pdf', $data);
     
        
    }

    public function cerrarVenta(Request $request){
        $ticket = Ticket::select('ticket')->orderBy('ticket', 'desc')->get();
        $idmesa = $request->id_mesa;
        $venta = Venta::where('id_mesa','=',$idmesa)->where('estado','=',1)
                ->update(['estado' => 0 , 'ticket' => $ticket[0]->ticket]);

        if($venta > 0){
            
            Ticket::insert([
                'ticket' => $ticket[0]->ticket + 1,
                'created_at' => now()
            ]);
                     
            $factura = Factura::select('factura')->orderBy('factura', 'desc')->get();
            Factura::insert([
                'factura' => $factura[0]['factura']+1,
                'created_at' => now()
            ]);

            Mesa::where('numero','=',$idmesa)
            ->update(['estado' => 0]);
        
        }
        
       
    }

    
}
