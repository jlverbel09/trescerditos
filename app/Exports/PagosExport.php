<?php

namespace App\Exports;

use App\Models\Pagos;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PagosExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            'Ticket',
            'Mesa',
            'Tipo Pago',
            'Id Pago',
            'Total',
            'Usuario Reg',
            'Fecha  Reg'
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Pagos::select('pagos.ticket',
        'mesas.descripcion as mesa',
         DB::raw("case when pagos.tipo_pago = 1 then 'EFECTIVO' when  pagos.tipo_pago = 2 then  'VISA' end as tipopago"),
        'pagos.id as Id pago',
        'pagos.valor as total',
        'users.name as nombre',
        'pagos.created_at',
        )
        ->join('mesas','mesas.numero','pagos.id_mesa')
        ->join('users','users.id','pagos.id_user')
        ->get();
    }
}
