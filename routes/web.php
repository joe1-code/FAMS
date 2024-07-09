<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Membership\MemberController;


Route::get('/', function () {
    return view('layouts/auth-login');
});

Route::get('/register', [App\Http\Controllers\Membership\MemberController::class, 'register'])->name('register');

