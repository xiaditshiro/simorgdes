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
        return view('dashboard.superadmin', [
            'totalVillages' => Village::count(),
            'totalOrganizations' => Organization::count(),
            'totalMembers' => OrganizationMember::count(),
            'totalUsers' => User::count(),
        ]);
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
            ->take(5)
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
            ->where('status', 'paid')
            ->latest('paid_at')
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

        return view('dashboard.ketua', compact(
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
        ));
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
            ->where('status', 'paid')
            ->latest('paid_at')
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

        return view('dashboard.bendahara', compact(
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
        ));
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

        $latestPayments = $payments
            ->where('status', 'unpaid')
            ->take(5);

        $latestActivities = \App\Models\Activity::where('organization_id', $organization->id)
            ->latest()
            ->take(5)
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

        return view('dashboard.sekretaris', compact(
            'organization',
            'totalMembers',
            'totalActivities',
            'latestActivities',
            'myMember',
            'myTotalPayments',
            'myTotalPaid',
            'myTotalUnpaid',
            'myLatestPayments'
        ));
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
}