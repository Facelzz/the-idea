<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    private string $tableName = 'appointments';

    public function up(): void
    {
        Schema::create($this->tableName, function (Blueprint $table): void {
            $table->id();

            $table->foreignId('specialist_id')->constrained()->cascadeOnDelete();
            $table->timestamp('time');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists($this->tableName);
    }
};
