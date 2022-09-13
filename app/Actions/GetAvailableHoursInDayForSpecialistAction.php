<?php

declare(strict_types=1);

namespace App\Actions;

use App\Exceptions\SpecialistNotFoundException;
use App\Models\Specialist;
use DateInterval;
use DatePeriod;
use Illuminate\Support\{Carbon, Collection};

class GetAvailableHoursInDayForSpecialistAction
{
    public function execute(int $specialistId, Carbon $day): Collection
    {
        $specialist = Specialist::find($specialistId) ?? throw new SpecialistNotFoundException();
        $appointments = $this->getAppointmentsForDay($specialist, $day);
        $hours = $this->collectHoursFromDay($day);
        $freeHours = $this->subBusyHours($hours, $appointments);

        return $this->prepareResult($freeHours);
    }

    private function getAppointmentsForDay(Specialist $specialist, Carbon $day): Collection
    {
        return $specialist->appointments()->whereDate('time', $day->toDateString())->get()->pluck('time');
    }

    private function collectHoursFromDay(Carbon $day): Collection
    {
        return collect(new DatePeriod(
            start: (clone $day)->setTime(8, 0),
            interval: new DateInterval('PT1H'),
            end: (clone $day)->setTime(16, 0),
            options: 2
        ))->values();
    }

    /**
     * Say database records does not repeat and full work day is 8 hours of work (8:00-17:00 with lunch at 12-00-13:00).
     */
    private function subBusyHours(Collection $dates, Collection $existingAppointments): Collection
    {
        $except = $existingAppointments->values();

        return $dates->filter(
            fn (Carbon $date) => $except->where(fn (string $exDate) => $date->isSameHour($exDate))->count() === 0
        );
    }

    private function prepareResult(Collection $freeHours): Collection
    {
        return $freeHours->map(fn (Carbon $hour) => $hour->format('H:i'));
    }
}
