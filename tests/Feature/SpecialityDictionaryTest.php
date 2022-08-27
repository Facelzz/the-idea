<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\SpecialityStatus;
use App\Models\Speciality;
use Tests\TestCase;

class SpecialityDictionaryTest extends TestCase
{
    private string $route = 'api.specialities.index';

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
        $this->seedSpecialities(30);
        $response = $this->getJson(route($this->route));
        $response->assertJsonMissingValidationErrors(['page', 'perPage']);
        $response->assertJsonCount(20);
    }

    public function testSuccessResponse(): void
    {
        $this->seedSpecialities(10);
        $this->seedSpecialities(5, SpecialityStatus::Draft);

        $response = $this->getJson(route($this->route));
        $response->assertOk();
        $response->assertJsonCount(10); // only active
        $response->assertJsonStructure([
            '*' => [
                'id',
                'name',
            ],
        ]);
    }

    private function seedSpecialities($amount, SpecialityStatus $status = SpecialityStatus::Active): void
    {
        Speciality::factory($amount)->create([
            'status' => $status,
        ]);
    }
}
