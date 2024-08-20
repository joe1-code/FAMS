<?php

namespace App\Repositories;

use App\Models\MonthlyPayment;
use App\Repositories\PaymentsRepositoryInterface;
use App\Repositories\BaseRepository;


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

    public function storeMonthlyPaymentsDocs($request)
    {
        // Implement the logic for storing monthly payment documents
        // This is just a placeholder for now
        return true;
    }

}
