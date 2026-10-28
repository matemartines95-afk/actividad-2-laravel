<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistema de usuarios')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('registro') }}">Sistema de Usuarios</a>
        @auth
            <div class="d-flex gap-2 align-items-center">
                <a href="{{ route('perfil') }}" class="btn btn-outline-light">Mi perfil</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-danger" type="submit">Cerrar sesión</button>
                </form>
            </div>
        @else
            <a class="btn btn-outline-light" href="{{ route('login') }}">Iniciar sesión</a>
        @endauth
    </div>
</nav>
<main class="container py-5">
    @yield('content')
</main>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
