<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\WebhookLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SystemSettingController extends Controller
{
    public function advanceIndex()
    {
        $chatbotActive = Setting::get('chatbot_active', 'true') === 'true';
        $receiptEnabled = Setting::get('wa_receipt_enabled', 'true') === 'true';
        $maintenanceMode = Setting::get('maintenance_mode', 'false') === 'true';
        $standbyMessage = Setting::get('chatbot_standby_message', 'Maaf, asisten AI sedang dalam mode istirahat.');

        // Get recent webhook logs
        $webhookLogs = WebhookLog::latest()->take(10)->get();

        return view('admin.settings.advance', compact(
            'chatbotActive',
            'receiptEnabled',
            'maintenanceMode',
            'standbyMessage',
            'webhookLogs'
        ));
    }

    public function updateChatbot(Request $request)
    {
        $active = $request->has('chatbot_active') ? 'true' : 'false';
        Setting::set('chatbot_active', $active);

        $status = $active === 'true' ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Chatbot AI berhasil {$status}.");
    }

    public function updateReceipt(Request $request)
    {
        $active = $request->has('wa_receipt_enabled') ? 'true' : 'false';
        Setting::set('wa_receipt_enabled', $active);

        $status = $active === 'true' ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Notifikasi Resi WA berhasil {$status}.");
    }

    public function updateMaintenance(Request $request)
    {
        $active = $request->has('maintenance_mode') ? 'true' : 'false';
        Setting::set('maintenance_mode', $active);

        $status = $active === 'true' ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Mode Perawatan berhasil {$status}.");
    }

    public function updateStandbyMessage(Request $request)
    {
        $request->validate([
            'chatbot_standby_message' => 'required|string|max:500',
        ]);

        Setting::set('chatbot_standby_message', $request->chatbot_standby_message);

        return back()->with('success', 'Pesan standby berhasil diperbarui.');
    }

    public function checkWhatsApp()
    {
        try {
            $token = config('services.fonnte.token') ?? env('FONNTE_TOKEN');

            if (!$token) {
                return back()->with('wa_status', [
                    'ok' => false,
                    'message' => 'Token Fonnte belum dikonfigurasi di file .env',
                ]);
            }

            $response = Http::withHeaders([
                'Authorization' => $token,
            ])->post('https://api.fonnte.com/device');

            if ($response->successful()) {
                $data = $response->json();
                $deviceStatus = $data['status'] ?? false;
                $deviceName = $data['device'] ?? 'Unknown';

                return back()->with('wa_status', [
                    'ok' => $deviceStatus,
                    'message' => $deviceStatus
                        ? "Perangkat \"{$deviceName}\" terhubung dan siap digunakan ✅"
                        : "Perangkat ditemukan tetapi tidak aktif. Pastikan WhatsApp Anda terhubung di Fonnte.",
                ]);
            }

            return back()->with('wa_status', [
                'ok' => false,
                'message' => 'Gagal terhubung ke API Fonnte. Response: ' . $response->status(),
            ]);
        } catch (\Exception $e) {
            return back()->with('wa_status', [
                'ok' => false,
                'message' => 'Error koneksi: ' . $e->getMessage(),
            ]);
        }
    }

    public function clearWebhookLogs()
    {
        WebhookLog::truncate();
        return back()->with('success', 'Semua log webhook berhasil dihapus.');
    }
}
