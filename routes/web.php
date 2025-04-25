<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PeliculaController;
use App\Http\Controllers\FuncionController;
use App\Http\Controllers\ButacaController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\SalaController;
use App\Http\Controllers\PromocionController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard (evita repetirlo dos veces)
Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// ** Agrupamos Rutas Protegidas por Autenticación **
Route::middleware(['auth'])->group(function () {
    Route::post('/reservar', [ReservaController::class, 'store'])->name('reservar');

    // ** Rutas para Administradores **
   // Route::middleware(AdminMiddleware::class)->group(function () {
        Route::resource('usuarios', UsuarioController::class);
        Route::resource('peliculas', PeliculaController::class);
        Route::resource('funciones', FuncionController::class)->parameters([
            'funciones' => 'funcion'
        ]);
        
        Route::resource('salas', SalaController::class);
    

    // ** Rutas para Usuarios Comunes **
    Route::middleware('role:usuario')->group(function () {
        Route::get('/comprar-boletos', [CompraController::class, 'index']);
    });

    // ** Perfil de Usuario **
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ** Rutas para Reservas **
    Route::get('/reservar/{funcion}', [ReservaController::class, 'create'])->name('reservar.form');
    Route::post('/reservar', [ReservaController::class, 'store'])->name('reservar');
    Route::get('/mis-reservas', [ReservaController::class, 'index'])->name('reservas.index');

    Route::get('/reservar/{funcion}', [ButacaController::class, 'show'])->name('butacas.show');  
    Route::post('/reservar/{funcion}', [ReservaController::class, 'store'])->name('reservar.store');  

    Route::get('/butacas/{funcion}', [ButacaController::class, 'show'])->name('butacas.show');

});
Route::get('/api/horas-disponibles', [App\Http\Controllers\FuncionController::class, 'horasDisponibles']);
//HORARIOS
Route::get('/peliculas/{pelicula}/horarios',[FuncionController::class, 'verHorarios'])->name('peliculas.horarios');
// ** Cartelera de funciones (pública) **
Route::get('/cartelera', [FuncionController::class, 'cartelera'])->name('cartelera');
Route::get('/register', function () {
    return view('auth.register'); // ✅ Muestra el formulario directamente
})->name('register');
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');




// Cargar autenticación de Laravel
require __DIR__.'/auth.php';