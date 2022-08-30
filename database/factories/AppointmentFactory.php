<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Specialist;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    public function definition(): array
    {
        return [
            'specialist_id' => Specialist::factory(),
            'time' => $this->faker->unique()->dateTime(),
        ];
    }
}
