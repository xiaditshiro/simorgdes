<?php

namespace App\Http\Controllers;

use App\Models\CashGroup;
use App\Models\CashPayment;
use App\Models\CashSchedule;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;


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

        foreach ($cash->schedules as $schedule) {
            $scheduleTotals[$schedule->id] = 0;

            foreach ($schedule->payments as $payment) {
                $paymentMap[$payment->member_id][$schedule->id] = $payment;

                if ($payment->status === 'paid') {
                    $memberTotals[$payment->member_id] = ($memberTotals[$payment->member_id] ?? 0) + 1;
                    $scheduleTotals[$schedule->id]++;
                }
            }
        }

        $totalPaidCount = array_sum($scheduleTotals);
        $totalCashIn = $totalPaidCount * $cash->amount;

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

            $oldScheduleIds = $cash->schedules()->pluck('id');

            $oldPaymentIds = CashPayment::whereIn('cash_schedule_id', $oldScheduleIds)->pluck('id');

            \App\Models\FinancialTransaction::whereIn('cash_payment_id', $oldPaymentIds)->delete();

            CashPayment::whereIn('cash_schedule_id', $oldScheduleIds)->delete();
            CashSchedule::whereIn('id', $oldScheduleIds)->delete();

            $organization = Organization::findOrFail($validated['organization_id']);
            $members = $organization->members;

            foreach ($validated['dates'] as $date) {
                $schedule = CashSchedule::create([
                    'cash_group_id' => $cash->id,
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

        $payment->load('schedule.group');

        \App\Models\FinancialTransaction::firstOrCreate(
            [
                'cash_payment_id' => $payment->id,
            ],
            [
                'organization_id' => $payment->schedule->group->organization_id,
                'transaction_date' => now()->toDateString(),
                'type' => 'income',
                'source' => 'cash_payment',
                'category' => 'Kas Anggota',
                'description' => 'Pembayaran kas anggota',
                'amount' => $payment->schedule->group->amount,
                'created_by' => auth()->id(),
            ]
        );

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