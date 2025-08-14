<?php

use App\Exports\UsuariosExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\pagoUsuarios\AbonoController;
use App\Http\Controllers\pagoUsuarios\ComentarioAbonoController;
use App\Http\Controllers\pagoUsuarios\ComentarioPagoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\pagoUsuarios\PagoController;
use App\Http\Controllers\pagoUsuarios\UsuarioController;
use App\Http\Controllers\tasas\TasaController;
use App\Models\ComentarioPago;
use App\Exports\TasasExport;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
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
    // Rutas Administración
    Route::get('/menu/administracion', function () {
        return view('areas/administracion/menu');
    });




    // Rutas Pago Usuarios
    Route::get('/usuarios', [UsuarioController::class, 'listarUsuarios'])->name('usuarios.listar');
    Route::post('/usuarios/nuevo', [UsuarioController::class, 'nuevoUsuario']);
    Route::put('/usuarios/{id}', [UsuarioController::class, 'actualizarUsuario'])->name('usuarios.actualizar');
    Route::get('/usuarios/detalle/{id}', [UsuarioController::class, 'detalleUsuario'])->name('usuarios.detalle');
    Route::get('/exportar-usuarios', function () {
        return Excel::download(new UsuariosExport, 'usuarios.xlsx');
    })->name('exportar.usuarios');

    Route::get('/comentariospagos/{pagoUsuarioId}', [ComentarioPagoController::class, 'comentariosPorPago']);
    Route::post('/comentariospagos', [ComentarioPagoController::class, 'store'])->name('comentariospagos.store');

    Route::get('/comentariosabonos/{abonoId}', [ComentarioAbonoController::class, 'comentariosAbono']);
    Route::post('/comentariosabonos', [ComentarioAbonoController::class, 'store'])->name('comentariosabonos.store');


    Route::post('/pago/nuevo', [PagoController::class, 'nuevoPago'])->name('pagos.nuevo');
    Route::get('/pagos/detalle/abonos/{proveedorId}/{pagoId}', [AbonoController::class, 'detalleAbono']);
    Route::post('/abonos/nuevo', [AbonoController::class, 'nuevoAbono']);
    Route::get('/exportar-pago/{id}', [PagoController::class, 'exportPagoConAbonos'])->name('exportar.pago');

    Route::get('/pagos/editar/{pago}', [PagoController::class, 'editar'])->name('pagos.editar');
    Route::get('/abonos/editar/{abono}', [AbonoController::class, 'editar'])->name('abonos.editar');
    Route::put('/pagos/actualizar/{pago}', [PagoController::class, 'updatePago'])->name('pagos.actualizar');
    Route::put('/abonos/actualizar/{abono}', [AbonoController::class, 'updateAbono'])->name('abonos.actualizar');

    Route::delete('/pagos/{id}', [PagoController::class, 'destroy'])->name('pagos.destroy');
    Route::delete('/abonos/{id}', [AbonoController::class, 'destroy'])->name('abonos.destroy');




    Route::get('/tasas', [TasaController::class, 'listarTasas'])->name('tasas.listar');
    Route::post('/tasas', [TasaController::class, 'store'])->name('tasas.store');

    Route::get('/tasas/detalle/{anio}', [TasaController::class, 'edit'])->name('tasas.edit');
    Route::put('/tasas/{anio}', [TasaController::class, 'update'])->name('tasas.update');
    Route::get('/tasas/exportar', [TasaController::class, 'exportar'])->name('tasas.exportar');
});







// Rutas personalizadas

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
