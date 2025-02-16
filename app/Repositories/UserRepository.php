<?php

namespace App\Repositories;

use App\Models\Membership\UserParticular;
use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

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

        

        $phone = $request->phone_no;

        $member = $this->find($id);

        if (preg_match('/^0/', $phone)) {
        
            $phone = preg_replace('/^0/', '+255', $phone);
        }

        
        DB::transaction(function() use ($member, $request, $phone, $id){

            try {

             
                // DB::enableQueryLog();

                $member->firstname = $request->firstname;
                $member->middlename = $request->middlename;
                $member->lastname = $request->lastname;
                $member->email = $request->email ?? null;
                $member->phone = $phone ?? null;
                $member->job_title = $request->job_title ?? null;
                $member->region_id = $request->input('regions');
                $member->district_id = $request->input('districts');
                $member->dob = period_format($request->input('dob_day'), $request->input('dob_month'), $request->input('dob_year'));
                $member->entitled_amount = $request->entitled_amount ?? 0;
                $member->unit_id = $request->units ?? null;
                $member->designation_id = $request->designations ?? null;
                
                $member->save();

                 /**
                 * save other data to user_particulars table
                 */

                UserParticular::updateOrCreate(
                    ['user_id' => $id],
                    [
                    'nin' => $request->nida_no ?? null,
                    'country_id' => $request->country,
                    'tin_no' => $request->tin_no ?? null,
                    'passport_no' => $request->passport_no ?? null,
                    'address' => $request->box ?? null,
                    'fax' => $request->fax ?? null,
                    'monthly_earning' => $request->monthly_earning,
                    'location_type' => $request->location,
                    'unsurveyed_area_description' => $request->unsurveyed_area_descrpition ?? null,
                    'road' => $request->road ?? null,
                    'plot_no' => $request->plot ?? null,
                    'block_no' => $request->block ?? null,
                    'street' => $request->Street ?? null,
                    'surveyed_area_description' => $request->surveyed_area_descrpition ?? null,
                    'job_description' => $request->job_description ?? null,
                    'business_name' => $request->business_name ?? null,
                    'business_nature' => $request->business_nature ?? null,
                    'foundation_education' => null,
                    'foundation_start_date' => null,
                    'foundation_end_date' => null,
                    'secondary_education' => null,
                    'secondary_start_date' => null,
                    'secondary_end_date' => null,
                    'college_education' => null,
                    'college_start_date' => null,
                    'college_end_date' => null,
                    'university_education' => $request->university_name ?? null,
                    'university_start_date' => null,
                    'university_end_date' => null,
                    'education_level' => $request->education_level ?? null,
                    'diploma_degree_name' => $request->degree_name ?? null,
                    'edu_completion_date' => period_format($request->input('uni_day'), $request->input('uni_month'), $request->input('uni_year')) ?? null,
                    'family_group_id' => 1,
                ]);

                DB::commit();

            } catch (\Exception $e) {

                Log::info('error occured: ', $e->getMessage());
                throw $e;
            }
           
    });


    }

    public function getMembersForDt(){

        $query = (new User())->query()
        ->leftJoin('regions as rgn','rgn.id','=', 'users.region_id')
        ->leftJoin('districts as dst', 'dst.id', '=', 'users.district_id')
        ->select(                            
            DB::raw("COALESCE(users.firstname, '') || ' ' || COALESCE(users.lastname, '') AS \"fullname\""),
                'users.phone as phone',
                'users.id as user_id',
                'users.dob as dob',
                'users.dod as dod',
                'users.active as membership_status',
                'users.available as available',
                'rgn.name as region_name', 
                'dst.name as district_name'
        )
        ->groupBy('fullname', 'phone', 'dob', 'dod', 'membership_status', 'available', 'region_name', 'district_name', 'user_id')      
        ->get();
        
        return DataTables::of($query)->make(true);
        
    }
}
