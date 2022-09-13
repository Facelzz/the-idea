<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\AppointmentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $specialist_id
 * @property Specialist $specialist
 * @property Carbon $time
 *
 * @method static AppointmentFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Appointment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    protected $casts = [
        'time' => 'datetime',
    ];

    public function specialist(): BelongsTo
    {
        return $this->belongsTo(Specialist::class);
    }

    protected static function newFactory(): AppointmentFactory
    {
        return new AppointmentFactory();
    }
}
