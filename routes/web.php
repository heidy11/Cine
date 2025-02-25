<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PeliculaController; // Ensure this controller exists in the specified namespace
use App\Http\Controllers\FuncionController;
use App\Http\Controllers\ButacaController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\PagoController;

use App\Http\Controllers\PromocionController;


use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {

    // Rutas exclusivas para administradores
    Route::middleware('role:admin')->group(function () {
        Route::resource('usuarios', UsuarioController::class);
        Route::resource('peliculas', PeliculaController::class);
        Route::resource('funciones', FuncionController::class);
    });

    // Rutas exclusivas para usuarios normales
    Route::middleware('role:usuario')->group(function () {
        Route::get('/comprar-boletos', [CompraController::class, 'index']);
    });

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', function () {
        return redirect('/dashboard');
    })->name('profile.edit');
});


require __DIR__.'/auth.php';