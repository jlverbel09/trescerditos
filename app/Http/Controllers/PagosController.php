<?php

namespace App\Http\Controllers;

use App\Exports\PagosExport;
use App\Models\Pagos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PagosController extends Controller
{
    public function index(){
        $data  = Pagos::select('pagos.*','mesas.descripcion as mesa', 'pagos.valor as total','users.name',DB::raw("case when pagos.tipo_pago = 1 then 'EFECTIVO' when  pagos.tipo_pago = 2 then  'VISA' end as tipopago"))
        ->join('mesas','mesas.numero','pagos.id_mesa')
        ->join('users','users.id','pagos.id_user')
        ->get();

        return view('pagos.index', [
            'titleform' => 'Pagos',
            'data' => $data
        ]);
    }

    public function exportarPagos(){
        return Excel::download(new PagosExport, 'pagos.xlsx');
    }
}
