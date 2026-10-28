<?php

use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/registro');

Route::get('/registro', [UsuarioController::class, 'mostrarRegistro'])
    ->name('registro');
Route::post('/registro', [UsuarioController::class, 'registrar'])
    ->name('registro.procesar');

Route::get('/login', [UsuarioController::class, 'mostrarLogin'])
    ->name('login');
Route::post('/login', [UsuarioController::class, 'login'])
    ->name('login.procesar');

Route::middleware('auth')->group(function () {
    Route::get('/perfil', [UsuarioController::class, 'perfil'])
        ->name('perfil');
    Route::put('/perfil', [UsuarioController::class, 'actualizarPerfil'])
        ->name('perfil.actualizar');
    Route::post('/logout', [UsuarioController::class, 'logout'])
        ->name('logout');
});
