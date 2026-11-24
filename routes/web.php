<?php

use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PanelAlumnoController;
use Illuminate\Support\Facades\Route;

// Raíz: redirige según el estado de sesión y el rol.
Route::get('/', function () {
    $user = auth()->user();

    if (! $user) {
        return redirect()->route('login');
    }

    return redirect()->route($user->isProfesor() ? 'alumnos.index' : 'alumno.panel');
});

// Autenticación
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:6,1')
        ->name('login.attempt');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// PROFESOR: CRUD completo de alumnos
Route::middleware(['auth', 'role:profesor'])->group(function () {
    Route::resource('alumnos', AlumnoController::class)->except('show');
});

// ALUMNO: solo consulta de su información
Route::middleware(['auth', 'role:alumno'])->group(function () {
    Route::get('/mi-informacion', [PanelAlumnoController::class, 'index'])
        ->name('alumno.panel');
});
