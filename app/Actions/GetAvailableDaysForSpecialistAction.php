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
        $dates = $this->subBusyDays($dates, $existingAppointments);

        return $this->prepareResult($dates);
    }

    private function getAppointments(Specialist $specialist): Collection
    {
        return $specialist->appointments()->selectRaw('date_trunc(\'hour\', time) as day')->groupBy(['day'])->withCasts(
            [
                'day' => 'datetime',
            ]
        )->get()->pluck('day');
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

    /**
     * Say database records does not repeat and full work day is 8 hours of work (8:00-17:00 with lunch at 12-00-13:00).
     */
    private function subBusyDays(Collection $dates, Collection $existingAppointments): Collection
    {
        $except = $existingAppointments->map(fn (Carbon $dateTime) => $dateTime->format('d-m-Y H:i'))->values();

        return $dates->filter(
            fn (string $date) => $except->where(fn (string $exDate) => str_starts_with($exDate, $date))->count() < 8
        );
    }

    private function prepareResult(Collection $dates): Collection
    {
        return $dates->values();
    }
}
