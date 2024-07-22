<?php

namespace App\Http\Controllers\Membership;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function register(){
        return view('layouts/auth-register');
    }

    public function registerMember(Request $request) {
        // Validate the request data
        $validatedData = $request->validate([
            'firstname' => 'required|string|max:255',
            'middlename' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            // 'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:15',
            'password' => 'required|string|min:8',
        ]);

        // If validation passes, the code below will execute
        User::create([
            'firstname' => $validatedData['firstname'],
            'middlename' => $validatedData['middlename'],
            'lastname' => $validatedData['lastname'],
            'email' => $validatedData['email'] ?? null,
            'phone' => $validatedData['phone'],
            'password' => $validatedData['password'],
            'username' => $validatedData['firstname'].'.'.$validatedData['lastname'],
            'active' => false,
            'available' => true,
        ]);

        return view('layouts/auth-login');
    }

    public function contributions(){
        
        return view('layouts/contributions');
    }

    public function edit(Request $request){
        // dd($request->input('member_id'));

        return view('contributions/edit_contribution');
    }
    
}
