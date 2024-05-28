<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Venta;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LogsController extends Controller
{
    public function index(){
        
        $aperturas = Log::select('logs.id_mesa','mesas.descripcion as nombremesa','ticket','logs.created_at')
        ->addSelect(DB::raw("(select updated_at  from 
        logs lgs where lgs.ticket=logs.ticket and logs.id_mesa = lgs.id_mesa and accion = 'CIERRE MESA' order by updated_at desc limit 1) as cierre"))
        ->join('mesas','mesas.numero','logs.id_mesa')
        ->where('accion','=','APERTURA MESA')
        ->groupBy('logs.id_mesa','mesas.descripcion','ticket','created_at','cierre')->orderBy('created_at','desc')->get();

      /*   $aperturas = DB::query("select id_mesa , ticket , created_at ,(select created_at  from 
        logs lgs where lgs.ticket=logs.ticket and logs.id_mesa = lgs.id_mesa and accion = 'CIERRE MESA') as cierre from logs where accion = 'APERTURA MESA'   
        group by id_mesa, ticket, created_at, 4 order by id_mesa ")->get(); */
        


        $data = Log::select('logs.*','users.name')
        ->join('users','users.id','logs.id_user')
        
        ->orderBy('created_at', 'desc')->get();


        return view('logs.index', [
            'titleform' => 'Logs',
            'aperturas' => $aperturas,
            'data' => $data
        ]);

    }

    public function logReabrir(Request $request){
        Log::create([
            'id_user' => Auth::user()->id,
            'ticket' => $request->id_ticket,
            'id_mesa' => $request->id_mesa,
            'accion' => 'RE-APERTURA MESA',
            'descripcion' => ''
        ]);
    }
}
