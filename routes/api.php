<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoanRequestController;
use App\Http\Controllers\BorrowerController;
use App\Http\Controllers\KycController;
use App\Http\Controllers\EmiCollection;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('user/signup', [AuthController::class, 'signup']);
Route::post('user/login', [AuthController::class, 'login']);
Route::post('user/user-resend-otp', [AuthController::class, 'resend_otp']);
Route::post('user/user-login-otp', [AuthController::class, 'user_otp']);
Route::post('user/token-status', [AuthController::class, 'getTokenStatus']);
Route::get('user/referal-signup', [AuthController::class, 'register_referral_user'])->name('referaluser');
Route::middleware(['jwt'])->group(function () {
    Route::post('user/referal', [AuthController::class, 'referal']);
    Route::post('user/user-logout', [AuthController::class, 'user_logout']);
    Route::post('user/user-create-pin', [AuthController::class, 'create_pin']);
    Route::get('user/loan-request-list', [LoanRequestController::class, 'loan_request_list']);
    Route::post('user/update-email-mobile', [BorrowerController::class, 'update_email_mobile_request']);
    Route::post('user/update-new-email-mobile', [BorrowerController::class, 'update_new_email_mobile_request']);
    Route::post('user/update-profile', [BorrowerController::class, 'update_profile']);
    Route::post('user/approve-update-request', [BorrowerController::class, 'approve_update_request']);
    Route::get('user/update-request-list', [BorrowerController::class, 'update_request_list']);
    Route::post('user/loan-request', [LoanRequestController::class, 'create_loan_request']);
    Route::post('user/create-loan', [LoanRequestController::class, 'create_loan']);
    Route::get('user/loan-list', [LoanRequestController::class, 'loan_list']);
    Route::post('user/loan-approval', [LoanRequestController::class, 'loan_approval']);
    Route::get('user/user-profile', [BorrowerController::class, 'user_profile']);
    Route::get('user/user-list', [BorrowerController::class, 'user_list']);
    Route::post('user/user-update-status', [BorrowerController::class, 'user_update_status']);
    Route::post('user/user-kyc', [KycController::class, 'user_kyc_request']);
    Route::get('user/kyc-request-list', [KycController::class, 'kyc_request_list']);
    Route::post('user/kyc-apporval', [KycController::class, 'kyc_approval']);
    Route::post('user/kyc-pending-list', [KycController::class, 'kyc_pending_list']);
    Route::post('user/kyc-submit', [KycController::class, 'kyc_submit']);
    Route::get('user/my-loan', [LoanRequestController::class, 'my_loan']);
    Route::post('user/upload-kyc-docs', [KycController::class, 'kycDocs']);
    Route::get('user/loan-reports', [LoanRequestController::class, 'loan_report']);
    Route::get('user/service-list', [LoanRequestController::class, 'service_list']);

    Route::get('user/ready-for-disbursement-loan', [LoanRequestController::class, 'ready_for_disbursement_loan']);
    Route::post('user/loan-disbursement', [LoanRequestController::class, 'loan_disbursement']);
    Route::post('user/borrower-image', [LoanRequestController::class, 'borrower_image']);
    Route::post('user/disbursement-otp', [LoanRequestController::class, 'disbursement_otp']);
    Route::get('user/payment-modes', [LoanRequestController::class, 'payment_modes']);
    Route::get('user/bank-details', [LoanRequestController::class, 'bank_details']);
    Route::post('user/emi-collection', [EmiCollection::class, 'emi_collection']);
    Route::get('user/borrower-loan', [EmiCollection::class, 'borrower_loan']);
    Route::get('user/route-agent-loan', [BorrowerController::class, 'route_agent_list']);
    Route::post('user/emi-details', [EmiCollection::class, 'emi_details']);
    Route::get('user/receieve-emi', [EmiCollection::class, 'receieve_emi']);
    Route::post('user/emi-pay', [EmiCollection::class, 'emi_pay']);
});
