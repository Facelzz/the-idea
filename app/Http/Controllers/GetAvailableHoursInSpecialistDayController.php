<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\{GetAvailableDaysForSpecialistAction, GetAvailableHoursInDayForSpecialistAction};
use App\Exceptions\SpecialistNotFoundException;
use App\Http\Requests\GetAvailableHoursInSpecialistDayRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class GetAvailableHoursInSpecialistDayController
{
    public function __invoke(
        GetAvailableHoursInSpecialistDayRequest $request,
        GetAvailableDaysForSpecialistAction $getAvailableDaysForSpecialist,
        GetAvailableHoursInDayForSpecialistAction $getAvailableHoursForSpecialist,
    ): JsonResponse {
        try {
            $dates = $getAvailableDaysForSpecialist->execute($request->getSpecialistId(), now()->addMonths(3));
            if (!in_array($request->getDay()->format('d-m-Y'), $dates->toArray(), true)) {
                return response()->json([
                    'error' => __('errors.no_free_hours.code'),
                    'message' => __('errors.no_free_hours.message'),
                ], SymfonyResponse::HTTP_NOT_FOUND);
            }

            $hours = $getAvailableHoursForSpecialist->execute($request->getSpecialistId(), $request->getDay());

            return response()->json($hours);
        } catch (SpecialistNotFoundException) {
            return response()->json([
                'error' => __('errors.specialist_not_found.code'),
                'message' => __('errors.specialist_not_found.message'),
            ], SymfonyResponse::HTTP_NOT_FOUND);
        }
    }
}
