<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\GetActiveSpecialitiesAction;
use App\Http\Requests\GetSpecialityListRequest;
use App\Http\Resources\SpecialistListResource;
use Illuminate\Http\JsonResponse;

class GetSpecialityListController
{
    public function __invoke(
        GetSpecialityListRequest $request,
        GetActiveSpecialitiesAction $getSpecialists
    ): JsonResponse {
        $specialists = $getSpecialists->execute($request->getPage(), $request->getPerPage());

        return response()->json(SpecialistListResource::collection($specialists));
    }
}
