<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\GetAvailableDaysForSpecialistAction;
use App\Exceptions\SpecialistNotFoundException;
use App\Http\Requests\GetAvailableDaysForSpecialistRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class GetAvailableDaysForSpecialistController
{
    public function __invoke(
        GetAvailableDaysForSpecialistRequest $request,
        GetAvailableDaysForSpecialistAction $getAvailableDaysForSpecialist
    ): JsonResponse {
        try {
            $dates = $getAvailableDaysForSpecialist->execute($request->getSpecialistId(), $request->getDueTo());

            return response()->json($dates);
        } catch (SpecialistNotFoundException) {
            return response()->json([
                'error' => __('errors.specialist_not_found.code'),
                'message' => __('errors.specialist_not_found.message'),
            ], SymfonyResponse::HTTP_NOT_FOUND);
        }
    }
}
