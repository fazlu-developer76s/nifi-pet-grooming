<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\PetCategoryController;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PaymentModeController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ReferController;

Route::get('/', function () {
    return view('home');
});

Auth::routes();

// Grouping all routes with auth middleware
Route::middleware(['auth', 'checkRole'])->group(function () {
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
    Route::get('/member/kyc', [MemberController::class, 'member_kyc'])->name('member.kyc');
    Route::get('/view/member/kyc/{id}', [MemberController::class, 'view_member_kyc'])->name('view.member.kyc');
    Route::put('/update/kyc/{id}', [MemberController::class, 'update_kyc_status'])->name('update.kyc.status');

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
    Route::get('/pet-category', [PetCategoryController::class, 'index'])->name('pet.category');
    Route::match(['get', 'post'], '/route/create', [PetCategoryController::class, 'create'])->name('category.create');
    Route::get('/pet-category/{id}', [PetCategoryController::class, 'edit'])->name('category.edit');
    Route::post('/pet-category/update', [PetCategoryController::class, 'update'])->name('category.update');
    Route::delete('/category/delete/{id}', [PetCategoryController::class, 'destroy'])->name('category.destroy');



    // Notes Route
    Route::post('/note/save-notes', [NotesController::class, 'create'])->name('notes.create');
    Route::post('/note/fetch-notes', [NotesController::class, 'fetch_notes'])->name('notes.fetch');
    Route::post('/note/notes-delete', [NotesController::class, 'delete_notes'])->name('notes.delete');
    Route::post('/note/notes-disscuss', [NotesController::class, 'notes_disscuss'])->name('notes.disscuss');

    // Providers
    Route::get('/service', [ServiceController::class, 'index'])->name('service');
    Route::match(['get', 'post'], '/service/create', [ServiceController::class, 'create'])->name('service.create');
    Route::get('/service/{id}', [ServiceController::class, 'edit'])->name('service.edit');
    Route::post('/service/update', [ServiceController::class, 'update'])->name('service.update');
    Route::delete('/service/delete/{id}', [ServiceController::class, 'destroy'])->name('service.destroy');
    Route::put('/addservice-package', [ServiceController::class, 'addservice_package'])->name('addservice.package');

    // Providers
    Route::get('/package', [PackageController::class, 'index'])->name('package');
    Route::match(['get', 'post'], '/package/create', [PackageController::class, 'create'])->name('package.create');
    Route::get('/package/{id}', [PackageController::class, 'edit'])->name('package.edit');
    Route::post('/package/update', [PackageController::class, 'update'])->name('package.update');
    Route::delete('/package/delete/{id}', [PackageController::class, 'destroy'])->name('package.destroy');

    // Refer And Earn Setup Route
    Route::get('/refer', [ReferController::class, 'index'])->name('refer');
    Route::match(['get', 'post'], '/refer/create', [ReferController::class, 'create'])->name('refer.create');
    Route::match(['get', 'post'], '/earn-setup', [ReferController::class, 'refer_earn'])->name('refer.earn');

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
