<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    protected $model;

    public function __construct(User $model)
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

    public function membership($validation = null){

        $members = null;

        $members = User::where('available', true)
        ->leftJoin('regions as rgn','rgn.id','=', 'users.region_id')
        ->leftJoin('districts as dst', 'dst.id', '=', 'users.district_id')
        ->select('users.*', 'rgn.name as region_name', 'dst.name as district_name')        
        ->get();
        

        return $members;
    }

    public function editable($request, $id){

        $phone = $request->phone;

        if (preg_match('/^0/', $phone)) {

            $phone = preg_replace('/^0/', '+255', $phone);
        }

        $member = $this->find($id);
        DB::transaction(function() use ($member, $request, $phone){
            $member->firstname = $request->firstname;
            $member->middlename = $request->middlename;
            $member->lastname = $request->lastname;
            $member->email = $request->email ?? null;
            $member->phone = $phone ?? null;
            $member->job_title = $request->job_title ?? null;
            $member->region_id = $request->input('regions') ?? null;
            $member->district_id = $request->input('districts') ?? null;
            $member->dob = $request->dob ?? null;
            $member->entitled_amount = $request->entitled_amount;
            $member->unit_id = $request->units ?? null;
            $member->designation_id = $request->designations ?? null;
    
            $member->save();
    });

    }
}
