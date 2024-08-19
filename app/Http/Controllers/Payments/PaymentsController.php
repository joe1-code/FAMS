<?php

namespace App\Http\Controllers\Payments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class PaymentsController extends Controller
{
    public function monthlyPayments(){
        $user_data = User::where('available', true)->where('active', true)->get();

        // dd($user_data);
        return view('contributions/monthly_payments')
                    ->with('memberData', $user_data);
    }

    public function getMonthlyPayments(Request $request){
        dd($request->hasFile('document'));
        return true;
    }
}
