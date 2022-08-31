<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\SpecialistStatus;
use App\Models\Appointment;
use App\Models\Specialist;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class GetAvailableHoursInSpecialistDayTest extends TestCase
{
    private string $route = 'api.specialists.days.hours.index';

    public function testMethodExists(): void
    {
        $response = $this->optionsJson(route($this->route, ['specialist' => 0, 'day' => now()->addDays(2)->format('d-m-Y')]));
        self::assertStringContainsString('GET', $response->headers->get('Allow'));
    }

    public function testValidation(): void
    {
        // non-integer
        $response = $this->getJson(route($this->route, ['specialist' => 'string', 'day' => now()->addDays(2)->format('d-m-Y')]));
        $response->assertJsonValidationErrors('specialist');

        // min 1
        $response = $this->getJson(route($this->route, ['specialist' => 0, 'day' => now()->addDays(2)->format('d-m-Y')]));
        $response->assertJsonValidationErrors('specialist');

        // non-existent
        $response = $this->getJson(route($this->route, ['specialist' => 100, 'day' => now()->addDays(2)->format('d-m-Y')]));
        $response->assertNotFound();
        $response->assertExactJson([
            'error' => 'specialist:notFound',
            'message' => 'Specialist with a given ID not found',
        ]);

        // non-date for day
        $specialist = Specialist::factory()->create(['status' => SpecialistStatus::Active]);
        $response = $this->getJson(route($this->route, ['specialist' => $specialist->id, 'day' => 'non-date']));
        $response->assertJsonValidationErrors('day');

        // non-date for day
        $specialist = Specialist::factory()->create(['status' => SpecialistStatus::Active]);
        $day = now()->addDays(2)->format('d-m-Y');
        foreach (range(8, 16) as $hour) {
            Appointment::factory()->create([
                'specialist_id' => $specialist->id,
                'time' => Carbon::parse("{$day} {$hour}:00"),
            ]);
        }
        $response = $this->getJson(route($this->route, ['specialist' => $specialist->id, 'day' => $day]));
        $response->assertNotFound();
        $response->assertExactJson([
            'error' => 'specialist:dayIsBusy',
            'message' => 'Specialist has no free hours on this day',
        ]);
    }
}
