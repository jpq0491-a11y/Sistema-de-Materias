<?php

namespace App\Models;

use Database\Factories\HorarioFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $materia_id
 * @property int $dia
 * @property string $hora_inicio
 * @property string $hora_fin
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['dia', 'hora_inicio', 'hora_fin'])]
class Horario extends Model
{
    /** @use HasFactory<HorarioFactory> */
    use HasFactory;

    /**
     * Day numbers (ISO-8601, Monday = 1) mapped to their names.
     *
     * @var array<int, string>
     */
    public const DIAS = [
        1 => 'Lunes',
        2 => 'Martes',
        3 => 'Miércoles',
        4 => 'Jueves',
        5 => 'Viernes',
        6 => 'Sábado',
        7 => 'Domingo',
    ];

    /**
     * Get the materia this horario belongs to.
     *
     * @return BelongsTo<Materia, $this>
     */
    public function materia(): BelongsTo
    {
        return $this->belongsTo(Materia::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'dia' => 'integer',
        ];
    }

    /**
     * The start time formatted as HH:MM.
     *
     * @return Attribute<string, string>
     */
    protected function horaInicio(): Attribute
    {
        return Attribute::get(fn (string $value): string => substr($value, 0, 5));
    }

    /**
     * The end time formatted as HH:MM.
     *
     * @return Attribute<string, string>
     */
    protected function horaFin(): Attribute
    {
        return Attribute::get(fn (string $value): string => substr($value, 0, 5));
    }
}
