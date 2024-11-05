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
Route::post('/get_monthly_payments', [App\Http\Controllers\Payments\PaymentsController::class, 'getMonthlyPayments'])->name('get_monthly_payments');
Route::post('/monthly_preview_document', [App\Http\Controllers\Payments\PaymentsController::class, 'monthlyPreviewDocument'])->name('monthly_preview_document');
Route::get('/get_monthly_nonpaid', [App\Http\Controllers\Payments\PaymentsController::class, 'getForDataTable'])->name('get_monthly_nonpaid');
Route::get('/monthly_arrears', [App\Http\Controllers\Payments\PaymentsController::class, 'monthlyArrears'])->name('monthly_arrears');