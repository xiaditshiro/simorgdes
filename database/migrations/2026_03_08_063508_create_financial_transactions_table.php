<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('financial_transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('organization_id')
                ->constrained('organizations')
                ->cascadeOnDelete();

            $table->date('transaction_date');

            $table->enum('type', ['income', 'expense']);
            $table->enum('source', ['manual', 'cash_payment'])->default('manual');

            $table->string('category')->nullable();
            $table->text('description')->nullable();

            $table->decimal('amount', 15, 2);

            $table->foreignId('cash_payment_id')
                ->nullable()
                ->constrained('cash_payments')
                ->nullOnDelete();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('financial_transactions');
    }
};