<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('activity_attendances', function (Blueprint $table) {
            $table->timestamp('checked_in_at')->nullable()->after('status');
            $table->string('attendance_method')->default('manual')->after('checked_in_at');
        });
    }

    public function down(): void
    {
        Schema::table('activity_attendances', function (Blueprint $table) {
            $table->dropColumn(['checked_in_at', 'attendance_method']);
        });
    }
};