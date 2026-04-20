<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VillageController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\OrganizationMemberController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ActivityAttendanceController;
use App\Http\Controllers\CashScheduleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FinancialTransactionController;
use App\Http\Controllers\FinancialCategoryController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\ProposalMessageController;
use App\Http\Controllers\WhatsAppWebhookController;
use App\Http\Controllers\SystemSettingController;


Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->hasRole('super_admin')) {
        return redirect()->route('superadmin.dashboard');
    }

    if ($user->hasRole('admin_desa')) {
        return redirect()->route('desa.dashboard');
    }

    if ($user->hasRole('ketua')) {
        return redirect()->route('ketua.dashboard');
    }

    if ($user->hasRole('sekretaris')) {
        return redirect()->route('sekretaris.dashboard');
    }

    if ($user->hasRole('bendahara')) {
        return redirect()->route('bendahara.dashboard');
    }

    if ($user->hasRole('anggota')) {
        return redirect()->route('anggota.dashboard');
    }

    abort(403, 'Role tidak dikenali.');
})->middleware(['auth'])->name('dashboard');


/*
|--------------------------------------------------------------------------
| SUPER ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:super_admin'])->group(function () {

    Route::get('/superadmin/dashboard', [DashboardController::class, 'superAdmin'])
        ->name('superadmin.dashboard');

    Route::resource('villages', VillageController::class);

    Route::resource('organizations', OrganizationController::class);

    Route::resource('users', UserController::class);

    // Advance Settings
    Route::get('/admin/advance', [SystemSettingController::class, 'advanceIndex'])
        ->name('admin.settings.advance');
    Route::post('/admin/advance/chatbot', [SystemSettingController::class, 'updateChatbot'])
        ->name('admin.settings.chatbot.update');
    Route::post('/admin/advance/receipt', [SystemSettingController::class, 'updateReceipt'])
        ->name('admin.settings.receipt.update');
    Route::post('/admin/advance/maintenance', [SystemSettingController::class, 'updateMaintenance'])
        ->name('admin.settings.maintenance.update');
    Route::post('/admin/advance/standby', [SystemSettingController::class, 'updateStandbyMessage'])
        ->name('admin.settings.standby.update');
    Route::get('/admin/advance/wa-check', [SystemSettingController::class, 'checkWhatsApp'])
        ->name('admin.settings.wa.check');
    Route::delete('/admin/advance/logs', [SystemSettingController::class, 'clearWebhookLogs'])
        ->name('admin.settings.logs.clear');
});


/*
|--------------------------------------------------------------------------
| ADMIN DESA
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin_desa,super_admin'])->group(function () {

    Route::get('/desa/dashboard', [DashboardController::class, 'desa'])
        ->name('desa.dashboard');

    Route::resource('organizations', OrganizationController::class);
});


/*
|--------------------------------------------------------------------------
| DATA ANGGOTA
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:super_admin,admin_desa,ketua,sekretaris'])->group(function () {

    Route::resource('members', OrganizationMemberController::class);

    Route::post(
        '/members/{member}/create-user',
        [OrganizationMemberController::class, 'createUser']
    )
        ->name('members.create-user');
});


/*
|--------------------------------------------------------------------------
| KEGIATAN ORGANISASI
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:super_admin,admin_desa,ketua,sekretaris'])->group(function () {

    Route::resource('activities', ActivityController::class);

    Route::get(
        '/activities/{activity}/attendances',
        [ActivityAttendanceController::class, 'index']
    )
        ->name('activities.attendances.index');

    Route::post(
        '/activities/{activity}/attendances',
        [ActivityAttendanceController::class, 'store']
    )
        ->name('activities.attendances.store');

    Route::get('/activities-export/pdf', [ActivityController::class, 'exportPdf'])
        ->name('activities.export.pdf');

    Route::get('/activities-export/excel', [ActivityController::class, 'exportExcel'])
        ->name('activities.export.excel');
});


/*
|--------------------------------------------------------------------------
| KAS ANGGOTA
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:super_admin,ketua,bendahara'])->group(function () {

    Route::get('/cash', [CashScheduleController::class, 'index'])->name('cash.index');

    Route::get('/cash/create', [CashScheduleController::class, 'create'])->name('cash.create');

    Route::post('/cash', [CashScheduleController::class, 'store'])->name('cash.store');

    Route::get('/cash/{cash}', [CashScheduleController::class, 'show'])->name('cash.show');

    Route::get('/cash/{cash}/edit', [CashScheduleController::class, 'edit'])->name('cash.edit');

    Route::put('/cash/{cash}', [CashScheduleController::class, 'update'])->name('cash.update');

    Route::delete('/cash/{cash}', [CashScheduleController::class, 'destroy'])->name('cash.destroy');

    Route::post(
        '/cash/payment/{payment}/paid',
        [CashScheduleController::class, 'markPaid']
    )->name('cash.paid');

    Route::post(
        '/cash/payment/{payment}/unpaid',
        [CashScheduleController::class, 'markUnpaid']
    )->name('cash.unpaid');

    Route::get(
        '/cash/{cash}/pdf',
        [CashScheduleController::class, 'exportPdf']
    )->name('cash.pdf');

    Route::get(
        '/cash/{cash}/excel',
        [CashScheduleController::class, 'exportExcel']
    )->name('cash.excel');

});


/*
|--------------------------------------------------------------------------
| KAS SAYA (ANGGOTA)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:anggota'])->group(function () {

    Route::get(
        '/my-cash',
        [CashScheduleController::class, 'myCash']
    )
        ->name('cash.my');

});


/*
|--------------------------------------------------------------------------
| DASHBOARD ROLE
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:ketua'])->group(function () {

    Route::get(
        '/ketua/dashboard',
        [DashboardController::class, 'ketua']
    )
        ->name('ketua.dashboard');

});

Route::middleware(['auth', 'role:sekretaris'])->group(function () {

    Route::get(
        '/sekretaris/dashboard',
        [DashboardController::class, 'sekretaris']
    )
        ->name('sekretaris.dashboard');

});

Route::middleware(['auth', 'role:bendahara'])->group(function () {

    Route::get(
        '/bendahara/dashboard',
        [DashboardController::class, 'bendahara']
    )
        ->name('bendahara.dashboard');

});

Route::middleware(['auth', 'role:anggota'])->group(function () {

    Route::get(
        '/anggota/dashboard',
        [DashboardController::class, 'anggota']
    )
        ->name('anggota.dashboard');

});


Route::middleware(['auth', 'role:super_admin,ketua,bendahara'])->group(function () {
    Route::get('/finance/categories', [FinancialCategoryController::class, 'index'])
        ->name('finance.categories');

    Route::post('/finance/categories', [FinancialCategoryController::class, 'store'])
        ->name('finance.categories.store');

    Route::delete('/finance/categories/{category}', [FinancialCategoryController::class, 'destroy'])
        ->name('finance.categories.delete');

    Route::resource('finance', FinancialTransactionController::class);
});



Route::middleware(['auth', 'role:super_admin,ketua,admin_desa,sekretaris'])->group(function () {

    Route::get('/proposals/inbox', [ProposalController::class, 'inbox'])
        ->name('proposals.inbox');

    Route::get('/proposals/sent', [ProposalController::class, 'sent'])
        ->name('proposals.sent');

    Route::post('/proposals/{proposal}/approve', [ProposalController::class, 'approve'])
        ->name('proposals.approve');

    Route::post('/proposals/{proposal}/reject', [ProposalController::class, 'reject'])
        ->name('proposals.reject');

    Route::post('/proposals/{proposal}/messages', [ProposalMessageController::class, 'store'])
        ->name('proposals.messages.store');

    Route::resource('proposals', ProposalController::class);
});




Route::middleware(['auth', 'role:super_admin,admin_desa,ketua,sekretaris,bendahara'])->group(function () {
    Route::get('/activities/{activity}/attendance/scanner', [ActivityAttendanceController::class, 'scanner'])
        ->name('activities.attendances.scanner');

    Route::post('/activities/{activity}/attendance/scan', [ActivityAttendanceController::class, 'scanStore'])
        ->name('activities.attendances.scan');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/my-attendance-qr', [ActivityAttendanceController::class, 'myQr'])
        ->name('attendance.my-qr');

    // NEW: Member Self Check-in with GPS
    Route::get('/attendance/scan', [ActivityAttendanceController::class, 'selfScanner'])
        ->name('attendance.self-scanner');
    Route::post('/attendance/scan', [ActivityAttendanceController::class, 'selfScanStore'])
        ->name('attendance.self-scan.store');
    
    // NEW: Admin shows Activity QR
    Route::get('/activities/{activity}/qr', [ActivityAttendanceController::class, 'showActivityQr'])
        ->name('activities.qr');

    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::match(['get', 'post'], '/webhook/whatsapp', [WhatsAppWebhookController::class, 'handle'])
    ->name('webhook.whatsapp');