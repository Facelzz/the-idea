<?php

namespace Database\Factories;

use App\Enums\SpecialistStatus;
use App\Models\Specialist;
use App\Models\Speciality;
use Illuminate\Database\Eloquent\Factories\Factory;

class SpecialistFactory extends Factory
{
    protected $model = Specialist::class;

    public function definition(): array
    {
        return [
            'status' => $this->faker->randomElement(SpecialistStatus::cases()),
            'name' => $this->faker->name(),
            'speciality_id' => Speciality::factory(),
        ];
    }
}
