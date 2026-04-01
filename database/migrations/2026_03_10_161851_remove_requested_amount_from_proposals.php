<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Jalankan perubahan database
     */
    public function up(): void
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->dropColumn('requested_amount');
        });
    }

    /**
     * Rollback migration
     */
    public function down(): void
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->decimal('requested_amount', 12, 2)->nullable();
        });
    }
};