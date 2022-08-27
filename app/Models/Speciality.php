<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\SpecialityFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

/**
 * @property string $name
 *
 * @method static SpecialityFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Speciality extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    protected static function newFactory(): SpecialityFactory
    {
        return new SpecialityFactory();
    }
}
