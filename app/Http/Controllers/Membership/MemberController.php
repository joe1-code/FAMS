<?php

namespace App\Http\Controllers\Membership;

use App\Http\Controllers\Controller;
use App\Models\Region;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryInterface;
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

        // If validation passes, the code below will execute
        User::create([
            'firstname' => $validatedData['firstname'],
            'middlename' => $validatedData['middlename'],
            'lastname' => $validatedData['lastname'],
            'email' => $validatedData['email'] ?? null,
            'phone' => $validatedData['phone'],
            'password' => $validatedData['password'],
            'username' => $validatedData['firstname'].'.'.$validatedData['lastname'],
            'active' => false,
            'available' => true,
        ]);

        return view('layouts/auth-login');
    }

    public function contributions(){
        
        return view('layouts/contributions');
    }

    public function edit(Request $request){
        // dd($request->input('member_id'));
        $particulars = User::where('users.id', $request->input('member_id'))->join('regions as rgn','rgn.id','=', 'users.region_id')->first();
        // dd($particulars);
        $regions = Region::all();
        // dd($particulars->username);
        return view('layouts/edit_contributions')
        ->with('particulars', $particulars)
        ->with('request', $request)
        ->with('regions', $regions);
    }

    public function submitEditData(Request $request, $id){
        // dd($request->input('regions'), $id);
        try {
            // dd($request->all());
            $this->userRepository->editable($request, $id);

            // return redirect()->route('edit', ['id' => $id])->with('success', 'User has been updated successfully');
            return redirect()->back()->with('success', 'User has been updated successfully');

        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error','An error occured while updating user details');

        }

    }

    
    
}
