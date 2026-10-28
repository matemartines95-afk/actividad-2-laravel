@extends('layouts.app')
@section('title', 'Iniciar sesión')
@section('content')
<div class="row justify-content-center"><div class="col-md-5">
<div class="card shadow-sm"><div class="card-body p-4">
<h1 class="h3 text-center mb-4">Iniciar sesión</h1>
<form id="formLogin" action="{{ route('login.procesar') }}" method="POST">
    @csrf
    <div class="mb-3"><label for="email" class="form-label">Correo electrónico</label><input class="form-control" id="email" name="email" type="email" required autocomplete="username"></div>
    <div class="mb-3"><label for="password" class="form-label">Contraseña</label><input class="form-control" id="password" name="password" type="password" required autocomplete="current-password"></div>
    <button class="btn btn-primary w-100" type="submit">Ingresar</button>
</form>
<div id="resultadoLogin" class="mt-3" aria-live="polite"></div>
<p class="text-center mt-3 mb-0">¿No tenés cuenta? <a href="{{ route('registro') }}">Registrate</a></p>
</div></div></div></div>
@endsection
