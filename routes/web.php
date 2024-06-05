<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocioController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// Rutas personalizadas
Route::get('/menu/socios', function () {
    return view('areas/socios/menu');
});

Route::get('/menu/socios/repertorio', function () {
    return view('areas/socios/buscador');
});

Route::match(['get', 'post'],'/menu/socios/repertorio/buscar', [SocioController::class, 'buscarIdentificacion']);

// Rutas personalizadas

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
