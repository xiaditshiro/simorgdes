<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\OrganizationMember;
use App\Models\User;
use App\Models\Village;
use App\Models\Activity;
use App\Models\CashGroup;
use App\Models\CashSchedule;
use App\Models\CashPayment;

class DashboardController extends Controller
{
    public function superAdmin()
    {
        $totalVillages = Village::count();
        $totalOrganizations = Organization::count();
        $totalUsers = User::count();
        $totalProposals = \App\Models\Proposal::count();

        $recentVillages = Village::latest()->take(5)->get();
        $recentOrganizations = Organization::with('village')->latest()->take(5)->get();

        // Chart data: Orgs per village
        $orgsPerVillage = Village::withCount('organizations')->having('organizations_count', '>', 0)->get();
        $chartLabels = $orgsPerVillage->pluck('name');
        $chartData = $orgsPerVillage->pluck('organizations_count');

        return view('dashboard.superadmin', compact(
            'totalVillages',
            'totalOrganizations',
            'totalUsers',
            'totalProposals',
            'recentVillages',
            'recentOrganizations',
            'chartLabels',
            'chartData'
        ));
    }
    public function ketua()
    {
        $user = auth()->user();
        $organizationId = $user->organization_id;

        $organization = \App\Models\Organization::find($organizationId);

        $totalMembers = OrganizationMember::where('organization_id', $organizationId)->count();
        $totalActivities = Activity::where('organization_id', $organizationId)->count();
        $totalUsers = User::where('organization_id', $organizationId)->count();
        $totalCashGroups = CashGroup::where('organization_id', $organizationId)->count();

        $proposalsMasuk = \App\Models\Proposal::with(['organization', 'targetOrganization'])
            ->where('target_organization_id', $organizationId)
            ->latest()
            ->take(5)
            ->get();

        $proposalsTerkirim = \App\Models\Proposal::with(['organization', 'targetOrganization'])
            ->where('organization_id', $organizationId)
            ->latest()
            ->take(5)
            ->get();

        $pembayaranKasTerbaru = \App\Models\CashPayment::with(['member', 'schedule.group'])
            ->where('status', 'paid')
            ->whereHas('schedule.group', function ($q) use ($organizationId) {
                $q->where('organization_id', $organizationId);
            })
            ->latest('paid_at')
            ->take(5)
            ->get();

        $kegiatanTerbaru = \App\Models\Activity::where('organization_id', $organizationId)
            ->latest()
            ->take(20)
            ->get();

        $transaksiTerbaru = \App\Models\FinancialTransaction::where('organization_id', $organizationId)
            ->latest()
            ->take(5)
            ->get();

        $cashPayments = \App\Models\CashPayment::with(['member', 'schedule.group'])
            ->whereHas('schedule.group', function ($q) use ($organizationId) {
                $q->where('organization_id', $organizationId);
            })
            ->get();

        $totalCashPayments = $cashPayments->count();
        $totalCashPaid = $cashPayments->where('status', 'paid')->count();
        $totalCashUnpaid = $cashPayments->where('status', 'unpaid')->count();

        $latestCashPayments = \App\Models\CashPayment::with(['member', 'schedule.group'])
            ->whereHas('schedule.group', function ($q) use ($organizationId) {
                $q->where('organization_id', $organizationId);
            })
            ->where('status', 'unpaid')
            ->latest()
            ->take(5)
            ->get();

        $myMember = $user->organizationMember;

        $myCashPayments = collect();
        $myTotalPayments = 0;
        $myTotalPaid = 0;
        $myTotalUnpaid = 0;
        $myLatestPayments = collect();

        if ($myMember) {
            $myCashPayments = \App\Models\CashPayment::with(['schedule.group'])
                ->where('member_id', $myMember->id)
                ->latest()
                ->get();

            $myTotalPayments = $myCashPayments->count();
            $myTotalPaid = $myCashPayments->where('status', 'paid')->count();
            $myTotalUnpaid = $myCashPayments->where('status', 'unpaid')->count();

            $myLatestPayments = $myCashPayments
                ->where('status', 'unpaid')
                ->take(5);
        }

        $chartData = $this->getChartData($organizationId);

        return view('dashboard.ketua', array_merge(compact(
            'organization',
            'totalMembers',
            'totalActivities',
            'totalCashGroups',
            'totalUsers',
            'proposalsMasuk',
            'proposalsTerkirim',
            'pembayaranKasTerbaru',
            'kegiatanTerbaru',
            'transaksiTerbaru',
            'totalCashPayments',
            'totalCashPaid',
            'totalCashUnpaid',
            'latestCashPayments',
            'myMember',
            'myTotalPayments',
            'myTotalPaid',
            'myTotalUnpaid',
            'myLatestPayments'
        ), $chartData));
    }
    public function bendahara()
    {
        $user = auth()->user();
        $organizationId = $user->organization_id;

        $organization = Organization::find($organizationId);

        $totalMembers = OrganizationMember::where('organization_id', $organizationId)->count();
        $totalCashGroups = CashGroup::where('organization_id', $organizationId)->count();

        $cashGroupIds = CashGroup::where('organization_id', $organizationId)->pluck('id');
        $scheduleIds = CashSchedule::whereIn('cash_group_id', $cashGroupIds)->pluck('id');

        $totalSchedules = CashSchedule::whereIn('cash_group_id', $cashGroupIds)->count();

        $totalPaid = CashPayment::whereIn('cash_schedule_id', $scheduleIds)
            ->where('status', 'paid')
            ->count();

        $totalUnpaid = CashPayment::whereIn('cash_schedule_id', $scheduleIds)
            ->where('status', 'unpaid')
            ->count();

        $totalCashIn = 0;

        $cashGroups = CashGroup::with('schedules')->where('organization_id', $organizationId)->get();

        foreach ($cashGroups as $group) {
            foreach ($group->schedules as $schedule) {
                $paidCount = CashPayment::where('cash_schedule_id', $schedule->id)
                    ->where('status', 'paid')
                    ->count();

                $totalCashIn += $paidCount * $group->amount;
            }
        }

        $latestCashGroups = CashGroup::where('organization_id', $organizationId)
            ->latest()
            ->take(5)
            ->get();

        $cashPayments = \App\Models\CashPayment::with(['member', 'schedule.group'])
            ->whereHas('schedule.group', function ($q) use ($organizationId) {
                $q->where('organization_id', $organizationId);
            })
            ->get();

        $totalCashPayments = $cashPayments->count();
        $totalCashPaid = $cashPayments->where('status', 'paid')->count();
        $totalCashUnpaid = $cashPayments->where('status', 'unpaid')->count();

        $latestCashPayments = \App\Models\CashPayment::with(['member', 'schedule.group'])
            ->whereHas('schedule.group', function ($q) use ($organizationId) {
                $q->where('organization_id', $organizationId);
            })
            ->where('status', 'unpaid')
            ->latest()
            ->take(5)
            ->get();

        $myMember = $user->organizationMember;

        $myCashPayments = collect();
        $myTotalPayments = 0;
        $myTotalPaid = 0;
        $myTotalUnpaid = 0;
        $myLatestPayments = collect();

        if ($myMember) {
            $myCashPayments = \App\Models\CashPayment::with(['schedule.group'])
                ->where('member_id', $myMember->id)
                ->latest()
                ->get();

            $myTotalPayments = $myCashPayments->count();
            $myTotalPaid = $myCashPayments->where('status', 'paid')->count();
            $myTotalUnpaid = $myCashPayments->where('status', 'unpaid')->count();

            $myLatestPayments = $myCashPayments
                ->where('status', 'unpaid')
                ->take(5);
        }

        $chartData = $this->getChartData($organizationId);

        return view('dashboard.bendahara', array_merge(compact(
            'organization',
            'totalMembers',
            'totalCashGroups',
            'totalSchedules',
            'totalPaid',
            'totalUnpaid',
            'totalCashIn',
            'latestCashGroups',
            'totalCashPayments',
            'totalCashPaid',
            'totalCashUnpaid',
            'latestCashPayments',
            'myMember',
            'myTotalPayments',
            'myTotalPaid',
            'myTotalUnpaid',
            'myLatestPayments'
        ), $chartData));
    }
    public function anggota()
    {
        $user = auth()->user();
        $member = $user->organizationMember;

        if (!$member) {
            return view('dashboard.anggota', [
                'member' => null,
                'organization' => null,
                'totalPayments' => 0,
                'totalPaid' => 0,
                'totalUnpaid' => 0,
                'latestPayments' => collect(),
                'latestActivities' => collect(),
            ]);
        }

        $organization = $member->organization;

        $payments = CashPayment::with(['schedule.group'])
            ->where('member_id', $member->id)
            ->latest()
            ->get();

        $totalPayments = $payments->count();
        $totalPaid = $payments->where('status', 'paid')->count();
        $totalUnpaid = $payments->where('status', 'unpaid')->count();

        $latestPayments = $payments->where('status', 'unpaid')->take(5);

        $latestActivities = \App\Models\Activity::where('organization_id', $organization->id)
            ->latest()
            ->take(20)
            ->get();

        return view('dashboard.anggota', compact(
            'member',
            'organization',
            'totalPayments',
            'totalPaid',
            'totalUnpaid',
            'latestPayments',
            'latestActivities'
        ));
    }
    public function sekretaris()
    {
        $user = auth()->user();
        $organizationId = $user->organization_id;

        $organization = Organization::find($organizationId);

        $totalMembers = OrganizationMember::where('organization_id', $organizationId)->count();
        $totalActivities = Activity::where('organization_id', $organizationId)->count();

        $latestActivities = Activity::where('organization_id', $organizationId)
            ->latest()
            ->take(20)
            ->get();

        $myMember = $user->organizationMember;

        $myCashPayments = collect();
        $myTotalPayments = 0;
        $myTotalPaid = 0;
        $myTotalUnpaid = 0;
        $myLatestPayments = collect();

        if ($myMember) {
            $myCashPayments = \App\Models\CashPayment::with(['schedule.group'])
                ->where('member_id', $myMember->id)
                ->latest()
                ->get();

            $myTotalPayments = $myCashPayments->count();
            $myTotalPaid = $myCashPayments->where('status', 'paid')->count();
            $myTotalUnpaid = $myCashPayments->where('status', 'unpaid')->count();

            $myLatestPayments = $myCashPayments
                ->where('status', 'unpaid')
                ->take(5);
        }

        $chartData = $this->getChartData($organizationId);

        return view('dashboard.sekretaris', array_merge(compact(
            'organization',
            'totalMembers',
            'totalActivities',
            'latestActivities',
            'myMember',
            'myTotalPayments',
            'myTotalPaid',
            'myTotalUnpaid',
            'myLatestPayments'
        ), $chartData));
    }
    public function desa()
    {
        $totalOrganizations = Organization::count();
        $totalMembers = OrganizationMember::count();
        $totalActivities = Activity::count();
        $totalUsers = User::count();

        $latestOrganizations = Organization::latest()
            ->take(5)
            ->get();

        return view('dashboard.desa', compact(
            'totalOrganizations',
            'totalMembers',
            'totalActivities',
            'totalUsers',
            'latestOrganizations'
        ));
    }

