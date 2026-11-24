@extends('layouts.app')

@section('title', 'Alumnos')

@section('content')
    <div class="page-header">
        <h1>Listado de alumnos</h1>
        <x-button :href="route('alumnos.create')">+ Registrar alumno</x-button>
    </div>

    {{-- Ordenamiento --}}
    <form method="GET" action="{{ route('alumnos.index') }}" class="toolbar">
        <label>
            Ordenar por
            <select name="orden">
                <option value="nombre" @selected($orden === 'nombre')>Nombre (alfabético)</option>
                <option value="calificacion" @selected($orden === 'calificacion')>Calificación</option>
                <option value="faltas" @selected($orden === 'faltas')>Número de faltas</option>
            </select>
        </label>

        <label>
            Dirección
            <select name="dir">
                <option value="asc" @selected($dir === 'asc')>Ascendente (A-Z / menor a mayor)</option>
                <option value="desc" @selected($dir === 'desc')>Descendente (Z-A / mayor a menor)</option>
            </select>
        </label>

        <x-button type="submit">Aplicar</x-button>
    </form>

    <div class="card">
        <table class="table">
            <thead>
            <tr>
                <th><x-sort-link campo="nombre" :orden="$orden" :dir="$dir">Nombre del alumno</x-sort-link></th>
                <th><x-sort-link campo="faltas" :orden="$orden" :dir="$dir">Faltas</x-sort-link></th>
                <th><x-sort-link campo="calificacion" :orden="$orden" :dir="$dir">Calificación</x-sort-link></th>
                <th>Equivalencia</th>
                <th class="col-acciones">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($alumnos as $alumno)
                <tr>
                    <td>{{ $alumno->nombre }}</td>
                    <td>{{ $alumno->faltas }}</td>
                    <td>{{ number_format($alumno->calificacion, 2) }}</td>
                    <td><x-equivalencia :valor="$alumno->equivalencia" title="{{ $alumno->equivalencia_nombre }}" /></td>
                    <td class="col-acciones">
                        <x-button :href="route('alumnos.edit', $alumno)" variant="outline">Editar</x-button>

                        <form method="POST" action="{{ route('alumnos.destroy', $alumno) }}" class="inline"
                              onsubmit="return confirm('¿Eliminar a {{ e($alumno->nombre) }}? Esta acción no se puede deshacer.')">
                            @csrf
                            @method('DELETE')
                            <x-button type="submit" variant="danger">Eliminar</x-button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="empty">Aún no hay alumnos registrados.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <p class="leyenda muted">
        <strong>NA</strong> No Acreditado · <strong>SA</strong> Suficiente ·
        <strong>DE</strong> Destacado · <strong>AU</strong> Autónomo
    </p>
@endsection
