<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\MonthlyPayment;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{

    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(Request $request){

        $validation = $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ]);

        $user = User::where('username', $validation['username'])->where('active', true)->where('available', true)->first();
        if (Auth::attempt($request->only('username', 'password'), $request->filled('remember')) && isset($user)) {
            // Authentication passed...
              $user = User::where('username', $validation['username'])->first();
              $user->last_login = Carbon::now();
              $user->save();

            $data = $this->userRepository->membership($validation);
             $total_contributions = MonthlyPayment::where('user_id', $user->id)->pluck('total_contributions')->all();

            // dd($data);
            return view('layouts.contributions', ['memberData' => $data, 'username' => $validation['username'], 'contributions' => $total_contributions]);
            // return redirect()->intended(route('contributions'))
            // ->with('memberData', $data);
        }
        elseif (Auth::attempt($request->only('username', 'password'), $request->filled('remember')) && !isset($user)) {
            $login_failed = throw ValidationException::withMessages([
                'username' => [trans('Please Contact your Admin to Activate you.')],
            ]);

            return $login_failed;
            // return redirect()->back()->withFlashDanger('Please Contact your Admin to Activate you.');
        }
        // dump('checks..');

        $login_failed = throw ValidationException::withMessages([
                            'username' => [trans('auth.failed')],
                        ]);

        return $login_failed;
    }

    public function logout(Request $request){
        // dd($request->all());
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
