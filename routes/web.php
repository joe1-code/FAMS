<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Membership\MemberController;
use App\Http\Controllers\Payments\PaymentsController;


Route::get('/', function () {
    return view('layouts/auth-login');
})->name('home');

// <==========================================membership routes============================================================================>

Route::post('/landing', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('landing');
Route::get('/landing/homepage', [App\Http\Controllers\Auth\LoginController::class, 'homePage'])->name('landing/homepage');
Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::get('/members', [App\Http\Controllers\Membership\MemberController::class, 'members'])->name('members');
Route::get('/register', [App\Http\Controllers\Membership\MemberController::class, 'register'])->name('register');
Route::post('/register_member', [App\Http\Controllers\Membership\MemberController::class, 'registerMember'])->name('register_member');
Route::get('/contributions', [App\Http\Controllers\Membership\MemberController::class, 'contributions'])->name('contributions');


Route::get('/edit', [App\Http\Controllers\Membership\MemberController::class, 'edit'])->name('edit');
Route::post('/submit_members/{id}', [App\Http\Controllers\Membership\MemberController::class, 'submitEditData'])->name('submit_members');

// <==========================================monthly payments routes============================================================================>

Route::get('/payments', [App\Http\Controllers\Payments\PaymentsController::class, 'monthlyPayments'])->name('payments');
Route::get('/monthly_payment_show', [App\Http\Controllers\Payments\PaymentsController::class, 'showMonthlyPayments'])->name('monthly_payment_show');
Route::post('/get_monthly_payments', [App\Http\Controllers\Payments\PaymentsController::class, 'getMonthlyPayments'])->name('get_monthly_payments');
Route::get('/monthly_documents', [App\Http\Controllers\Payments\PaymentsController::class, 'contributionsDocuments'])->name('monthly_documents');
Route::post('/monthly_preview_document', [App\Http\Controllers\Payments\PaymentsController::class, 'monthlyPreviewDocument'])->name('monthly_preview_document');
Route::get('/monthly_nonpaid', [App\Http\Controllers\Payments\PaymentsController::class, 'getForNonPaidDt'])->name('monthly_nonpaid');
Route::get('/get_monthly_nonpaid', [App\Http\Controllers\Payments\PaymentsController::class, 'getForDataTable'])->name('get_monthly_nonpaid');
Route::get('/workflow_history', [App\Http\Controllers\Payments\PaymentsController::class, 'wfHistory'])->name('workflow_history');
Route::get('/workflow_model_content', [App\Http\Controllers\Payments\PaymentsController::class, 'wfModelContent'])->name('workflow_model_content');
Route::get('/monthly_arrears', [App\Http\Controllers\Payments\PaymentsController::class, 'monthlyArrears'])->name('monthly_arrears');
Route::get('/monthly_arrears/getForDatatable', [App\Http\Controllers\Payments\PaymentsController::class, 'getMembersWithArrearsDt'])->name('monthly_arrears/getForDatatable');
Route::get('/arrears_summary/{id?}', [App\Http\Controllers\Payments\PaymentsController::class, 'arrearsSummary'])->name('arrears_summary');
Route::post('/arrears_payment/{id?}', [App\Http\Controllers\Payments\PaymentsController::class, 'arrearsPayment'])->name('arrears_payment');
Route::get('/pay_arrears', [App\Http\Controllers\Payments\PaymentsController::class, 'payArrears'])->name('pay_arrears');
Route::post('/clear_arrears', [App\Http\Controllers\Payments\PaymentsController::class, 'getArrearsPayments'])->name('get_arrears_payment');
Route::get('/api/get_payment_limit/{userID}', [App\Http\Controllers\Payments\PaymentsController::class, 'getPaymentLimit'])->name('get_payment_limit');
