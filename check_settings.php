<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Setting;

echo "Chatbot Active: " . (Setting::get('chatbot_active') ?: 'NULL') . "\n";
echo "AI Model: " . (Setting::get('ai_model') ?: 'NULL') . "\n";
echo "Receipt Enabled: " . (Setting::get('wa_receipt_enabled') ?: 'NULL') . "\n";
echo "GROQ Key set: " . (config('services.groq.api_key') ? 'Yes' : 'No') . "\n";
