<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PanelAlumnoController extends Controller
{
    /**
     * El alumno solo ve SU propia información (solo lectura).
     */
    public function index(): View
    {
        $alumno = auth()->user()->alumno;

        return view('alumnos.mi-informacion', compact('alumno'));
    }
}
