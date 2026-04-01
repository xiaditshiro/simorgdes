<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cash_schedules', function (Blueprint $table) {
            $table->id();

            $table->foreignId('cash_group_id')
                ->constrained('cash_groups')
                ->cascadeOnDelete();

            $table->date('due_date');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cash_schedules');
    }
};