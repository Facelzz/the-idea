<?php

namespace Database\Seeders;

use App\Models\Specialist;
use Illuminate\Database\Seeder;

class SpecialistSeeder extends Seeder
{
    public function run(): void
    {
        Specialist::factory(100)->create();
    }
}
