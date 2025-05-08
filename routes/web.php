<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PeliculaController;
use App\Http\Controllers\FuncionController;
use App\Http\Controllers\ButacaController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\SalaController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\FuncionButacaController;
use App\Models\FuncionButaca;

// Página de bienvenida
Route::get('/', function () {
    return view('welcome');
});

// Autenticación y perfil
require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {
    // Perfil de usuario
    Route::get('/perfil', [PerfilController::class, 'edit'])->name('perfil.edit');
    Route::post('/perfil', [PerfilController::class, 'update'])->name('perfil.update');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Dashboard
Route::middleware(['auth'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Registro
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');

// Cartelera pública
Route::get('/cartelera', [FuncionController::class, 'cartelera'])->name('cartelera');
Route::get('/peliculas/{pelicula}/horarios', [FuncionController::class, 'verHorarios'])->name('peliculas.horarios');
Route::get('/pelicula/{pelicula}/horarios', [FuncionController::class, 'verHorarios'])->name('pelicula.horarios');
Route::get('/verificar-horario-disponible', [FuncionController::class, 'verificarHorario'])->name('funciones.verificarHorario');
Route::get('/horarios-ocupados', [FuncionController::class, 'horariosOcupados'])->name('funciones.horariosOcupados');
Route::get('/api/horas-disponibles', [FuncionController::class, 'horasDisponibles']);

// Rutas protegidas
Route::middleware(['auth'])->group(function () {

    // CRUDs administradores
    Route::resource('usuarios', UsuarioController::class);
    Route::resource('peliculas', PeliculaController::class);
    Route::resource('funciones', FuncionController::class)->parameters(['funciones' => 'funcion']);
    Route::resource('salas', SalaController::class);

    // Compra de boletos
    Route::get('/comprar-boletos', [CompraController::class, 'index'])->middleware('role:usuario');

    // Reservas
   // Route::get('/mis-reservas', [ReservaController::class, 'index'])->name('reservas.index');
   // Route::post('/reservas', [ReservaController::class, 'store'])->name('reservas.store');
   // Route::post('/reservas/confirmar', [ReservaController::class, 'confirmarReserva'])->name('reservas.confirmar');
    //Route::get('/reservas/confirmar', [ReservaController::class, 'confirmarReserva'])->name('reservas.confirmar');
    //Route::post('/reservas/comprobante', [ReservaController::class, 'guardarComprobante'])->name('reservas.comprobante');
   // Route::post('/reservas/{id}/comprobante', [ReservaController::class, 'subirComprobante'])->name('subir.comprobante');

    // Selección de butacas
   // Route::get('/reservar/cinema1/{funcion}', [ReservaController::class, 'reservarCinema1'])->name('reservar.cinema1');
   // Route::get('/reservar/cinema2/{funcion}', [ReservaController::class, 'reservar'])->name('reservar.cinema2');
  // Route::get('/butacas/{funcion}', [ButacaController::class, ''])->name('reservar.reservar');
  Route::get('/butacas/ver/{funcion_id}', [ButacaController::class, 'mostrarButacasPorSala'])->name('butacas.mostrar');

    // Formulario de reserva
    //Route::get('/reservar/{funcion}', [ReservaController::class, 'create'])->name('reservar.form');
    //Route::post('/reservar/{funcion}', [ReservaController::class, 'store'])->name('reservar.store');

    // ADMIN - Gestión de reservas
   
    Route::get('/admin/comprobantes', [FuncionButacaController::class, 'verComprobantes'])->name('admin.comprobantes');

    // Confirmación/Rechazo (PUT)
    //Route::put('/reservas/{id}/confirmar', [ReservaController::class, 'confirmar'])->name('reservas.confirmar.estado');
    //Route::put('/reservas/{id}/rechazar', [ReservaController::class, 'rechazar'])->name('reservas.rechazar.estado');
    Route::get('/butacas/generar/{sala_id}', [ButacaController::class, 'generarButacasPorSala']);
    Route::post('/funcion/{id}/asignar-butacas', [FuncionButacaController::class, 'asignarButacas']);
    Route::post('/funcion-butaca/confirmar', [FuncionButacaController::class, 'confirmarReserva'])->name('funcion.butaca.comprobante');
    Route::post('/funcion-butaca/reservar', [FuncionButacaController::class, 'reservar'])->name('funcion-butaca.reservar');
    Route::post('/funcion-butaca/confirmar', [FuncionButacaController::class, 'confirmarReserva'])->name('funcion-butaca.confirmar');
    Route::post('/funcion-butaca/comprobante', [FuncionButacaController::class, 'subirComprobante'])->name('funcion.butaca.comprobante');
    Route::get('/reservar/{funcion_id}', [FuncionButacaController::class, 'mostrarVistaReserva']);

    Route::get('/admin/comprobantes', [FuncionButacaController::class, 'verComprobantes'])
    ->name('admin.comprobantes');
    Route::get('/mis-entradas', [FuncionButacaController::class, 'misEntradas'])
        ->name('usuario.entradas');
        Route::post('/admin/comprobantes/aceptar/{id}', [FuncionButacaController::class, 'aceptarComprobante'])->name('admin.comprobantes.aceptar');
Route::post('/admin/comprobantes/rechazar/{id}', [FuncionButacaController::class, 'rechazarComprobante'])->name('admin.comprobantes.rechazar');

}   

);
