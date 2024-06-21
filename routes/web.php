<?php

use App\Http\Controllers\pagoProveedores\AbonoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\repertorioSocios\SocioController;
use App\Http\Controllers\pagoProveedores\ProveedorController;
use App\Http\Controllers\pagoProveedores\PagoController;
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

    // Rutas Pago Proveedores
    Route::get('/proveedores', [ProveedorController::class, 'listarProveedores']);
    Route::post('/proveedores/nuevo', [ProveedorController::class, 'nuevoProveedor']);
    Route::get('/proveedores/detalle/{id}', [ProveedorController::class, 'detalleProveedor']);
    Route::post('/pago/nuevo', [PagoController::class, 'nuevoPago']);


    Route::get('/pagos/detalle/abonos/{proveedorId}/{pagoId}', [AbonoController::class, 'detalleAbono']);
    Route::post('/abonos/nuevo', [AbonoController::class, 'nuevoAbono']);
    

});







// Rutas personalizadas

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
