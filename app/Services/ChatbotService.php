<?php

namespace App\Services;

use App\Models\Organization;
use App\Models\OrganizationMember;
use App\Models\Activity;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotService
{
    protected string $apiKey;
    protected string $baseUrl = 'https://api.groq.com/openai/v1/chat/completions';
    protected string $model = 'llama-3.3-70b-versatile';

    public function __construct()
    {
        $this->apiKey = config('services.groq.api_key') ?? env('GROQ_API_KEY', '');
    }

    /**
     * Process incoming message and return AI response
     */
    public function getResponse(string $phone, string $message): string
    {
        if (empty($this->apiKey)) {
            Log::error("ChatbotService Error: GROQ_API_KEY is empty.");
            return "Maaf, sistem AI belum dikonfigurasi. Silakan hubungi admin.";
        }

        // 1. Identify User
        $normalizedPhone = $this->normalizePhone($phone);
        
        // Search more aggressively: check for matching suffix (last 10 digits) 
        // to handle variations in country code prefixes (e.g. 62, +62, 0, etc)
        $phoneSuffix = substr($normalizedPhone, -10);
        
        $member = OrganizationMember::with(['organization', 'cashPayments.schedule.group'])
            ->where('phone', 'like', "%{$phoneSuffix}")
            ->first();

        // 2. Build Context
        $context = $this->buildContext($member);
        $context['current_time'] = now()->timezone('Asia/Makassar')->format('H:i:s');

        // 3. Call AI (Groq / OpenAI Format)
        try {
            $response = Http::withToken($this->apiKey)
                ->timeout(30)
                ->post($this->baseUrl, [
                    'model' => $this->model,
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => $this->getSystemPrompt($member) . "\n\nKonteks Data Sistem: " . json_encode($context)
                        ],
                        [
                            'role' => 'user',
                            'content' => $message
                        ]
                    ],
                    'temperature' => 0.7,
                    'max_tokens' => 1024,
                ]);

            if ($response->successful()) {
                $result = $response->json();
                return $result['choices'][0]['message']['content'] ?? "Maaf, saya tidak bisa memproses permintaan Anda saat ini.";
            }

            Log::error("Groq API Error (" . $response->status() . "): " . $response->body());
            return "Maaf, terjadi gangguan pada otak AI saya (Groq). Status: " . $response->status();
        } catch (\Exception $e) {
            Log::error("ChatbotService Exception: " . $e->getMessage());
            return "Maaf, terjadi kesalahan teknis pada sistem chatbot.";
        }
    }

    private function normalizePhone(string $phone): string
    {
        // Remove all non-numeric characters
        $clean = preg_replace('/[^0-9]/', '', $phone);
        
        // standard format: 08xxx
        if (str_starts_with($clean, '62')) {
            return '0' . substr($clean, 2);
        }
        
        if (!str_starts_with($clean, '0') && strlen($clean) >= 9) {
            return '0' . $clean;
        }

        return $clean;
    }


    private function buildContext(?OrganizationMember $member): array
    {
        $context = [
            'system_name' => 'SimOrgDes (Sistem Manajemen Organisasi Desa)',
            'current_date' => now()->timezone('Asia/Makassar')->toDateString(),
        ];

        if ($member) {
            $context['user'] = [
                'name' => $member->full_name,
                'organization' => $member->organization->name ?? 'Tidak diketahui',
                'position' => $member->position,
                'status' => $member->status,
                'last_cash_payments' => $member->cashPayments->take(5)->map(fn($p) => [
                    'title' => $p->schedule->group->title ?? '-',
                    'due_date' => $p->schedule->due_date->toDateString(),
                    'status' => $p->status,
                    'amount' => $p->schedule->group->amount ?? 0
                ])
            ];
            
            // Get organization specific info
            if ($member->organization) {
                $org = $member->organization;
                $context['organization_info'] = [
                    'name' => $org->name,
                    'leader' => $org->leader_name,
                    'secretary' => $org->secretary_name,
                    'treasurer' => $org->treasurer_name,
                    'address' => $org->address,
                    'upcoming_activities' => Activity::where('organization_id', $org->id)
                        ->where('activity_date', '>=', now()->timezone('Asia/Makassar')->toDateString())
                        ->orderBy('activity_date', 'asc')
                        ->take(5)
                        ->get(['title', 'activity_date', 'location', 'description'])
                ];
            }
        } else {
            // General system info for anonymous/unregistered users
            $context['guest_info'] = "User ini belum terdaftar di sistem SimOrgDes atau nomor HP tidak terdata di database.";
            $context['available_organizations'] = Organization::take(5)->pluck('name')->toArray();
        }

        return $context;
    }

    private function getSystemPrompt(?OrganizationMember $member): string
    {
        $now = now()->timezone('Asia/Makassar');
        $currentTime = $now->format('H:i');
        $hour = (int)$now->format('H');
        $greeting = 'Selamat Malam';
        if ($hour >= 5 && $hour < 11) $greeting = 'Selamat Pagi';
        elseif ($hour >= 11 && $hour < 15) $greeting = 'Selamat Siang';
        elseif ($hour >= 15 && $hour < 19) $greeting = 'Selamat Sore';

        $prompt = "Anda adalah Shiro Bot, Asisten AI Virtual untuk sistem SimOrgDes (Sistem Manajemen Organisasi Desa). ";
        $prompt .= "Jam sekarang menunjukkan pukul {$currentTime}, jadi sapalah dengan '{$greeting}'. ";
        $prompt .= "Tugas Anda adalah memandu pengguna menggunakan aplikasi SimOrgDes. ";
        $prompt .= "Kapasitas Anda adalah menjawab pertanyaan berdasarkan data sistem dan memberikan panduan menu aplikasi. ";
        $prompt .= "Gunakan Bahasa Indonesia yang ramah, sopan, singkat, dan gunakan emoji. \n\n";

        $prompt .= "PANDUAN NAVIGASI APLIKASI:\n";
        $prompt .= "1. Untuk membuat jadwal kas: Masuk ke menu 'Kas Anggota' > 'Buat Jadwal'. (Hanya Sekretaris/Admin)\n";
        $prompt .= "2. Untuk mencatat pembayaran: Masuk ke menu 'Kas Anggota' > klik detail jadwal > klik 'Lunas'. (Hanya Bendahara/Admin)\n";
        $prompt .= "3. Untuk membuat agenda kegiatan: Masuk ke menu 'Kegiatan'. (Hanya Sekretaris/Admin)\n";
        $prompt .= "4. Untuk melihat saldo pribadi: Masuk ke menu 'Kas Saya'.\n";
        $prompt .= "5. Untuk membuat proposal: Masuk ke menu 'Proposal' > 'Buat Proposal'.\n\n";

        if ($member) {
            $prompt .= "Informasi User:\n";
            $prompt .= "- Nama: {$member->full_name}\n";
            $prompt .= "- Jabatan: {$member->position}\n";
            $prompt .= "- Organisasi: {$member->organization->name}.\n\n";
            
            if (in_array($member->position, ['sekretaris', 'ketua'])) {
                $prompt .= "User ini memiliki wewenang mengelola jadwal dan kegiatan. Jika dia bertanya cara membuat jadwal, arahkan ke menu yang benar, jangan disuruh tanya orang lain. ";
            }
        } else {
            $prompt .= "User belum terdaftar. Arahkan mereka untuk menghubungi pengurus organisasi agar didaftarkan nomor HP-nya ke sistem.";
        }
        
        return $prompt;
    }
}
