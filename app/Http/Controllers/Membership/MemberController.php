<?php

namespace App\Http\Controllers\Membership;

use App\Http\Controllers\Controller;
use App\Models\Designation;
use App\Models\District;
use App\Models\MonthlyPayment;
use App\Models\Region;
use App\Models\Unit;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(){
        return view('layouts/auth-register');
    }

    public function registerMember(Request $request) {
        // Validate the request data
        
        $validatedData = $request->validate([
            'firstname' => 'required|string|max:255',
            'middlename' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            // 'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:15',
            'password' => 'required|string|min:8',
        ]);

        $phone = $validatedData['phone'];

        if (preg_match('/^0/', $phone)) {

            $phone = preg_replace('/^0/', '+255', $phone);
        }

        User::create([
            'firstname' => $validatedData['firstname'],
            'middlename' => $validatedData['middlename'],
            'lastname' => $validatedData['lastname'],
            'email' => $request->email ?? null,
            'phone' => $phone,
            'password' => $validatedData['password'],
            'username' => $validatedData['firstname'].'.'.$validatedData['lastname'],
            'active' => false,
            'available' => true,
        ]);

        return redirect()->back()->with('success', 'The user data has been registered successfully');
    }

    public function contributions(){
        
        return view('layouts/contributions');
    }

    public function edit(Request $request){
        // dd($request->input('member_id'));
        $particulars = User::where('users.id', $request->input('member_id'))
        ->leftJoin('regions as rgn','rgn.id','=', 'users.region_id')
        ->leftJoin('districts as dst', 'dst.id', '=', 'users.district_id')
        ->join('units as unit', 'unit.id', '=', 'users.unit_id')
        ->join('designations as desgn', 'desgn.id', '=', 'users.designation_id')
        ->select('users.*', 'rgn.name as region_name', 'dst.name as district_name')
        ->first();
        // dd($particulars);
        $regions = Region::all();
        $districts = District::all();

        // dd(, );
        return view('layouts/edit_contributions')
                ->with('particulars', $particulars)
                ->with('request', $request)
                ->with('regions', $regions)
                ->with('districts', $districts)
                ->with('units', Unit::all())
                ->with('designations', Designation::all());
    }

    public function submitEditData(Request $request, $id){
        // dd($request->input('regions'), $id);
        try {
            // dd($request->all());
            $this->userRepository->editable($request, $id);

            // return redirect()->route('edit', ['id' => $id])->with('success', 'User has been updated successfully');
            return redirect()->back()->with('success', 'User has been updated successfully');

        } catch (\Exception $e) {
            // dd($e);
            return redirect()->back()->with('error','An error occured while updating user details');

        }

    }

    public function members(){

        $members = User::ActiveMembers()->get();
        $entitled_amount = $members->where('id', Auth()->user()->id)->pluck('entitled_amount');
        $UTT_deposit = MonthlyPayment::where('payment_method_id', 2)->sum('paid_amount');
        // dd(Carbon::now()->format('m'));
        $monthly_earnings = MonthlyPayment::whereMonth('pay_date', Carbon::now()->month)->whereYear('pay_date', Carbon::now()->year)->where('payment_status', 0)->sum('paid_amount');
        // dd($monthly_earnings);

        return view('layouts/contributions')
                ->with('memberData', $members)
                ->with('average_amount', number_2_format($entitled_amount[0]))
                ->with('utt_amis', number_2_format($UTT_deposit))
                ->with('earnings', number_2_format($monthly_earnings));
    }

    public function monthlyPayments(){


        return view('contributions/monthly_payments');
    }

    
    
}
