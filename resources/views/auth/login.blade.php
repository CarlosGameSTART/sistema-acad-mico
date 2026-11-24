@extends('layouts.app')

@section('title', 'Iniciar sesión')

@section('content')
    <div class="login-wrapper">
        <div class="card login-card">
            <h1>Sistema Académico</h1>
            <p class="muted">Inicia sesión para continuar</p>

            <form method="POST" action="{{ route('login.attempt') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="form-group checkbox">
                    <label>
                        <input type="checkbox" name="remember" value="1"> Recordarme
                    </label>
                </div>

                <x-button type="submit" class="btn-block">Entrar</x-button>
            </form>
        </div>
    </div>
@endsection
