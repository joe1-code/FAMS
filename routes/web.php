<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Membership\MemberController;


Route::get('/', function () {
    return view('layouts/auth-login');
})->name('home');

Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');
Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::get('/register', [App\Http\Controllers\Membership\MemberController::class, 'register'])->name('register');
Route::post('/register_member', [App\Http\Controllers\Membership\MemberController::class, 'registerMember'])->name('register_member');
Route::get('/contributions', [App\Http\Controllers\Membership\MemberController::class, 'contributions'])->name('contributions');

// <==========================================membership routes============================================================================>

Route::get('/edit', [App\Http\Controllers\Membership\MemberController::class, 'edit'])->name('edit');
Route::post('/submit_members/{id}', [App\Http\Controllers\Membership\MemberController::class, 'submitEditData'])->name('submit_members');