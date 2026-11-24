@extends('layouts.app')

@section('title', 'Registrar alumno')

@section('content')
    <div class="page-header">
        <h1>Registrar alumno</h1>
    </div>

    <div class="card">
        <form method="POST" action="{{ route('alumnos.store') }}">
            @csrf
            @include('alumnos._form')
        </form>
    </div>
@endsection
