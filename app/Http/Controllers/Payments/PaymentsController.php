<?php

namespace App\Http\Controllers\Payments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MonthlyPayment;
use App\Models\User;
use App\Repositories\BaseRepository;
use App\Repositories\DocumentRepository;
use App\Repositories\PaymentsRepositoryInterface;
use Carbon\Carbon;

class PaymentsController extends Controller
{
    protected $DocumentRepository, $PaymentsRepository;

    public function __construct(BaseRepository $DocumentRepository, PaymentsRepositoryInterface $PaymentsRepository)
    {
        $this->DocumentRepository = $DocumentRepository;
        $this->PaymentsRepository = $PaymentsRepository;
    }
    
    public function monthlyPayments(){
        $user_data = User::where('available', true)->where('active', true)->get();

        // dd($user_data);
        return view('contributions/monthly_payments')
                    ->with('memberData', $user_data);
    }

    public function getMonthlyPayments(Request $request){
        // dd($request->all());

       $document_id = $this->DocumentRepository->storeMonthlyPaymentsDocs($request);

       $contributions = $this->PaymentsRepository->monthlyTotalContributions($request);

        $userID = (int)$request->id;
        $user_instance = User::where('id', $userID)->get();

        $monthlyPayment = MonthlyPayment::create([
                'payment_type' => 1,
                'user_id' => $userID,
                'document_id' => $document_id,
                'paid_amount' => $request->paid_amount,
                'entitled_amount' => $user_instance[0]['entitled_amount'],
                'pay_date' => Carbon::now(),
                'payment_status' => false,
                'doc_used' => false,
                'total_contributions' => $contributions,
                'approval_status' => false,
        ]);


        
        dd($request->all());
        return true;
    }
}
