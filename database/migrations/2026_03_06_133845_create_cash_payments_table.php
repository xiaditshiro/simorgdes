<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cash_payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('cash_schedule_id')
                ->constrained('cash_schedules')
                ->cascadeOnDelete();

            $table->foreignId('member_id')
                ->constrained('organization_members')
                ->cascadeOnDelete();

            $table->enum('status', ['paid', 'unpaid'])->default('unpaid');
            $table->timestamp('paid_at')->nullable();

            $table->timestamps();

            $table->unique(['cash_schedule_id', 'member_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cash_payments');
    }
};