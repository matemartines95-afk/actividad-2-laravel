@extends('layouts.app')
@section('title', 'Registro')
@section('content')
<div class="row justify-content-center"><div class="col-md-6">
<div class="card shadow-sm"><div class="card-body p-4">
<h1 class="h3 text-center mb-4">Crear cuenta</h1>
<form id="formRegistro" action="{{ route('registro.procesar') }}" method="POST">
    @csrf
    <div class="mb-3"><label for="name" class="form-label">Nombre</label><input class="form-control" id="name" name="name" required maxlength="255"></div>
    <div class="mb-3"><label for="email" class="form-label">Correo electrónico</label><input class="form-control" id="email" name="email" type="email" required maxlength="255"></div>
    <div class="mb-3"><label for="edad" class="form-label">Edad</label><input class="form-control" id="edad" name="edad" type="number" min="18" max="120" required></div>
    <div class="mb-3"><label for="password" class="form-label">Contraseña</label><input class="form-control" id="password" name="password" type="password" minlength="6" required autocomplete="new-password"></div>
    <div class="mb-3"><label for="password_confirmation" class="form-label">Confirmar contraseña</label><input class="form-control" id="password_confirmation" name="password_confirmation" type="password" minlength="6" required autocomplete="new-password"></div>
    <button class="btn btn-primary w-100" type="submit">Registrarse</button>
</form>
<div id="resultado" class="mt-3" aria-live="polite"></div>
<p class="text-center mt-3 mb-0">¿Ya tenés cuenta? <a href="{{ route('login') }}">Iniciá sesión</a></p>
</div></div></div></div>
@endsection
