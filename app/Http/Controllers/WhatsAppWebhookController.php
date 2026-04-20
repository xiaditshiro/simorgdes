<?php

namespace App\Http\Controllers;

use App\Services\ChatbotService;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WhatsAppWebhookController extends Controller
{
    protected ChatbotService $chatbot;
    protected WhatsAppService $whatsapp;

    public function __construct(ChatbotService $chatbot, WhatsAppService $whatsapp)
    {
        $this->chatbot = $chatbot;
        $this->whatsapp = $whatsapp;
    }

    /**
     * Handle incoming webhook from Fonnte
     */
    public function handle(Request $request)
    {
        // 1. Log every hit to debug (Crucial for connectivity debugging)
        Log::info('--- WHATSAPP WEBHOOK HIT ---');
        Log::info('IP Address: ' . $request->ip());
        Log::info('Headers: ', $request->headers->all());
        Log::info('Raw Payload: ', $request->all());

        $sender = $request->input('sender'); // Phone number of sender
        $message = $request->input('message'); // Message content

        if (!$sender || !$message) {
            Log::warning('WhatsApp Webhook: Invalid or empty payload', ['sender' => $sender, 'message' => $message]);
            return response()->json(['status' => 'error', 'message' => 'Invalid payload'], 400);
        }


        // Check if Chatbot is enabled in settings
        $isChatbotActive = \App\Models\Setting::get('chatbot_active', 'true') === 'true';

        if (!$isChatbotActive) {
            $standbyMessage = \App\Models\Setting::get('chatbot_standby_message', 'Maaf, asisten AI sedang dalam mode istirahat.');
            
            // Log the skipped interaction
            \App\Models\WebhookLog::create([
                'sender' => $sender,
                'message' => $message,
                'response' => $standbyMessage,
                'status' => 'skipped'
            ]);

            $this->whatsapp->sendMessage($sender, $standbyMessage);
            return response()->json(['status' => 'skipped', 'message' => 'Chatbot is disabled']);
        }

        try {
            // Get AI Response
            $aiResponse = $this->chatbot->getResponse($sender, $message);

            // Log the successful interaction
            \App\Models\WebhookLog::create([
                'sender' => $sender,
                'message' => $message,
                'response' => $aiResponse,
                'status' => 'success'
            ]);

            // Send back to WhatsApp
            $this->whatsapp->sendMessage($sender, $aiResponse);
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            Log::error("Webhook AI Error: " . $e->getMessage());

            // Log the failed interaction
            \App\Models\WebhookLog::create([
                'sender' => $sender,
                'message' => $message,
                'response' => 'Error: ' . $e->getMessage(),
                'status' => 'failed'
            ]);

            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
