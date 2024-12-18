<?php

namespace App\Repositories;

interface BaseRepository
{
    public function all();

    public function find($id);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);

    public function storeMonthlyPaymentsDocs($args);
    
    public function monthlyViewDoc($args);
    
    //  function storeArrearsDocuments($args);
    
}


