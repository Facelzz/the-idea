<?php

declare(strict_types=1);

namespace App\Actions;

use App\Exceptions\SpecialistNotFoundException;
use App\Models\Specialist;
use DateInterval;
use DatePeriod;
use Illuminate\Support\{Carbon, Collection};

class GetAvailableDaysForSpecialistAction
{
    /**
     * @throws SpecialistNotFoundException
     */
    public function execute(int $specialistId, Carbon $dueTo): Collection
    {
        $specialist = Specialist::find($specialistId) ?? throw new SpecialistNotFoundException();
        $existingAppointments = $this->getAppointments($specialist);
        $dates = $this->collectDatesFromDueTo($dueTo);

        return $this->subBusyDays($dates, $existingAppointments);
    }

    private function getAppointments(Specialist $specialist): Collection
    {
        return $specialist->appointments()->selectRaw('date(time) as day')->groupBy(['day'])->withCasts([
            'day' => 'datetime',
        ])->get()->pluck('day');
    }

    private function collectDatesFromDueTo(Carbon $dueTo): Collection
    {
        return collect(new DatePeriod(
            start: now()->startOfDay(),
            interval: new DateInterval('P1D'),
            end: $dueTo->setTime(0, 0),
            options: 2
        ))->values()->map(fn (Carbon $dateTime) => $dateTime->format('d-m-Y'));
    }

    private function subBusyDays(Collection $dates, Collection $existingAppointments): Collection
    {
        $except = $existingAppointments->map(fn (Carbon $dateTime) => $dateTime->format('d-m-Y'))->values();

        return $dates->filter(
            fn (string $date) => $except->where(fn (string $exDate) => $date === $exDate)->count() === 0
        );
    }
}
