<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

/**
 * @property int|string $specialist
 */
class GetAvailableHoursInSpecialistDayRequest extends FormRequest
{
    public function validationData(): array
    {
        return [...$this->all(), ...$this->route()?->parameters()];
    }

    public function rules(): array
    {
        return [
            'specialist' => ['bail', 'required', 'int', 'min:1'],
            'day' => ['bail', 'required', 'date', 'after:tomorrow'],
        ];
    }

    public function getSpecialistId(): int
    {
        return (int) $this->specialist;
    }

    public function getDay(): Carbon
    {
        return new Carbon($this->input('day'));
    }
}
