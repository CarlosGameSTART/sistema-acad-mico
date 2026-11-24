<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Alumno extends Model
{
    /**
     * Umbrales de la equivalencia alfabética (escala 0 a 10).
     * Se pueden ajustar aquí sin tocar el resto del sistema.
     *   NA: menor a 6
     *   SA: de 6 a 7.99
     *   DE: de 8 a 9.49
     *   AU: de 9.5 a 10
     */
    public const MIN_SUFICIENTE = 6;
    public const MIN_DESTACADO = 8;
    public const MIN_AUTONOMO = 9.5;

    public const CALIFICACION_MAX = 10;
    public const FALTAS_MAX = 100;

    protected $fillable = [
        'user_id',
        'nombre',
        'faltas',
        'calificacion',
    ];

    protected function casts(): array
    {
        return [
            'faltas' => 'integer',
            'calificacion' => 'float',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Equivalencia alfabética calculada automáticamente: $alumno->equivalencia
     */
    public function getEquivalenciaAttribute(): string
    {
        $c = (float) $this->calificacion;

        return match (true) {
            $c >= self::MIN_AUTONOMO => 'AU',
            $c >= self::MIN_DESTACADO => 'DE',
            $c >= self::MIN_SUFICIENTE => 'SA',
            default => 'NA',
        };
    }

    public function getEquivalenciaNombreAttribute(): string
    {
        return match ($this->equivalencia) {
            'AU' => 'Autónomo',
            'DE' => 'Destacado',
            'SA' => 'Suficiente',
            default => 'No Acreditado',
        };
    }
}
