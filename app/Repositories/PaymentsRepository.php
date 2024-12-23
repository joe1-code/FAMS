<?php

namespace App\Repositories;

use App\Events\NewWorkflow;
use App\Models\ArrearsPayment;
use App\Models\MonthlyPayment;
use App\Models\Payments\PaymentMethod;
use App\Models\Unpaid_member;
use App\Models\User;
use App\Models\Workflow\Wf_definition;
use App\Models\Workflow\WfTrack;
use App\Repositories\PaymentsRepositoryInterface;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PaymentsRepository implements PaymentsRepositoryInterface
{
    /**
     * Create a new class instance.
     */

     protected $model;
    public function __construct(MonthlyPayment $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $record = $this->find($id);
        $record->update($data);

        return $record;
    }

    public function delete($id)
    {
        $record = $this->find($id);
        return $record->delete();
    }

    // <===============================================================Payments Methods==============================================================>

    public function monthlyTotalContributions($request){

            // dd($request->all());
            $previous_contribution = MonthlyPayment::select('total_contributions')
                                    ->where('user_id', (int)$request->id)
                                    ->latest()
                                    ->first();

            $total_contribution = $previous_contribution ? $previous_contribution['total_contributions'] + (int)$request->paid_amount : 0;  
                                              
        return $total_contribution;
    }

    public function initiateWorkflow($input)
    {

        return DB::transaction(function () use ($input) {
            // $wfModule = new WfModuleRepository();
            // $moduleRepo = new WfModuleRepository();
            $group = $input['module_group_id'];
            $resource = $input['resource_id'];
            $type = 1;
            $comments = null;
            $user = $input['user_id'] ?? NULL;
            $module = $input['module_id'];
            
            //Initialize Workflow
                event(new NewWorkflow(['wf_module_group_id' => $group, 'resource_id' => $resource, 'type' => $type, 'user' => $user, 'module_id' => $input['module_id']], [], ['comments' => $comments]));
                return $input;
            });
    }


    public function storeMonthlyPaymentsDocs($request)
    {
        // Implement the logic for storing monthly payment documents
        // This is just a placeholder for now
        return true;
    }

    public function monthlyViewDoc($request){

        return null;
    }

    public function getRecentResourceTrack($module_id, $resource_id)
    {
        // dd(Wf_track::get());
        $wf_track = WfTrack::where('resource_id', $resource_id)->whereHas('WfDefinition', function ($query) use ($module_id) {
            $query->where('wf_module_id', $module_id);
        })->orderBy('id','desc')->first();

        return $wf_track;
    }

    public function getDefinition($module_id, $resource_id)
    {
        $track = $this->getRecentResourceTrack($module_id, $resource_id);

        if (empty($track)) {
            $definition = Wf_definition::where(['wf_module_id' => $module_id, 'level' => 1])->first();

            $wf_definition_id = $definition->id;

        } else {
            $wf_definition_id = $track->wf_definition_id;
        }
        //dd($track);
        return $wf_definition_id;
    }

    public function getArrears(){
        
        $query = (new Unpaid_member())->query()
                ->join('users as u', 'u.id', '=', 'unpaid_members.user_id')
                ->join('regions as rgn', 'rgn.id', '=', 'u.region_id')
                ->join('districts as dist', 'dist.id', '=', 'u.district_id')
                ->select("u.*", 
                            "rgn.name as region_name",
                            "dist.name as district_name",
                            DB::raw("COALESCE(u.firstname, '') || ' ' || COALESCE(u.lastname, '') AS fullname"), 
                            DB::raw("SUM(unpaid_members.total_arrears) AS arrears"), 
                            DB::raw("MAX(unpaid_members.created_at) AS latest_month"))
                ->where('pay_status', 0)
                ->whereNotNull('unpaid_members.deleted_at')
                ->groupBy('u.id', 'fullname', 'region_name', 'district_name')
                ->get();

        return DataTables::of($query)->make(true);
    }

    public function individualArrears($id){

        return (new Unpaid_member())->query()
                ->select(['unpaid_members.*',
                    DB::raw("COALESCE(u.firstname, ' ') ||' '|| COALESCE(u.middlename, ' ') ||' '|| COALESCE(u.lastname, ' ') AS full_name"),
                    DB::raw("EXTRACT(Year FROM AGE(CURRENT_DATE, u.dob)) AS age"),
                    DB::raw('(COALESCE(u.entitled_amount, 0) - COALESCE(unpaid_members.paid_amount, 0)) AS monthly_arrear'),
                    'u.job_title','u.phone','u.email','u.entitled_amount', 
                    ])
                ->join('users as u', 'u.id', '=', 'unpaid_members.user_id')
                ->whereNotNull('unpaid_members.deleted_at')
                ->where('user_id', $id)
                ->where('pay_status', false)    
                ->get();

                    
    }

    public function arrearsInformations(){

        $unpaidObj = (new Unpaid_member());

        $members_arrears = $unpaidObj->query()
                            ->join('users as u', 'u.id', '=', 'unpaid_members.user_id')
                            ->select([DB::raw("(SUM(COALESCE(u.entitled_amount, 0)) - SUM(COALESCE(unpaid_members.paid_amount, 0))) AS members_arrears"),
                              DB::raw("SUM(unpaid_members.penalty) AS total_penalties"),
                              DB::raw("SUM(unpaid_members.total_arrears) AS total_arrears")])
                            ->whereNotNull('unpaid_members.deleted_at')
                            ->where('pay_status', false)
                            ->get();
        
        $individual_data = $unpaidObj->query()->join('users as u', 'u.id', '=', 'unpaid_members.user_id')
                            ->select([
                                DB::raw('SUM(u.entitled_amount) AS entitled_amount'), 
                                DB::raw('SUM(unpaid_members.paid_amount) AS paid_amount')])
                            ->where('user_id', Auth()->user()->id)
                            ->whereNotNull('unpaid_members.deleted_at')
                            ->first();
        
        $individual_arrears = ($individual_data->entitled_amount - $individual_data->paid_amount);

        return ['members_arrears' => $members_arrears, 'individual_arrears' => $individual_arrears];
    }

    public function outstandingArrearsMembers(){

        $paymentMethods = PaymentMethod::all();


    }

    public function arrearsComputations($request){

        $computational_array = [];

        $pending_arrears = (new Unpaid_member())->query()
                            ->where('user_id', (int)$request->id)
                            ->where('pay_status', false)
                            ->whereNotNull('deleted_at')
                            ->orderBy('created_at', 'ASC')
                            ->get();

        $paid_amount = $request->paid_amount;

        foreach ($pending_arrears as $arrears) {
            // Get previous paid amount or default to 0
            $previous_paid = isset($arrears->paid_amount) ? $arrears->paid_amount : 0;
            // Add the new payment to the previous amount
            $current_total_paid = $previous_paid + $paid_amount;
        
            if ($paid_amount >= $arrears->total_arrears) {

                // Calculate remaining amount for the next arrears
                $paid_amount = $paid_amount - $arrears->total_arrears;
                $total_paid = $previous_paid + $arrears->total_arrears;
                // Case 1 & 2: Fully pay this month and carry over remaining amount
                $arrears->paid_amount = $total_paid; // Full payment for this month
                $arrears->total_arrears = 0; // Full payment for this month
                $arrears->pay_status = true; // Mark as fully paid
                $arrears->save();
        
            } elseif ($paid_amount > 0) {

                if ($paid_amount < $arrears->total_arrears) {

                    $diff = $arrears->total_arrears - $paid_amount;
                }
                // Case 3: Partially pay this month
                $arrears->paid_amount = $current_total_paid; // Update with cumulative payment
                $arrears->pay_status = false; // Not fully paid yet
                $arrears->total_arrears = $diff;
                $arrears->save();
        
                $paid_amount = 0; // All payment exhausted
                break;
            } else {
                // No payment left to process
                break;
            }
        }
        // $computations = (int)DB::table('arrears_general')->where('userid', (int)$request->id)->pluck('total_arrears')[0];
        // dd($computations);

        $latest_update = $arrears->where('user_id', (int)$request->id)->orderBy('updated_at', 'DESC')->first()->id;

        $completed_payments = $arrears->where('user_id', (int)$request->id)
                            ->whereBetween('created_at', [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()])
                            ->orderBy('updated_at', 'DESC')
                            ->first();

        // $computational_array = ['computation' => $computations, 'unpaid_member_id' => $latest_update, 'completed_status' => ($completed_payments->pay_status == true) ? 1:0];

        return $computational_array;
    }

    public function createArrears($data, $arrears_document, $computational_array){

        // dd($computational_array['completed_status']);
        $userID = (int)$data->id;

        $user_instance = User::where('id', $userID)->get();

        DB::transaction(function() use($userID, $arrears_document, $data, $user_instance, $computational_array){
 
            $arrearsPayments = ArrearsPayment::create([
                'payment_type' => 2,
                'user_id' => $userID,
                'document_id' => $arrears_document,
                'paid_amount' => $data->paid_amount,
                'entitled_amount' => $user_instance[0]['entitled_amount'],
                'pay_date' => Carbon::now(),
                'payment_status' => false,
                'payment_method_id' => (int)$data->payment_method,
                'doc_used' => false,
                // 'total_arrears' => $computational_array['computation'],
                'approval_status' => false,
                // 'unpaid_member_id' => $computational_array['unpaid_member_id'],
                // 'completion_status' => $computational_array['completed_status'],
            ]);
                       
                    
        });
        
        $resource_id = ArrearsPayment::where('user_id', $userID)->where('payment_status', false)->where('approval_status', false)->first()->id;

        $input = ['resource_id'=>$resource_id, 'module_id' => (int)$data->module_id, 'module_group_id' => (int)$data->module_group_id, 'user_id' => $userID];

        // $this->PaymentsRepository->initiateWorkflow($input);   

    }

}
