<?php

namespace App\Repositories;

use App\Models\CurrentMonthlyArrear;
use App\Models\User;
use App\Repositories\TinkerRepositoryInterface;
use Illuminate\Support\Facades\DB;

class TinkerRepository implements TinkerRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    protected $model;

    public function __construct()
    {
        // $this->model = $model;
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

    // public function currentMembersArrears(){

    //     $current_monthly_members = access()
    //                         ->where('active', 1)->get();
    //     dd($current_monthly_members);
    //     DB::transaction(function() use($current_monthly_members){

    //         foreach ($current_monthly_members as $data) {
              
    //             CurrentMonthlyArrear::createOrUpdate([
    //                 'user_id' => $data
    //            ]);
    //         }
    //     });

    // }

}
