<?php

namespace App\Repositories;

use App\Events\NewWorkflow;
use App\Models\MonthlyPayment;
use App\Models\Unpaid_member;
use App\Models\Workflow\Wf_definition;
use App\Models\Workflow\WfTrack;
use App\Repositories\PaymentsRepositoryInterface;
use App\Repositories\BaseRepository;
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
        // dd($input);

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
                                                  DB::raw("SUM(u.entitled_amount) AS arrears"), 
                                                  DB::raw("MAX(unpaid_members.created_at) AS latest_month"))
                                        ->where('pay_status', 0)
                                        ->whereNotNull('unpaid_members.deleted_at')
                                        ->groupBy('u.id', 'fullname', 'region_name', 'district_name')
                                        ->get();

        return DataTables::of($query)->make(true);
    }

}
