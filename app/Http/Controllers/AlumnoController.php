<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlumnoRequest;
use App\Models\Alumno;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AlumnoController extends Controller
{
    /** Campos por los que se permite ordenar (lista blanca). */
    private const CAMPOS_ORDEN = ['nombre', 'calificacion', 'faltas'];

    public function index(Request $request): View
    {
        $orden = in_array($request->query('orden'), self::CAMPOS_ORDEN, true)
            ? $request->query('orden')
            : 'nombre';

        $dir = $request->query('dir') === 'desc' ? 'desc' : 'asc';

        $alumnos = Alumno::orderBy($orden, $dir)
            ->orderBy('nombre') // desempate estable
            ->get();

        return view('alumnos.index', compact('alumnos', 'orden', 'dir'));
    }
    // este es metodo para crear 
    public function create(): View
    {
        return view('alumnos.create');
    }

    public function store(AlumnoRequest $request): RedirectResponse
    {
        $datos = $request->validated();

        DB::transaction(function () use ($datos) {
            $user = User::create([
                'name' => $datos['nombre'],
                'email' => $datos['email'],
                'password' => $datos['password'], // se hashea con el cast 'hashed'
                'role' => User::ROL_ALUMNO,
            ]);

            Alumno::create([
                'user_id' => $user->id,
                'nombre' => $datos['nombre'],
                'faltas' => $datos['faltas'],
                'calificacion' => $datos['calificacion'],
            ]);
        });

        return redirect()->route('alumnos.index')
            ->with('status', 'Alumno registrado correctamente.');
    }
    //funcion para editar
    public function edit(Alumno $alumno): View
    {
        $alumno->load('user');

        return view('alumnos.edit', compact('alumno'));
    }

    public function update(AlumnoRequest $request, Alumno $alumno): RedirectResponse
    {
        $datos = $request->validated();

        DB::transaction(function () use ($datos, $alumno) {
            $alumno->update([
                'nombre' => $datos['nombre'],
                'faltas' => $datos['faltas'],
                'calificacion' => $datos['calificacion'],
            ]);

            $usuario = [
                'name' => $datos['nombre'],
                'email' => $datos['email'],
            ];

            if (! empty($datos['password'])) {
                $usuario['password'] = $datos['password'];
            }

            $alumno->user->update($usuario);
        });

        return redirect()->route('alumnos.index')
            ->with('status', 'Datos del alumno actualizados.');
    }

    public function destroy(Alumno $alumno): RedirectResponse
    {
        DB::transaction(function () use ($alumno) {
            $user = $alumno->user;
            $alumno->delete();
            $user?->delete();
        });

        return redirect()->route('alumnos.index')
            ->with('status', 'Alumno eliminado.');
    }
}
