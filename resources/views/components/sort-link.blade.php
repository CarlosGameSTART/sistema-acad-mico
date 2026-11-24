@props(['campo', 'orden', 'dir'])

@php
    $activo = $orden === $campo;
    $nuevaDir = ($activo && $dir === 'asc') ? 'desc' : 'asc';
    $flecha = $activo ? ($dir === 'asc' ? '▲' : '▼') : '';
@endphp

<a href="{{ route('alumnos.index', ['orden' => $campo, 'dir' => $nuevaDir]) }}"
   class="sort-link {{ $activo ? 'activo' : '' }}">{{ $slot }} {{ $flecha }}</a>
