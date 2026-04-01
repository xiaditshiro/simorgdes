<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();

            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();

            $table->string('title');
            $table->date('activity_date');
            $table->string('location')->nullable();
            $table->text('description')->nullable();

            $table->enum('status', ['draft', 'scheduled', 'completed', 'cancelled'])
                ->default('draft');

            $table->timestamps();
        });
    }
};
