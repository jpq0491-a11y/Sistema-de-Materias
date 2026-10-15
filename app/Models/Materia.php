<?php

namespace App\Models;

use Database\Factories\MateriaFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $nombre
 * @property int $creditos
 * @property string $profesor
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Horario> $horarios
 */
#[Fillable(['nombre', 'creditos', 'profesor'])]
class Materia extends Model
{
    /** @use HasFactory<MateriaFactory> */
    use HasFactory;

    /**
     * Get the class schedule of the materia, ordered by day and start time.
     *
     * @return HasMany<Horario, $this>
     */
    public function horarios(): HasMany
    {
        return $this->hasMany(Horario::class)->orderBy('dia')->orderBy('hora_inicio');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'creditos' => 'integer',
        ];
    }
}
