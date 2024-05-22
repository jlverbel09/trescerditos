<?php

use App\Http\Controllers\PDFController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\VentaController;
use Illuminate\Support\Facades\Route;

/* Route::get('/', function () {
    return view('welcome');
});
 */

 

 Route::get('/', [VentaController::class, 'create'])->name('venta.create.index');

Route::get('/producto', [ProductoController::class, 'create'])->name('producto.create');
Route::resource('producto', ProductoController::class)
    ->names('producto')
    ->parameters(['producto' => 'producto']);



Route::get('/ventacalculo', [VentaController::class, 'calculo'])->name('venta.calculo');
Route::get('/venta/create/{idmesa}', [VentaController::class, 'create'])->name('venta.create.id');
Route::get('/venta/create/{idmesa}/{idticket}', [VentaController::class, 'create'])->name('venta.create.id.ticket');
Route::resource('venta', VentaController::class)
    ->names('venta')
    ->parameters(['venta' => 'venta']);

Route::get('generate-pdf/{data}/{iva}/{servicio}', [PDFController::class, 'generatePDF'])->name('generatePDFIva');
Route::get('generate-pdf/{data}', [PDFController::class, 'generatePDF'])->name('generatePDF');

Route::get('cerrar-venta', [PDFController::class, 'cerrarVenta'])->name('cerrarVenta');

Route::get('ventas-cerradas',[VentaController::class, 'ventasCerradas'])->name('ventas-cerradas.index');
Route::get('exportar-excel', [VentaController::class, 'exportarVentas'])->name('ventas-cerradas-excel');


Route::get('reabrir-venta', [VentaController::class, 'reabrirVenta'])->name('reabrirVenta');
