<?php

use App\Enums\SpecialityStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    private string $tableName = 'specialities';

    public function up(): void
    {
        Schema::table($this->tableName, function (Blueprint $table): void {
            $table->string('status')->default(SpecialityStatus::Draft->value)->after('id');
        });
    }

    public function down(): void
    {
        Schema::table($this->tableName, function (Blueprint $table): void {
            $table->dropColumn('status');
        });
    }
};
