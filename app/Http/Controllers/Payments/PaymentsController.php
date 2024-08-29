<?php

namespace App\Http\Controllers\Payments;

use App\Exceptions\GeneralException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MonthlyPayment;
use App\Models\User;
use App\Repositories\BaseRepository;
use App\Repositories\DocumentRepository;
use App\Repositories\PaymentsRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use PhpParser\Node\Expr\Throw_;

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

        DB::transaction(function() use($userID, $document_id, $request, $user_instance, $contributions){

            $checkMonth = MonthlyPayment::where('user_id', $userID)->orderBy('pay_date', 'DESC')->first()?->pay_date;

            $available_month = null;
            
            if (isset($checkMonth)) {
                $available_month = Carbon::parse($checkMonth)->format('m');

            }

            $current_month = Carbon::now()->format('m');
           try {
                if($current_month == $available_month){

                    throw ValidationException::withMessages([
                        'error' => [trans('You already paid for this month.')],
                    ]);
                }
           } 
           catch (\App\Exceptions\GeneralException $e) {

                return redirect()->back()->with('error', $e->getMessage());
           }
            
            
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
        });
        
        $resource_id = MonthlyPayment::where('user_id', $userID)->where('payment_status', false)->where('approval_status', false)->first()->id;

        $input = ['resource_id'=>$resource_id, 'module_id' => (int)$request->module_id, 'module_group_id' => (int)$request->module_group_id, 'user_id' => $userID];

        $this->PaymentsRepository->initiateWorkflow($input);

        
        // dd($request->all());
        return redirect()->back();
    }

    public function monthlyPreviewDocument(Request $request){
        // dd($request->all());
        // return response()->json(['message' => 'Controller reached']);
       $response = $this->DocumentRepository->monthlyViewDoc($request);

       return $response;

    }

    
}
