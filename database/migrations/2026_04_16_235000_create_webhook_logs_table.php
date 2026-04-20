<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('webhook_logs', function (Blueprint $table) {
            $table->id();
            $table->string('sender');
            $table->text('message');
            $table->text('response')->nullable();
            $table->enum('status', ['success', 'failed', 'skipped'])->default('success');
            $table->timestamps();
        });

        // Seed additional settings
        DB::table('settings')->insert([
            [
                'key' => 'maintenance_mode',
                'value' => 'false',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'chatbot_standby_message',
                'value' => 'Maaf, asisten AI sedang dalam mode istirahat. Silakan hubungi pengurus organisasi secara langsung. Terima kasih 🙏',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('webhook_logs');
        DB::table('settings')->whereIn('key', ['maintenance_mode', 'chatbot_standby_message'])->delete();
    }
};
