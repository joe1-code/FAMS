<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    function getRegions(){
        
        return Region::select('regions.*')->get();
    }

    
}
