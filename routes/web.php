<?php

use App\Http\Controllers\pagoProveedores\AbonoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\repertorioSocios\SocioController;
use App\Http\Controllers\pagoProveedores\ProveedorController;
use App\Http\Controllers\pagoProveedores\PagoController;
use App\Http\Controllers\pagoProveedores\DistribucionController;
use App\Http\Controllers\RepertorioSocios\ProduccionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});














Route::middleware('auth')->group(function () {
    // Rutas menu
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');
    // Rutas distribucion
    Route::get('/menu/distribucion', function () {
        return view('areas/distribucion/menu');
    });
    // Rutas Socios
    Route::get('/menu/socios', function () {
        return view('areas/socios/menu');
    });

    Route::post('/nuevosocio', [SocioController::class, 'nuevoSocio']);
    Route::match(['get', 'post'], '/menu/socios/repertorio/buscar', [SocioController::class, 'buscarIdentificacion']);

    // Rutas Repertorio
    Route::get('/menu/socios/repertorio', [SocioController::class, 'listarTotalSocios']);
    Route::get('/menu/socios/repertorio/socio/{id}', [SocioController::class, 'detalleSocio']);
    Route::get('/agregarProduccion/{id}', [ProduccionController::class, 'vistaAgregarProduccion']);
    Route::get('/listarProducciones',[ProduccionController::class, 'listarProducciones'])->name('listarProducciones');
    Route::post('/agregarProduccionesRepertorio', [ProduccionController::class, 'agregarProduccionesRepertorio']);
    Route::post('/editarPersonaje', [ProduccionController::class, 'editarPersonajeProduccion']);
    Route::get('/eliminarProduccion/{id}', [ProduccionController::class, 'eliminarProduccion']);
    Route::get('/exportarRepertorio', [ProduccionController::class, 'exportarRepertorio']);
    Route::get('/exportarRepertorioIndividual/{id}', [ProduccionController::class, 'exportarRepertorioIndividual']);
    Route::get('/producciones', [ProduccionController::class, 'indexListarProducciones'])->name('producciones');
    Route::get('/nuevaproduccion', [ProduccionController::class, 'nuevaProduccion']);

    Route::post('/agregarProduccion', [ProduccionController::class, 'agregarProducciones']);
    Route::get('/exportarProducciones', [ProduccionController::class, 'exportarProducciones']);

    

    // Rutas Pago Proveedores
    Route::get('/proveedores', [ProveedorController::class, 'listarProveedores']);
    Route::post('/proveedores/nuevo', [ProveedorController::class, 'nuevoProveedor']);
    Route::get('/proveedores/detalle/{id}', [ProveedorController::class, 'detalleProveedor']);
    Route::post('/pago/nuevo', [PagoController::class, 'nuevoPago']);


    Route::get('/pagos/detalle/abonos/{proveedorId}/{pagoId}', [AbonoController::class, 'detalleAbono']);
    Route::post('/abonos/nuevo', [AbonoController::class, 'nuevoAbono']);
    
    Route::get('/distribucion/recuento', [DistribucionController::class, 'recuentoPagosDistribucion']);

});







// Rutas personalizadas

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
