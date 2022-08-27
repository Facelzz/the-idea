<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\SpecialistStatus;
use App\Models\Specialist;
use Tests\TestCase;

class ListSpecialistsTest extends TestCase
{
    private string $route = 'api.specialists.index';

    public function testMethodExists(): void
    {
        $response = $this->optionsJson(route($this->route));
        self::assertStringContainsString('GET', $response->headers->get('Allow'));
    }

    public function testPagination(): void
    {
        // non-integer
        $response = $this->getJson(route($this->route, [
            'page' => 'string',
            'perPage' => 'string',
        ]));
        $response->assertJsonValidationErrors(['page', 'perPage']);

        // min 1
        $response = $this->getJson(route($this->route, [
            'page' => 0,
            'perPage' => 0,
        ]));
        $response->assertJsonValidationErrors(['page', 'perPage']);

        // default perPage is 20
        $this->seedSpecialists(30);
        $response = $this->getJson(route($this->route));
        $response->assertJsonMissingValidationErrors(['page', 'perPage']);
        $response->assertJsonCount(20);
    }

    public function testSuccessResponse(): void
    {
        $this->seedSpecialists(10);
        $this->seedSpecialists(5, SpecialistStatus::Draft);

        $response = $this->getJson(route($this->route));
        $response->assertOk();
        $response->assertJsonCount(10); // only active
        $response->assertJsonStructure([
            '*' => [
                'id',
                'name',
                'speciality',
            ],
        ]);
    }

    private function seedSpecialists($amount, SpecialistStatus $status = SpecialistStatus::Active): void
    {
        Specialist::factory($amount)->create([
            'status' => $status,
        ]);
    }
}
