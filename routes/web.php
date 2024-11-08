<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\ZipController;
use App\Http\Controllers\AssignrouteController;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\ProvidersController;
use App\Http\Controllers\PaymentModeController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\CmsController;
use App\Http\Controllers\CompanyController;

Route::get('/', function () {
    return view('home');
});

Auth::routes();

// Grouping all routes with auth middleware
Route::middleware(['auth','checkRole'])->group(function () {
    // Dashboard Route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Role Routes
    Route::get('/roles', [RoleController::class, 'index'])->name('roles');
    Route::post('/store-roles', [RoleController::class, 'store_roles'])->name('store.roles');
    Route::get('/edit-roles/{id}', [RoleController::class, 'edit_roles'])->name('edit.roles');
    Route::delete('/destroy-roles/{id}', [RoleController::class, 'destroy_roles'])->name('destroy.roles');

    // Member Routes
    Route::get('/member', [MemberController::class, 'index'])->name('member');
    Route::get('/borrower', [MemberController::class, 'borrower'])->name('borrower');
    Route::get('/userlocation', [MemberController::class, 'borrower'])->name('userlocation')->middleware('user_location');
    Route::post('/user_location/check-otp', [MemberController::class, 'check_otp'])->name('userlocation.otp.check');

    Route::match(['get', 'post'], '/member/create', [MemberController::class, 'create'])->name('member.create');
    Route::get('/member/edit/{id}', [MemberController::class, 'edit'])->name('member.edit');
    Route::get('/member/view/{id}', [MemberController::class, 'view'])->name('member.view');
    Route::post('/member/update', [MemberController::class, 'update'])->name('member.update');
    Route::delete('/member/delete/{id}', [MemberController::class, 'destroy'])->name('member.destroy');

    // Permission Route
    Route::get('/permission/{id}', [RoleController::class, 'permission'])->name('permission');
    Route::post('/permission/update', [RoleController::class, 'update_permission'])->name('permission.update');

    // Status Active Inactive Route
    Route::post('/change-status', [RoleController::class, 'change_status'])->name('change.status');

    // Lead Routes
    Route::get('/lead', [LeadController::class, 'index'])->name('lead');
    Route::get('/lead-admin', [LeadController::class, 'admin_lead'])->name('lead.admin');
    Route::match(['get', 'post'], '/lead/create', [LeadController::class, 'create'])->name('lead.create');
    Route::get('/lead/edit/{id}', [LeadController::class, 'edit'])->name('lead.edit');
    Route::get('/lead/view/{id}', [LeadController::class, 'view'])->name('lead.view');
    Route::post('/lead/update', [LeadController::class, 'update'])->name('lead.update');
    Route::delete('/lead/delete/{id}', [LeadController::class, 'destroy'])->name('lead.destroy');
    Route::post('/viewright-modal', [LeadController::class, 'viewright_modal'])->name('viewright.modal');
    Route::get('/lead-qualified', [LeadController::class, 'qualified_leads'])->name('lead.qualified');
    Route::get('/kyclead/view/{id}', [LeadController::class, 'kyclead_view'])->name('kyclead.view');
    Route::post('/kyc-process', [LeadController::class, 'kyc_process'])->name('kyc.process');

    // Route
    Route::get('/route', [RouteController::class, 'index'])->name('route');
    Route::match(['get', 'post'], '/route/create', [RouteController::class, 'create'])->name('route.create');
    Route::get('/route/{id}', [RouteController::class, 'edit'])->name('route.edit');
    Route::post('/route/update', [RouteController::class, 'update'])->name('route.update');
    Route::delete('/route/delete/{id}', [RouteController::class, 'destroy'])->name('route.destroy');


    // Assign Route
    Route::get('/routeassign', [AssignrouteController::class, 'index'])->name('routeassign');
    Route::match(['get', 'post'], '/routeassign/create', [AssignrouteController::class, 'create'])->name('routeassign.create');
    Route::get('/routeassign/{id}', [AssignrouteController::class, 'edit'])->name('routeassign.edit');
    Route::post('/routeassign/update', [AssignrouteController::class, 'update'])->name('routeassign.update');
    Route::delete('/routeassign/delete/{id}', [AssignrouteController::class, 'destroy'])->name('routeassign.destroy');
    Route::get('/routeassign-view/{id}', [AssignrouteController::class, 'view'])->name('routeassign.view');
    Route::get('/routeassign-remove/{id}', [AssignrouteController::class, 'remove_route'])->name('routeassign.remove');

    // Notes Route
    Route::post('/note/save-notes', [NotesController::class, 'create'])->name('notes.create');
    Route::post('/note/fetch-notes', [NotesController::class, 'fetch_notes'])->name('notes.fetch');
    Route::post('/note/notes-delete', [NotesController::class, 'delete_notes'])->name('notes.delete');
    Route::post('/note/notes-disscuss', [NotesController::class, 'notes_disscuss'])->name('notes.disscuss');

       // Providers
       Route::get('/providers', [ProvidersController::class, 'index'])->name('providers');
       Route::match(['get', 'post'], '/providers/create', [ProvidersController::class, 'create'])->name('providers.create');
       Route::get('/providers/{id}', [ProvidersController::class, 'edit'])->name('providers.edit');
       Route::post('/providers/update', [ProvidersController::class, 'update'])->name('providers.update');
       Route::delete('/providers/delete/{id}', [ProvidersController::class, 'destroy'])->name('providers.destroy');
// Payment Mode
        Route::get('/payment-mode', [PaymentModeController::class, 'index'])->name('payment_mode');
        Route::match(['get', 'post'], '/payment-mode/create', [PaymentModeController::class, 'create'])->name('payment_mode.create');
        Route::get('/payment-mode/{id}', [PaymentModeController::class, 'edit'])->name('payment_mode.edit');
        Route::post('/payment-mode/update', [PaymentModeController::class, 'update'])->name('payment_mode.update');
        Route::delete('/payment-mode/delete/{id}', [PaymentModeController::class, 'destroy'])->name('payment_mode.destroy');
        // Bank Detail
        Route::get('/bank', [BankController::class, 'index'])->name('bank');
        Route::match(['get', 'post'], '/bank/create', [BankController::class, 'create'])->name('bank.create');
        Route::get('/bank/{id}', [BankController::class, 'edit'])->name('bank.edit');
        Route::post('/bank/update', [BankController::class, 'update'])->name('bank.update');
        Route::delete('/bank/delete/{id}', [BankController::class, 'destroy'])->name('bank.destroy');
        // cms route
        Route::get('company/{id}/edit', [CompanyController::class, 'edit'])->name('company.edit');
        Route::post('company/{id}', [CompanyController::class, 'update'])->name('company.update');


});