    private function getChartData($organizationId)
    {
        // 1. Line Chart: Income vs Expense (Last 6 Months)
        $months = [];
        $incomeData = [];
        $expenseData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->format('M Y');
            
            $income = \App\Models\FinancialTransaction::where('organization_id', $organizationId)
                ->where('type', 'income')
                ->whereMonth('transaction_date', $date->month)
                ->whereYear('transaction_date', $date->year)
                ->sum('amount');
            
            $expense = \App\Models\FinancialTransaction::where('organization_id', $organizationId)
                ->where('type', 'expense')
                ->whereMonth('transaction_date', $date->month)
                ->whereYear('transaction_date', $date->year)
                ->sum('amount');

            $incomeData[] = (float) $income;
            $expenseData[] = (float) $expense;
        }

        // 2. Pie Chart: Expense Composition
        $expensesByCategory = \App\Models\FinancialTransaction::selectRaw('category, SUM(amount) as total')
            ->where('organization_id', $organizationId)
            ->where('type', 'expense')
            ->groupBy('category')
            ->get();

        $expenseLabels = $expensesByCategory->pluck('category')->map(fn($c) => $c ?? 'Lainnya');
        $expenseValues = $expensesByCategory->pluck('total')->map(fn($v) => (float) $v);

        // 3. Pie Chart: Cash Discipline
        $cashPayments = \App\Models\CashPayment::whereHas('schedule.group', function ($q) use ($organizationId) {
            $q->where('organization_id', $organizationId);
        })->get();

        $paidCount = $cashPayments->where('status', 'paid')->count();
        $unpaidCount = $cashPayments->where('status', 'unpaid')->count();

        return [
            'chartMonthlyLabels' => $months,
            'chartMonthlyIncome' => $incomeData,
            'chartMonthlyExpense' => $expenseData,
            'chartExpenseLabels' => $expenseLabels,
            'chartExpenseData' => $expenseValues,
            'chartDisciplineData' => [$paidCount, $unpaidCount]
        ];
    }
}