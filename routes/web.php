<?php

use App\Http\Controllers\LogsController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\VentaController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
/* Route::get('/', function () {
    return view('welcome');
});
 */

/*  Route::get('/', function () {
    return view('welcome');
});
 */






Route::get('/producto', [ProductoController::class, 'create'])->name('producto.create');
Route::resource('producto', ProductoController::class)
    ->names('producto')
    ->parameters(['producto' => 'producto']);



Route::get('/ventacalculo', [VentaController::class, 'calculo'])->middleware(['auth', 'verified'])->name('venta.calculo');
Route::get('/venta/create/{idmesa}', [VentaController::class, 'create'])->middleware(['auth', 'verified'])->name('venta.create.id');
Route::get('/venta/create/{idmesa}/{idticket}', [VentaController::class, 'create'])->middleware(['auth', 'verified'])->name('venta.create.id.ticket');
Route::resource('venta', VentaController::class)
    ->names('venta')
    ->parameters(['venta' => 'venta']);

Route::get('generate-pdf/{data}/{iva}/{servicio}', [PDFController::class, 'generatePDF'])->middleware(['auth', 'verified'])->name('generatePDFIva');
Route::get('generate-pdf/{data}', [PDFController::class, 'generatePDF'])->middleware(['auth', 'verified'])->name('generatePDF');

Route::get('cerrar-venta', [PDFController::class, 'cerrarVenta'])->middleware(['auth', 'verified'])->name('cerrarVenta');

Route::get('ventas-cerradas',[VentaController::class, 'ventasCerradas'])->middleware(['auth', 'verified'])->name('ventas-cerradas.index');
Route::get('exportar-excel', [VentaController::class, 'exportarVentas'])->middleware(['auth', 'verified'])->name('ventas-cerradas-excel');


Route::get('reabrir-venta', [VentaController::class, 'reabrirVenta'])->name('reabrirVenta');


Route::get('logs', [LogsController::class , 'index'])->name('logs.index');
Route::get('log-reabrir', [LogsController::class , 'logReabrir'])->name('logs.reabrir');


 /* 

Route::get('/index', [VentaController::class, 'create'])->name('venta.create.index'); */

Route::get('/',[VentaController::class, 'create'])->middleware(['auth', 'verified'])->name('venta.create.index');
Route::get('/dashboard',[VentaController::class, 'create'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';