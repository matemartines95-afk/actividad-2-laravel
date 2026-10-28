@extends('layouts.app')
@section('title', 'Mi perfil')
@section('content')
<div class="row justify-content-center"><div class="col-md-7">
<div class="card shadow-sm"><div class="card-body p-4">
<h1 class="h3 mb-4">Mi perfil</h1>
<div class="mb-3"><strong>Correo:</strong> <span>{{ $usuario->email }}</span></div>
<form id="formPerfil" action="{{ route('perfil.actualizar') }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3"><label for="name" class="form-label">Nombre</label><input class="form-control" id="name" name="name" value="{{ $usuario->name }}" maxlength="255" required></div>
    <div class="mb-3"><label for="edad" class="form-label">Edad</label><input class="form-control" id="edad" name="edad" type="number" min="18" max="120" value="{{ $usuario->edad }}" required></div>
    <button class="btn btn-primary" type="submit">Guardar cambios</button>
</form>
<div id="resultadoPerfil" class="mt-3" aria-live="polite"></div>
</div></div></div></div>
@endsection
