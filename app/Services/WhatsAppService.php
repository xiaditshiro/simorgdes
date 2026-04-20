<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected string $token;
    protected string $baseUrl = 'https://api.fonnte.com';

    public function __construct()
    {
        $this->token = config('services.fonnte.token') ?? env('FONNTE_TOKEN', '');
    }

    /**
     * Send a single message
     */
    public function sendMessage(string $to, string $message): bool
    {
        if (empty($this->token)) {
            Log::error('WhatsAppService: FONNTE_TOKEN is not set.');
            return false;
        }

        $formattedPhone = $this->formatPhone($to);

        try {
            $response = Http::withHeaders([
                'Authorization' => $this->token,
            ])->post("{$this->baseUrl}/send", [
                'target' => $formattedPhone,
                'message' => $message,
                // 'countryCode' => '62', // We handle normalization ourselves now
            ]);

            if ($response->successful()) {
                Log::info("WhatsApp message sent to {$formattedPhone}");
                return true;
            }

            Log::error("WhatsApp message failed to {$formattedPhone}: " . $response->body());
            return false;
        } catch (\Exception $e) {
            Log::error("WhatsAppService Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Smart phone number normalization
     */
    protected function formatPhone(string $phone): string
    {
        // Remove non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // If starts with 08..., replace 0 with 62
        if (str_starts_with($phone, '08')) {
            $phone = '62' . substr($phone, 1);
        }

        // If starts with 8..., prepend 62
        if (str_starts_with($phone, '8')) {
            $phone = '62' . $phone;
        }

        return $phone;
    }

    /**
     * Send mass messages
     */
    public function sendMassMessage(array $targets, string $message): bool
    {
        if (empty($this->token)) {
            Log::error('WhatsAppService: FONNTE_TOKEN is not set.');
            return false;
        }

        // Normalize each target phone number
        $formattedTargets = array_map(function($target) {
            return $this->formatPhone($target);
        }, $targets);

        $targetString = implode(',', $formattedTargets);

        try {
            $response = Http::withHeaders([
                'Authorization' => $this->token,
            ])->post("{$this->baseUrl}/send", [
                'target' => $targetString,
                'message' => $message,
                // 'countryCode' => '62',
            ]);


            return $response->successful();
        } catch (\Exception $e) {
            Log::error("WhatsAppService Mass Error: " . $e->getMessage());
            return false;
        }
    }
}
