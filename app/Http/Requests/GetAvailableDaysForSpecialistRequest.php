<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

/**
 * @property int|string $specialist
 */
class GetAvailableDaysForSpecialistRequest extends FormRequest
{
    public function validationData(): array
    {
        return [...$this->all(), ...$this->route()?->parameters()];
    }

    public function rules(): array
    {
        return [
            'specialist' => ['bail', 'required', 'int', 'min:1'],
            'dueTo' => ['bail', 'sometimes', 'nullable', 'date', 'after:tomorrow'],
        ];
    }

    public function getSpecialistId(): int
    {
        return (int) $this->specialist;
    }

    public function getDueTo(): Carbon
    {
        return $this->input('dueTo') ? new Carbon($this->input('dueTo')) : now()->lastOfMonth()->addDay();
    }
}
