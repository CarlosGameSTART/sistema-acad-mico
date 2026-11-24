<?php

namespace Database\Seeders;

use App\Models\Alumno;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Profesor de prueba
        User::create([
            'name' => 'Profesor Demo',
            'email' => 'profesor@escuela.test',
            'password' => 'password',
            'role' => User::ROL_PROFESOR,
        ]);

        // Alumnos de prueba: [nombre, faltas, calificación]
        $alumnos = [
            ['Ana López', 2, 9.8],
            ['Carlos Pérez', 5, 7.2],
            ['María Hernández', 0, 10],
            ['Luis Ramírez', 12, 5.4],
            ['Sofía Torres', 3, 8.6],
        ];

        foreach ($alumnos as $i => [$nombre, $faltas, $calificacion]) {
            $user = User::create([
                'name' => $nombre,
                'email' => 'alumno'.($i + 1).'@escuela.test',
                'password' => 'password',
                'role' => User::ROL_ALUMNO,
            ]);

            Alumno::create([
                'user_id' => $user->id,
                'nombre' => $nombre,
                'faltas' => $faltas,
                'calificacion' => $calificacion,
            ]);
        }
    }
}
