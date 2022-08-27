<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\SpecialistStatus;
use Database\Factories\SpecialistFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\{Builder, Model, SoftDeletes};

/**
 * @property int $id
 * @property SpecialistStatus $status
 * @property string $name
 * @property null|int $speciality_id
 * @property null|Specialist $speciality
 *
 * @method Builder|self active()
 * @method static SpecialistFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Specialist extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    protected $casts = [
        'status' => SpecialistStatus::class,
    ];

    public function speciality(): BelongsTo
    {
        return $this->belongsTo(Speciality::class);
    }

    public function scopeActive(Builder $builder): Builder
    {
        return $builder->where('status', SpecialistStatus::Active);
    }

    protected static function newFactory(): SpecialistFactory
    {
        return new SpecialistFactory();
    }
}
