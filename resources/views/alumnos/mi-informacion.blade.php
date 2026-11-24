@extends('layouts.app')

@section('title', 'Mi información')

@section('content')
    <div class="page-header">
        <h1>Mi información académica</h1>
    </div>

    @if ($alumno)
        <div class="card">
            <table class="table table-info">
                <tbody>
                <tr>
                    <th>Nombre</th>
                    <td>{{ $alumno->nombre }}</td>
                </tr>
                <tr>
                    <th>Número de faltas</th>
                    <td>{{ $alumno->faltas }}</td>
                </tr>
                <tr>
                    <th>Calificación</th>
                    <td>{{ number_format($alumno->calificacion, 2) }}</td>
                </tr>
                <tr>
                    <th>Equivalencia</th>
                    <td>
                        <x-equivalencia :valor="$alumno->equivalencia" />
                        <span class="muted">{{ $alumno->equivalencia_nombre }}</span>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    @else
        <div class="card">
            <p class="empty">Todavía no tienes información académica registrada.</p>
        </div>
    @endif
@endsection
