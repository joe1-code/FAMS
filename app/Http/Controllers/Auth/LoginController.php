<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(Request $request){

        $validation = $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ]);

        if (Auth::attempt($request->only('username', 'password'), $request->filled('remember'))) {
            // Authentication passed...
            return redirect()->intended(route('contributions'));
        }
        // dump('checks..');

        $login_failed = throw ValidationException::withMessages([
                            'username' => [trans('auth.failed')],
                        ]);

        return $login_failed;
    }

    public function logout(Request $request){
        // dd($request->all());
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
