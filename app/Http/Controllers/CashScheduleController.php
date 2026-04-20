<?php

namespace App\Http\Controllers;

use App\Models\CashGroup;
use App\Models\CashPayment;
use App\Models\CashSchedule;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\WhatsAppService;


class CashScheduleController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $query = CashGroup::with(['organization', 'schedules'])->latest();

        if (!$user->hasRole('super_admin') && !$user->hasRole('admin_desa')) {
            $query->where('organization_id', $user->organization_id);
        }

        $groups = $query->get();

        return view('cash.index', compact('groups'));
    }

    public function create()
    {
        $organizations = Organization::orderBy('name')->get();

        return view('cash.create', compact('organizations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'title' => 'required|string|max:255',
            'amount' => 'required|integer|min:1',
            'dates' => 'required|array|min:1',
            'dates.*' => 'required|date',
            'description' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated) {
            $organization = Organization::findOrFail($validated['organization_id']);

            $cashGroup = CashGroup::create([
                'organization_id' => $organization->id,
                'title' => $validated['title'],
                'amount' => $validated['amount'],
                'description' => $validated['description'] ?? null,
            ]);

            $members = $organization->members;

            foreach ($validated['dates'] as $date) {
                $schedule = CashSchedule::create([
                    'cash_group_id' => $cashGroup->id,
                    'due_date' => $date,
                ]);

                foreach ($members as $member) {
                    CashPayment::create([
                        'cash_schedule_id' => $schedule->id,
                        'member_id' => $member->id,
                        'status' => 'unpaid',
                    ]);
                }
            }
        });

        // WhatsApp Notification
        try {
            $organization = Organization::find($validated['organization_id']);
            $members = $organization->members()->whereNotNull('phone')->get();
            $phones = $members->pluck('phone')->filter()->toArray();

            if (!empty($phones)) {
                $waService = app(WhatsAppService::class);
                $message = "📢 *Jadwal Kas Baru*\n\n" .
                    "Organisasi: {$organization->name}\n" .
                    "Judul: {$validated['title']}\n" .
                    "Nominal: Rp " . number_format($validated['amount'], 0, ',', '.') . "\n\n" .
                    "Silakan cek detailnya di aplikasi. Terima kasih.";
                
                $waService->sendMassMessage($phones, $message);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Failed to send WA notification: " . $e->getMessage());
        }

        return redirect()
            ->route('cash.index')
            ->with('success', 'Jadwal kas berhasil dibuat.');
    }

    public function show(CashGroup $cash)
    {
        $cash->load([
            'organization',
            'schedules' => function ($query) {
                $query->orderBy('due_date');
            },
            'schedules.payments.member',
        ]);

        $members = $cash->organization->members()
            ->orderBy('full_name')
            ->get();

        $paymentMap = [];
        $memberTotals = [];
        $scheduleTotals = [];
        $paidPaymentIds = [];

        foreach ($cash->schedules as $schedule) {
            $scheduleTotals[$schedule->id] = 0;

            foreach ($schedule->payments as $payment) {
                $paymentMap[$payment->member_id][$schedule->id] = $payment;

                if ($payment->status === 'paid') {
                    $memberTotals[$payment->member_id] = ($memberTotals[$payment->member_id] ?? 0) + 1;
                    $scheduleTotals[$schedule->id]++;
                    $paidPaymentIds[] = $payment->id;
                }
            }
        }

        $totalPaidCount = array_sum($scheduleTotals);
        $totalCashIn = \App\Models\FinancialTransaction::whereIn('cash_payment_id', $paidPaymentIds)->sum('amount');

        return view('cash.show', compact(
            'cash',
            'members',
            'paymentMap',
            'memberTotals',
            'scheduleTotals',
            'totalPaidCount',
            'totalCashIn'
        ));
    }

    public function edit(CashGroup $cash)
    {
        $cash->load([
            'schedules' => function ($query) {
                $query->orderBy('due_date');
            }
        ]);

        $organizations = Organization::orderBy('name')->get();

        return view('cash.edit', compact('cash', 'organizations'));
    }

    public function update(Request $request, CashGroup $cash)
    {
        $validated = $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'title' => 'required|string|max:255',
            'amount' => 'required|integer|min:1',
            'dates' => 'required|array|min:1',
            'dates.*' => 'required|date',
            'description' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated, $cash) {
            $cash->update([
                'organization_id' => $validated['organization_id'],
                'title' => $validated['title'],
                'amount' => $validated['amount'],
                'description' => $validated['description'] ?? null,
            ]);

            // Get existing schedules
            $existingSchedules = $cash->schedules()->get();
            $existingDates = $existingSchedules->pluck('due_date')->map(fn($d) => $d->format('Y-m-d'))->toArray();
            $newDates = $validated['dates'];

            // 1. Find dates to ADD
            $datesToAdd = array_diff($newDates, $existingDates);
            
            // 2. Find dates to REMOVE
            $datesToRemove = array_diff($existingDates, $newDates);

            $organization = Organization::findOrFail($validated['organization_id']);
            $members = $organization->members;

            // Handle Additions
            foreach ($datesToAdd as $date) {
                $schedule = \App\Models\CashSchedule::create([
                    'cash_group_id' => $cash->id,
                    'due_date' => $date,
                ]);

                foreach ($members as $member) {
                    \App\Models\CashPayment::create([
                        'cash_schedule_id' => $schedule->id,
                        'member_id' => $member->id,
                        'status' => 'unpaid',
                    ]);
                }
            }

            // Handle Removals (Safety check: only remove if NO payments are 'paid')
            foreach ($datesToRemove as $dateStr) {
                $schedule = $existingSchedules->first(fn($s) => $s->due_date->format('Y-m-d') === $dateStr);
                
                if ($schedule) {
                    $hasPaidPayments = $schedule->payments()->where('status', 'paid')->exists();
                    
                    if (!$hasPaidPayments) {
                        // Safe to delete along with unpaid payments
                        $schedule->payments()->delete();
                        $schedule->delete();
                    } else {
                        // Warning: We skip deletion because someone already paid for this date
                        \Illuminate\Support\Facades\Log::warning("Skipped deleting cash schedule for date {$dateStr} because it has paid payments.");
                    }
                }
            }
        });

        return redirect()
            ->route('cash.index')
            ->with('success', 'Jadwal kas berhasil diperbarui.');
    }

    public function destroy(CashGroup $cash)
    {
        DB::transaction(function () use ($cash) {
            $scheduleIds = $cash->schedules()->pluck('id');

            $paymentIds = CashPayment::whereIn('cash_schedule_id', $scheduleIds)->pluck('id');

            \App\Models\FinancialTransaction::whereIn('cash_payment_id', $paymentIds)->delete();

            CashPayment::whereIn('cash_schedule_id', $scheduleIds)->delete();
            CashSchedule::whereIn('id', $scheduleIds)->delete();

            $cash->delete();
        });

        return redirect()
            ->route('cash.index')
            ->with('success', 'Semua jadwal kas berhasil dihapus.');
    }

    public function markPaid(CashPayment $payment)
    {
        $payment->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        $payment->load(['member', 'schedule.group']);

        \App\Models\FinancialTransaction::firstOrCreate(
            [
                'cash_payment_id' => $payment->id,
            ],
            [
                'organization_id' => $payment->schedule->group->organization_id,
                'transaction_date' => now(),
                'type' => 'income',
                'source' => 'cash_payment',
                'category' => 'Kas Anggota',
                'description' => 'Pembayaran kas anggota',
                'amount' => $payment->schedule->group->amount,
                'created_by' => auth()->id(),
            ]
        );

        // Send WhatsApp Receipt
        try {
            $chatbotActive = \App\Models\Setting::get('chatbot_active', 'true') === 'true';
            $receiptEnabled = \App\Models\Setting::get('wa_receipt_enabled', 'true') === 'true';

            if ($chatbotActive && $receiptEnabled && $payment->member && $payment->member->phone) {
                $waService = app(WhatsAppService::class);
                $message = "✅ *Pembayaran Kas Berhasil*\n\n" .
                    "Halo *{$payment->member->full_name}*,\n" .
                    "Pembayaran kas Anda untuk:\n" .
                    "Jadwal: *{$payment->schedule->group->title}*\n" .
                    "Nominal: *Rp " . number_format($payment->schedule->group->amount, 0, ',', '.') . "*\n" .
                    "Telah diterima oleh Bendahara pada " . now()->format('d-m-Y H:i') . ".\n\n" .
                    "Terima kasih atas partisipasinya! 🙏";
                
                $waService->sendMessage($payment->member->phone, $message);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Failed to send Payment WA notification: " . $e->getMessage());
        }

        return back()->with('success', 'Pembayaran ditandai lunas.');
    }

    public function markUnpaid(CashPayment $payment)
    {
        \App\Models\FinancialTransaction::where('cash_payment_id', $payment->id)->delete();

        $payment->update([
            'status' => 'unpaid',
            'paid_at' => null,
        ]);

        return back()->with('success', 'Status pembayaran diubah menjadi belum bayar.');
    }



    public function myCash()
    {
        $user = auth()->user();
        $member = $user->organizationMember;

        if (!$member) {
            return redirect()
                ->route('dashboard')
                ->with('error', 'User belum terhubung dengan data anggota.');
        }

        $payments = CashPayment::with(['schedule.group'])
            ->where('member_id', $member->id)
            ->latest()
            ->get();

        return view('cash.my', compact('payments'));
    }
    public function exportPdf(CashGroup $cash)
    {
        $cash->load(['organization', 'schedules.payments.member']);

        $members = $cash->organization->members;

        $paymentMap = [];

        foreach ($cash->schedules as $schedule) {
            foreach ($schedule->payments as $payment) {
                $paymentMap[$payment->member_id][$schedule->id] = $payment;
            }
        }

        $pdf = Pdf::loadView('cash.pdf', compact(
            'cash',
            'members',
            'paymentMap'
        ));

        return $pdf->download('laporan-kas-' . $cash->title . '.pdf');
    }
    public function exportExcel(CashGroup $cash)
    {
        $cash->load([
            'organization',
            'schedules' => function ($query) {
                $query->orderBy('due_date');
            },
            'schedules.payments.member',
        ]);

        $members = $cash->organization->members()
            ->orderBy('full_name')
            ->get();

        $filename = 'laporan-kas-' . str_replace(' ', '-', strtolower($cash->title)) . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($cash, $members) {
            $file = fopen('php://output', 'w');

            // BOM supaya Excel baca UTF-8 dengan benar
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            $header = ['Nama Anggota'];

            foreach ($cash->schedules as $schedule) {
                $header[] = $schedule->due_date->format('d-m-Y');
            }

            $header[] = 'Total Lunas';

            fputcsv($file, $header);

            foreach ($members as $member) {
                $row = [$member->full_name];
                $totalLunas = 0;

                foreach ($cash->schedules as $schedule) {
                    $payment = $schedule->payments
                        ->where('member_id', $member->id)
                        ->first();

                    if ($payment && $payment->status === 'paid') {
                        $row[] = 'Lunas';
                        $totalLunas++;
                    } else {
                        $row[] = 'Belum';
                    }
                }

                $row[] = $totalLunas;

                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }


}