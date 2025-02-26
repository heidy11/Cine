<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PeliculaController; // Ensure this controller exists in the specified namespace
use App\Http\Controllers\FuncionController;
use App\Http\Controllers\ButacaController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\SalaController;
use App\Http\Controllers\PromocionController;
use App\Http\Middleware\AdminMiddleware;


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

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
//CRUD DE ADMINISTRADOR
Route::middleware(AdminMiddleware::class)->group(function () {
    Route::resource('salas', SalaController::class);
    Route::resource('peliculas', PeliculaController::class);
    Route::resource('funciones', FuncionController::class);
});
Route::middleware(AdminMiddleware::class)->group(function () {
    Route::resource('salas', SalaController::class);
});
Route::get('/cartelera', [FuncionController::class, 'cartelera'])->name('cartelera');
Route::middleware(['auth'])->group(function () {
    Route::get('/reservar/{funcion_id}', [ReservaController::class, 'create'])->name('reservar.form');
    Route::post('/reservar', [ReservaController::class, 'store'])->name('reservar');
    Route::get('/mis-reservas', [ReservaController::class, 'index'])->name('reservas.index');
});




require __DIR__.'/auth.php';