<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetSpecialityListRequest extends FormRequest implements ExtendableRequestInterface
{
    use CollectsRulesFromMethods;
    use HasPaginationParameters;

    public function rules(): array
    {
        return $this->collectRules();
    }
}
