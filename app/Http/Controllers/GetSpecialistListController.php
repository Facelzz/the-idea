<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\GetActiveSpecialistsAction;
use App\Http\Requests\GetSpecialistListRequest;
use App\Http\Resources\SpecialistListResource;
use Illuminate\Http\JsonResponse;

class GetSpecialistListController
{
    public function __invoke(
        GetSpecialistListRequest $request,
        GetActiveSpecialistsAction $getSpecialists
    ): JsonResponse {
        $specialists = $getSpecialists->execute(
            $request->getPage(),
            $request->getPerPage(),
            $request->getSpecialityId()
        );

        return response()->json(SpecialistListResource::collection($specialists));
    }
}
