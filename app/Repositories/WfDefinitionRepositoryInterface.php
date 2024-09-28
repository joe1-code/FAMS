<?php

namespace App\Repositories;

use App\Exceptions\GeneralException;
use App\Services\Finance\FinYear;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;


interface WfDefinitionRepositoryInterface
{
    
    // public function all();

    public function find($id);

    // public function create(array $data);

    // public function update($id, array $data);

    // public function delete($id);

    public function getNextDefinition($arg1, $arg2, $arg3, $arg4);

    

}
