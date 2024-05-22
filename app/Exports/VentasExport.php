<?php

namespace App\Exports;

use App\Models\Venta;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class VentasExport implements FromCollection,WithHeadings
{
    public function headings(): array
    {
        return [
            'Ticket',
            'Mesa',
            'Estado',
            'Producto',
            'Nombre',
            'Cantidad',
            'Precio',
            'Precio',
            'Observación'
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Venta::select('ventas.ticket','mesas.descripcion as mesa', 
        DB::raw('CASE WHEN ventas.estado = 0 THEN \'CERRADA\' ELSE \'ABIERTA\' END AS estado'),'productos.nombre1', 'productos.nombre2', 'productos.precio', 'ventas.precio', 
        'ventas.precio_total' , 'ventas.cantidad' ,'ventas.observacion')
        ->join('mesas', 'mesas.numero','ventas.id_mesa') 
        ->join('productos', 'productos.id_producto','ventas.id_producto')
        ->where('ventas.estado','=',0)
        ->orderBy('ticket','desc')->get();
    }
}
