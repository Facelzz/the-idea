<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property int|string $specialityId
 */
class GetSpecialistListRequest extends FormRequest implements ExtendableRequestInterface
{
    use CollectsRulesFromMethods;
    use HasPaginationParameters;

    public function rules(): array
    {
        return [
            ...$this->collectRules(),
            'specialityId' => [
                'bail',
                'sometimes',
                'nullable',
                'int',
                'min:1',
                Rule::exists('specialities', 'id')->whereNull('deleted_at'),
            ],
        ];
    }

    public function getSpecialityId(): ?int
    {
        return $this->specialityId ? (int) $this->specialityId : null;
    }
}
