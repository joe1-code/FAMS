<?php

namespace App\Http\Controllers\Payments;

use App\Exceptions\GeneralException;
use App\Http\Controllers\Backend\System\WorkflowController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MonthlyPayment;
use App\Models\Payments\PaymentMethod;
use App\Models\Unpaid_member;
use App\Models\User;
use App\Models\Workflow\WfTrack;
use App\Repositories\BaseRepository;
use App\Repositories\DocumentRepository;
use App\Repositories\PaymentsRepository;
use App\Repositories\PaymentsRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use PhpParser\Node\Expr\Throw_;
use Yajra\DataTables\Facades\DataTables;

class PaymentsController extends Controller
{
    protected $DocumentRepository, $PaymentsRepository;

    public function __construct(BaseRepository $DocumentRepository, PaymentsRepositoryInterface $PaymentsRepository)
    {
        $this->DocumentRepository = $DocumentRepository;
        $this->PaymentsRepository = $PaymentsRepository;
    }
    
    public function monthlyPayments(){
        // $user_data = User::where('available', true)->where('active', true)->get();
        $user_data = User::ActiveMembers()->get();
        $paymentMethods = PaymentMethod::all();

        return view('contributions/monthly_payments')
                    ->with('memberData', $user_data)
                    ->with('payment_methods', $paymentMethods);
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

            $current_month = null;
            
            // if (isset($checkMonth)) {
                
            //     $available_month = Carbon::parse($checkMonth)->format('m');
                
            //     $current_month = Carbon::now()->format('m');

            //     if($available_month == $current_month){
                    
            //         throw new GeneralException("You already paid for this respective Month");
            //     }
                

            // }

        //    try {
        //         if($current_month == $available_month){

        //             throw ValidationException::withMessages([
        //                 'error' => [trans('You already paid for this month.')],
        //             ]);
        //         }
        //    } 
        //    catch (\App\Exceptions\GeneralException $e) {

        //         return redirect()->back()->with('error', $e->getMessage());
        //    }
            
            $monthlyPayment = MonthlyPayment::create([
                'payment_type' => 1,
                'user_id' => $userID,
                'document_id' => $document_id,
                'paid_amount' => $request->paid_amount,
                'entitled_amount' => $user_instance[0]['entitled_amount'],
                'pay_date' => Carbon::now(),
                'payment_status' => false,
                'payment_method_id' => (int)$request->payment_method,
                'doc_used' => false,
                'total_contributions' => $contributions,
                'approval_status' => false,
            ]);
        });
        
        $resource_id = MonthlyPayment::where('user_id', $userID)->where('payment_status', false)->where('approval_status', false)->first()->id;

        $input = ['resource_id'=>$resource_id, 'module_id' => (int)$request->module_id, 'module_group_id' => (int)$request->module_group_id, 'user_id' => $userID];

        // $this->PaymentsRepository->initiateWorkflow($input);

        
        // dd($request->all());
        return redirect()->back();
    }

    public function monthlyPreviewDocument(Request $request){
        // dd($request->all());
        // return response()->json(['message' => 'Controller reached']);
       $response = $this->DocumentRepository->monthlyViewDoc($request);

       return $response;

    }

    public function getForDataTable(){
        
        $query = User::query()->join('unpaid_members as um', 'um.user_id', '=', 'users.id')
                                ->join('regions as rgn', 'rgn.id', '=', 'users.region_id')
                                ->join('districts as dst', 'dst.id', '=', 'users.district_id')
                                ->whereBetween('um.created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
                                ->select(
                                        // DB::raw("CONCAT(firstname,' ',lastname) as fullname"),
                                        DB::raw("COALESCE(firstname,'') || ' ' || COALESCE(lastname, '') as fullname"),
                                        DB::raw('dob'),
                                        DB::raw('phone'),
                                        DB::raw("case when um.pay_status = true then 'Paid' else 'Not Paid' end as pay_status"),
                                        DB::raw('rgn.name as region'),
                                        DB::raw('dst.name as district'));

                        

        return DataTables::of($query)->make(true);
    }

    public function monthlyArrears(){
        
        $arrears_particulars = $this->PaymentsRepository->arrearsInformations();
        
        return view('contributions/arrears/monthly_arrears')
                    ->with('arrears_info', $arrears_particulars);
    }

    public function getMembersWithArrearsDt(){

        return $this->PaymentsRepository->getArrears();
    }

    public function arrearsSummary(Request $request){

        $query_parameter = $request->query();

        $individual_arrears = $this->PaymentsRepository->individualArrears($query_parameter);
        
        return view('contributions/arrears/arrears_summary', ['individual_arrears' => $individual_arrears]);
    }

    public function arrearsPayment(){

        return view('contributions/arrears/arrears_payments');
    }

    public function showMonthlyPayments(){

        $workflowScriptAlreadyIncluded = false;
        $user_data = User::ActiveMembers()->get();
        $paymentMethods = PaymentMethod::all();
        // $workflowInput3 = ['resource_id' => $review->id, 'wf_module_group_id'=> $moduleGroup, 'type' => $wfModule->type, 'workflowScriptAlreadyIncluded' => $workflowScriptAlreadyIncluded];
        $workflow = WfTrack::join('wf_definitions as wd', 'wd.id', '=', 'wf_tracks.wf_definition_id')
                                    ->join('wf_modules as wfm', 'wfm.id', '=', 'wd.wf_module_id')
                                    ->join('wf_module_groups as wfmg', 'wfmg.id', '=', 'wfm.wf_module_group_id')
                                    ->where('wf_tracks.user_id', Auth()->user()->id)->orderBy('wf_tracks.created_at', 'DESC')->first();

        $workflowInput = ['resource_id' => $workflow->resource_id, 'wf_module_group_id'=> $workflow->wf_module_group_id, 'type' => $workflow->type, 'workflowScriptAlreadyIncluded' => $workflowScriptAlreadyIncluded];
        dd($workflowInput);

        return view('contributions/monthly_contributions/month_payment')
                ->with('memberData', $user_data)
                ->with('payment_methods', $paymentMethods)
                ->with('workflow', $workflowInput);
    }

    public function contributionsDocuments(){

        $user_data = User::ActiveMembers()->get();

        return view('contributions/monthly_contributions/document_centre')
                ->with('memberData', $user_data);
    }

    public function getForNonPaidDt(){

        $user_data = User::ActiveMembers()->get();
        $paymentMethods = PaymentMethod::all();

        return view('contributions/monthly_contributions/non_paid_members')
                ->with('memberData', $user_data)
                ->with('payment_methods', $paymentMethods);
    }

    public function wfHistory(){

        return view('contributions/monthly_contributions/workflow_history');
    }

    public function wfModelContent(){
        dd(12);
        $modelContent = (new WorkflowController())->getWorkflowModalContent();
        dd($modelContent);
        return view('contributions/monthly_contributions/workflow_history');
    }

    public function payArrears(){

        $user_data = User::ActiveMembers()->get();
        $paymentMethods = PaymentMethod::all();

        return view('contributions/arrears/pay_arrears')
                        ->with('memberData', $user_data)
                        ->with('payment_methods', $paymentMethods);
    }

    public function getArrearsPayments(){
        
    }



    
}
