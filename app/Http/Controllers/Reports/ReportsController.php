<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Designation;
use App\Models\District;
use App\Models\Membership\UserParticular;
use App\Models\MonthlyPayment;
use App\Models\Region;
use App\Models\Unit;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function generateReports(){

        return view('reports/reports');
    }

    public function getReportsDt(){

        return view('reports/reports');
    }    
    
}
