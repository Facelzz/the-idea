<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\SpecialistStatus;
use App\Models\Appointment;
use App\Models\Specialist;
use Tests\TestCase;

class GetAvailableDaysForSpecialistTest extends TestCase
{
    private string $route = 'api.specialists.days.index';

    public function testMethodExists(): void
    {
        $response = $this->optionsJson(route($this->route, ['specialist' => 0]));
        self::assertStringContainsString('GET', $response->headers->get('Allow'));
    }

    public function testValidation(): void
    {
        // non-integer
        $response = $this->getJson(route($this->route, ['specialist' => 'string']));
        $response->assertJsonValidationErrors('specialist');

        // min 1
        $response = $this->getJson(route($this->route, ['specialist' => 0]));
        $response->assertJsonValidationErrors('specialist');

        // non-existent
        $response = $this->getJson(route($this->route, ['specialist' => 100]));
        $response->assertNotFound();
        $response->assertExactJson([
            'error' => 'specialist:notFound',
            'message' => 'Specialist with a given ID not found',
        ]);

        // non-date string for dueTo
        $specialist = Specialist::factory()->create();
        $response = $this->getJson(route($this->route, [
            'specialist' => $specialist->id,
            'dueTo' => 'non-date',
        ]));
        $response->assertJsonValidationErrors('dueTo');

        // dueTo only after today
        $response = $this->getJson(route($this->route, [
            'specialist' => $specialist->id,
            'dueTo' => now()->format('d-m-Y'),
        ]));
        $response->assertJsonValidationErrors('dueTo');
    }

    public function testSuccessResponse(): void
    {
        $this->travelTo(now()->startOfMonth());
        $specialist = Specialist::factory()->create(['status' => SpecialistStatus::Active]);
        Appointment::factory()->create([
            'specialist_id' => $specialist->id,
            'time' => now(),
        ]);
        $response = $this->getJson(route($this->route, ['specialist' => $specialist->id]));
        $response->assertOk();
        $this->assertGreaterThan(1, count($response->json()));
        foreach ($response->json() as $item) {
            $this->assertMatchesRegularExpression('/^\d{2}-\d{2}-\d{4}$/', $item);
        }
        $response->assertDontSee(now()->format('d-m-Y'));
    }
}
