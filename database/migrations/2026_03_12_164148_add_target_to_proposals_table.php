<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::table('proposals', function (Blueprint $table) {

            $table->string('target_type')->after('organization_id');
            $table->foreignId('target_organization_id')->nullable()->constrained('organizations')->nullOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('proposals', function (Blueprint $table) {

            $table->dropColumn('target_type');
            $table->dropForeign(['target_organization_id']);
            $table->dropColumn('target_organization_id');

        });
    }

};
