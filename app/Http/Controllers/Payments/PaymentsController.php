<?php

namespace App\Http\Controllers\Payments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class PaymentsController extends Controller
{
    public function monthlyPayments(){
        $user_data = User::get();
        // dd($user_data);
        return view('contributions/monthly_payments')
                    ->with('memberData', $user_data);
    }
}
