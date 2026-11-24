@extends('layouts.app')

@section('title', 'Editar alumno')

@section('content')
    <div class="page-header">
        <h1>Editar alumno</h1>
    </div>

    <div class="card">
        <form method="POST" action="{{ route('alumnos.update', $alumno) }}">
            @csrf
            @method('PUT')
            @include('alumnos._form')
        </form>
    </div>
@endsection
