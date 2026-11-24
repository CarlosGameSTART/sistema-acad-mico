@php($esEdicion = isset($alumno))

<div class="form-group">
    <label for="nombre">Nombre del alumno</label>
    <input type="text" id="nombre" name="nombre" maxlength="100" required
           value="{{ old('nombre', $alumno->nombre ?? '') }}">
</div>

<div class="form-row">
    <div class="form-group">
        <label for="email">Correo (usuario de acceso)</label>
        <input type="email" id="email" name="email" required
               value="{{ old('email', $alumno->user->email ?? '') }}">
    </div>

    <div class="form-group">
        <label for="password">
            Contraseña @if ($esEdicion) <span class="muted">(déjala vacía para no cambiarla)</span> @endif
        </label>
        <input type="password" id="password" name="password" minlength="8" autocomplete="new-password"
               @unless($esEdicion) required @endunless>
    </div>
</div>

<div class="form-row">
    <div class="form-group">
        <label for="faltas">Número de faltas (0 a {{ \App\Models\Alumno::FALTAS_MAX }})</label>
        <input type="number" id="faltas" name="faltas" min="0" max="{{ \App\Models\Alumno::FALTAS_MAX }}" step="1" required
               value="{{ old('faltas', $alumno->faltas ?? 0) }}">
    </div>

    <div class="form-group">
        <label for="calificacion">Calificación (0 a {{ \App\Models\Alumno::CALIFICACION_MAX }})</label>
        <input type="number" id="calificacion" name="calificacion" min="0" max="{{ \App\Models\Alumno::CALIFICACION_MAX }}" step="0.01" required
               value="{{ old('calificacion', $alumno->calificacion ?? '') }}">
    </div>
</div>

<p class="muted">La equivalencia alfabética (NA, SA, DE, AU) se calcula automáticamente con la calificación.</p>

<div class="form-actions">
    <x-button type="submit">{{ $esEdicion ? 'Guardar cambios' : 'Registrar alumno' }}</x-button>
    <x-button :href="route('alumnos.index')" variant="outline">Cancelar</x-button>
</div>
