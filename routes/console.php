<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Auto-cleanup: hapus webhook logs yang lebih dari 30 hari
Schedule::call(function () {
    \App\Models\WebhookLog::where('created_at', '<', now()->subDays(30))->delete();
})->daily()->description('Cleanup webhook logs older than 30 days');
