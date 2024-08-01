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

    public function membership($validation){
        $members = User::where('available', true)->where('active', true)->get();
        // dd($members);

        return $members;
    }

    public function editable($request, $id){
        
        $member = $this->find($id);
        DB::transaction(function() use ($member, $request){
            $member->firstname = $request->firstname;
            $member->middlename = $request->middlename;
            $member->lastname = $request->lastname;
            $member->email = $request->email ?? null;
            $member->phone = $request->phone ?? null;
            $member->job_title = $request->job_title ?? null;
            $member->region_id = $request->input('regions') ?? null;
            $member->district_id = $request->district ?? null;
            $member->dob = $request->dob ?? null;
    
            $member->save();
    });

    }
}
