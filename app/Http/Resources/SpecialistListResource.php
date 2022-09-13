<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Specialist;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Specialist */
class SpecialistListResource extends JsonResource
{
    /**
     * @param Request $request
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'speciality' => $this->speciality ? new SpecialityListResource($this->speciality) : null,
        ];
    }
}
