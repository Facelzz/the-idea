<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\GetAvailableDaysForSpecialistAction;
use App\Exceptions\SpecialistNotFoundException;
use App\Http\Requests\GetAvailableHoursInSpecialistDayRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class GetAvailableHoursInSpecialistDayController
{
    public function __invoke(
        GetAvailableHoursInSpecialistDayRequest $request,
        GetAvailableDaysForSpecialistAction $getAvailableDaysForSpecialist
    ): JsonResponse {
        try {
            $dates = $getAvailableDaysForSpecialist->execute($request->getSpecialistId(), now()->addMonths(3));
            if (!in_array($request->getDay(), $dates->toArray(), true)) {
                return response()->json([
                    'error' => __('errors.no_free_hours.code'),
                    'message' => __('errors.no_free_hours.message'),
                ], SymfonyResponse::HTTP_NOT_FOUND);
            }

            return response()->json();
        } catch (SpecialistNotFoundException) {
            return response()->json([
                'error' => __('errors.specialist_not_found.code'),
                'message' => __('errors.specialist_not_found.message'),
            ], SymfonyResponse::HTTP_NOT_FOUND);
        }
    }
}
