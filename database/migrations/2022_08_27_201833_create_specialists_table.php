<?php

use App\Enums\SpecialistStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    private string $tableName = 'specialists';

    public function up(): void
    {
        Schema::create($this->tableName, function (Blueprint $table): void {
            $table->id();

            $table->string('status')->default(SpecialistStatus::Draft->value);
            $table->string('name');
            $table->foreignId('speciality_id')->nullable()->default(null)->constrained();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists($this->tableName);
    }
};
