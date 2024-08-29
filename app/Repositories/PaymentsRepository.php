<?php

namespace App\Repositories;

use App\Events\NewWorkflow;
use App\Models\MonthlyPayment;
use App\Repositories\PaymentsRepositoryInterface;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

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

            $previous_contribution = MonthlyPayment::select('total_contributions')
                                    ->where('user_id', (int)$request->id)
                                    ->orderBy('created_at')
                                    ->latest();

            // $total_contribution = $previous_contribution + $request->paid_amount;
                                    
        return true;
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
                event(new NewWorkflow(['wf_module_group_id' => $group, 'resource_id' => $resource, 'type' => $type, 'user' => $user], [], ['comments' => $comments]));
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

}
