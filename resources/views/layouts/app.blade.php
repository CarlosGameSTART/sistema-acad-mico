<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Sistema Académico')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
@auth
    <header class="navbar">
        <div class="navbar-brand">Sistema Académico</div>

        <nav class="navbar-menu">
            @if (auth()->user()->isProfesor())
                <a href="{{ route('alumnos.index') }}">Alumnos</a>
                <a href="{{ route('alumnos.create') }}">Registrar alumno</a>
            @else
                <a href="{{ route('alumno.panel') }}">Mi información</a>
            @endif
        </nav>

        <div class="navbar-user">
            <span>
                {{ auth()->user()->name }}
                <small class="role-tag">{{ ucfirst(auth()->user()->role) }}</small>
            </span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-button type="submit" variant="light">Cerrar sesión</x-button>
            </form>
        </div>
    </header>
@endauth

<main class="container">
    <x-alert />
    @yield('content')
</main>
</body>
</html>
