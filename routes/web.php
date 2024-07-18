<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Membership\MemberController;


Route::get('/', function () {
    return view('layouts/auth-login');
})->name('home');

Route::get('/register', [App\Http\Controllers\Membership\MemberController::class, 'register'])->name('register');
Route::post('/register_member', [App\Http\Controllers\Membership\MemberController::class, 'registerMember'])->name('register_member');

