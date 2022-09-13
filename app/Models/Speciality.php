<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\SpecialityStatus;
use Database\Factories\SpecialityFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Builder, Model, SoftDeletes};

/**
 * @property int $id
 * @property SpecialityStatus $status
 * @property string $name
 *
 * @method Builder|self active()
 * @method static SpecialityFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Speciality extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    protected $casts = [
        'status' => SpecialityStatus::class,
    ];

    public function scopeActive(Builder $builder): Builder
    {
        return $builder->where('status', SpecialityStatus::Active);
    }

    protected static function newFactory(): SpecialityFactory
    {
        return new SpecialityFactory();
    }
}
